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
EnderecoIntegrator.resolvers.countryCodeWrite = function (value) {
    return new Promise(function (resolve, reject) {
        resolve(window.EnderecoIntegrator.countryMapping[value.toLowerCase()]);
    });
}
EnderecoIntegrator.resolvers.countryCodeRead = function (value) {
    return new Promise(function (resolve, reject) {
        resolve(window.EnderecoIntegrator.countryMappingReverse[value.toLowerCase()]);
    });
}

EnderecoIntegrator.resolvers.subdivisionCodeWrite = function (value, EAO) {
    return new Promise(function (resolve, reject) {
        var key = window.EnderecoIntegrator.subdivisionMapping[value.toUpperCase()];
        if (key !== undefined) {
            resolve(window.EnderecoIntegrator.subdivisionMapping[value.toUpperCase()]);
        } else {
            resolve('');
        }
    });
}
EnderecoIntegrator.resolvers.subdivisionCodeRead = function (value, EAO) {
    return new Promise(function (resolve, reject) {
        var key = window.EnderecoIntegrator.subdivisionMappingReverse[EAO.countryCode.toUpperCase() + '-' + value.toUpperCase()];
        if (key !== undefined) {
            resolve(window.EnderecoIntegrator.subdivisionMappingReverse[EAO.countryCode.toUpperCase() + '-' + value.toUpperCase()]);
        } else {
            resolve('');
        }
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

EnderecoIntegrator.resolvers.salutationWrite = function (value) {
    var mapping = {
        'f': 'MRS',
        'm': 'MR'
    };
    return new Promise(function (resolve, reject) {
        resolve(mapping[value]);
    });
}
EnderecoIntegrator.resolvers.salutationRead = function (value) {
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

