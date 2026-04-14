import Promise from 'promise-polyfill';
import merge from 'lodash.merge';
import EnderecoIntegrator from './node_modules/@endereco/js-sdk/modules/integrator';
import css from './endereco.scss';
import 'polyfill-array-includes';

if ('NodeList' in window && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = function (callback, thisArg) {
        thisArg = thisArg || window;
        for (var i = 0; i < this.length; i++) {
            callback.call(thisArg, this[i], i, this);
        }
    };
}

if (!window.Promise) {
    window.Promise = Promise;
}

EnderecoIntegrator.postfix = {
    ams: {
        countryCode: 'oxcountryid]',
        postalCode: 'oxzip]',
        subdivisionCode: 'oxstateid]',
        locality: 'oxcity]',
        streetFull: '',
        streetName: 'oxstreet]',
        buildingNumber: 'oxstreetnr]',
        addressStatus: 'mojoamsstatus]',
        addressTimestamp: 'mojoamsts]',
        addressPredictions: 'mojoamspredictions]',
        additionalInfo: 'oxaddinfo]',
    },
    personServices: {
        salutation: 'oxsal]',
        firstName: 'oxfname]',
        lastName: 'oxlname]',
        nameScore: 'mojonamescore]'
    },
    emailServices: {
        email: '#userLoginName'
    }
};

EnderecoIntegrator.css = css[0][1];
EnderecoIntegrator.resolvers.countryCodeWrite = function (value, subscriber) {
    return new Promise(function (resolve, reject) {
        resolve(window.EnderecoIntegrator.countryMapping[value.toUpperCase()]);
    });
}
EnderecoIntegrator.resolvers.countryCodeRead = function (value, subscriber) {
    return new Promise(function (resolve, reject) {
        resolve(window.EnderecoIntegrator.countryMappingReverse[value]);
    });
}

EnderecoIntegrator.resolvers.subdivisionCodeWrite = function (value, subscriber) {
    return new Promise(resolve => {
        if (!value) {
            resolve('');
            return;
        }

        const mapping = window.EnderecoIntegrator?.subdivisionMapping || {};
        const key = mapping[value];
        resolve(key !== undefined ? key : '');
    });
}

EnderecoIntegrator.resolvers.subdivisionCodeRead = function (value, subscriber) {
    return new Promise(function (resolve) {
        const countryCode = subscriber._subject.countryCode?.toUpperCase() || '';

        if (!countryCode || !value) {
            resolve('');
            return;
        }

        const mapping = window.EnderecoIntegrator?.subdivisionMappingReverse || {};
        const submapping = mapping[countryCode] || {};
        const key = submapping[value];
        resolve(key !== undefined ? key : '');
    });
}

EnderecoIntegrator.resolvers.countryCodeSetValue = function (subscriber, value) {
    if (
        !!$ &&
        subscriber.object &&
        subscriber.object.classList.contains('selectpicker') &&
        !!$(subscriber.object).selectpicker
    ) {
        $(subscriber.object).selectpicker('val', value);
    } else {
        subscriber.object.value = value;
    }

    if (!!$) {
        $(subscriber.object).trigger('change');
    }
}

EnderecoIntegrator.resolvers.subdivisionCodeSetValue = function (subscriber, value) {
    if (
      !!$ &&
      subscriber.object &&
      subscriber.object.classList.contains('selectpicker') &&
      !!$(subscriber.object).selectpicker
    ) {
        $(subscriber.object).selectpicker('val', value);
    } else {
        subscriber.object.value = value;
    }

    if (!!$) {
        $(subscriber.object).trigger('change');
    }
}

EnderecoIntegrator.resolvers.salutationWrite = function (value, subscriber) {
    var mapping = {
        'f': 'MRS',
        'm': 'MR'
    };
    return new Promise(function (resolve, reject) {
        resolve(mapping[value]);
    });
}
EnderecoIntegrator.resolvers.salutationRead = function (value, subscriber) {
    var mapping = {
        'MRS': 'f',
        'MR': 'm'
    };
    return new Promise(function (resolve, reject) {
        resolve(mapping[value]);
    });
}

EnderecoIntegrator.resolvers.salutationSetValue = function (subscriber, value) {
    if (
        !!$ &&
        subscriber.object &&
        subscriber.object.classList.contains('selectpicker') &&
        !!$(subscriber.object).selectpicker
    ) {
        $(subscriber.object).selectpicker('val', value);
    } else {
        subscriber.object.value = value;
    }
}

EnderecoIntegrator.afterAMSActivation.push( function(EAO) {
    if (!!document.querySelector('[type="checkbox"][name="blshowshipaddress"]')) {
        if (document.querySelector('[type="checkbox"][name="blshowshipaddress"]').checked) {
            if ('shipping_address' === EAO.addressType) {
                EAO.active = false;
            }
        }
        document.querySelector('[type="checkbox"][name="blshowshipaddress"]').addEventListener('change', function(e) {
            if ('shipping_address' === EAO.addressType) {
                EAO.active = !document.querySelector('[type="checkbox"][name="blshowshipaddress"]').checked;
            }
        });
    }
});

if (window.EnderecoIntegrator) {
    window.EnderecoIntegrator = merge(EnderecoIntegrator, window.EnderecoIntegrator);
} else {
    window.EnderecoIntegrator = EnderecoIntegrator;
}

window.EnderecoIntegrator.asyncCallbacks.forEach(function (cb) {
    cb();
});
window.EnderecoIntegrator.asyncCallbacks = [];

window.EnderecoIntegrator.waitUntilReady().then(function () {
    //
});

window.EnderecoIntegrator.isAddressFormStillValid = (EAO) => {
    if (EAO.fullName !== 'shipping_ams') {
        return true;
    }

    // Check if EAO.forms exists and is an array
    if (EAO.forms && Array.isArray(EAO.forms)) {
        // Loop through each form in the forms array
        for (let i = 0; i < EAO.forms.length; i++) {
            const form = EAO.forms[i];

            // Check if the form is a DOM element
            if (form instanceof Element) {
                // Look for a checkbox with name "blshowshipaddress"
                const disableCheckbox = form.querySelector('input[type="checkbox"][name="blshowshipaddress"]');

                // If the checkbox exists and is checked, return false
                if (disableCheckbox && disableCheckbox.checked) {
                    return false;
                }
            }
        }
    }

    return true;
}

const waitForConfig = setInterval(function () {
    if (typeof enderecoLoadAMSConfig === 'function') {
        try {
            enderecoLoadAMSConfig();
            clearInterval(waitForConfig);
        } catch (error) {
            console.error('Failed to execute enderecoLoadAMSConfig:', error);
            clearInterval(waitForConfig);
        }
    }
}, 100);
