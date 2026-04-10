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

// Transforms the internal OXID state ID (from the states select element) into an
// ISO 3166-2 subdivision code that the JS-SDK and Endereco WebAPI expect.
//
// During initial page load and AMS object initiation, the states <select> may not
// be populated with <option> elements yet. In that case, we fall back to a helper
// DOM element injected by the module that carries the selected state ID and country
// ID as data attributes, allowing us to resolve correctly before the select is ready.
EnderecoIntegrator.resolvers.subdivisionCodeRead = async function (value, subscriber) {
    // Resolve country code. The SDK may not have it yet during init,
    // so fall back to the helper element's country ID.
    var countryCode = subscriber._subject.countryCode?.toUpperCase() || '';
    if (!countryCode && subscriber._subject.fullName) {
        const helper = document.querySelector(
            '[data-endereco-subdivision-helper="' + subscriber._subject.fullName + '"]'
        );
        if (helper && helper.dataset.countryId) {
            countryCode = await EnderecoIntegrator.resolvers.countryCodeRead(
                helper.dataset.countryId, subscriber
            );
            countryCode = countryCode?.toUpperCase() || '';
        }
    }

    if (!countryCode) {
        return '';
    }

    // If the select has no value yet (not populated), try the helper element as fallback.
    var effectiveValue = value;
    if (!effectiveValue && subscriber._subject.fullName) {
        const helper = document.querySelector(
            '[data-endereco-subdivision-helper="' + subscriber._subject.fullName + '"]'
        );
        if (helper) {
            effectiveValue = helper.dataset.selectedStateId || '';
        }
    }

    if (!effectiveValue) {
        return '';
    }

    const mapping = window.EnderecoIntegrator?.subdivisionMappingReverse || {};
    const submapping = mapping[countryCode] || {};
    const key = submapping[effectiveValue];
    return key !== undefined ? key : '';
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

EnderecoIntegrator.hasActiveSubscriber = (fieldName, domElement, dataObject) => {
    if (fieldName === 'subdivisionCode') {
        // Check helper element first — it knows server-side whether the country has states,
        // even before OXID's JS populates the select with options.
        const helper = document.querySelector(
            '[data-endereco-subdivision-helper="' + dataObject.fullName + '"]'
        );
        if (helper) {
            const countryId = helper.dataset.countryId || '';
            const mapping = window.EnderecoIntegrator?.subdivisionMappingReverse || {};
            const countryCode = window.EnderecoIntegrator?.countryMappingReverse?.[countryId] || '';
            if(countryCode){
                return !!mapping[countryCode] && Object.keys(mapping[countryCode]).length > 0;
            }
        }

        // Fallback: check the select's options directly (no helper available).
        if (domElement && domElement.tagName === 'SELECT') {
            const mapping = window.EnderecoIntegrator?.subdivisionMappingReverse || {};
            const selectState = checkSelectValuesAgainstMapping(
                domElement,
                mapping[dataObject.countryCode] || {}
            );
            return selectState.hasValidOptions && selectState.allValuesInMapping;
        }
    }

    return true;
};


/**
 * @function checkSelectValuesAgainstMapping
 * @description Validates the <option> elements within a given <select> element against a provided mapping object.
 * It determines if the select element contains any "valid" options (non-disabled, with a non-empty value)
 * and checks if the values of all such valid options exist as keys within the mapping object.
 *
 * @param {HTMLSelectElement | null | undefined} domElementOfSelect - The <select> DOM element whose options should be checked.
 * The function handles null or undefined input gracefully by returning the default result structure.
 * @param {object} mappingObject - The JavaScript object used as a reference map. The function checks
 * if the `value` attribute of the valid options exists as a key in this object.
 * It expects this to be a non-null object for the mapping check to work correctly.
 *
 * @returns {{
 * hasValidOptions: boolean,
 * allValuesInMapping: boolean,
 * missingValues: string[],
 * allOptionValues: string[]
 * }} An object containing the results of the validation:
 * - `hasValidOptions`: `true` if the select element has at least one option that is not disabled and has a non-empty value; `false` otherwise.
 * - `allValuesInMapping`: `true` if `hasValidOptions` is true AND every valid option's value exists as a key in `mappingObject`; `false` otherwise.
 * - `missingValues`: An array of strings containing the values of valid options that were *not* found as keys in `mappingObject`. Empty if all values are found or if `hasValidOptions` is false.
 * - `allOptionValues`: An array of strings containing the values of *all* valid options found in the select element. Empty if `hasValidOptions` is false.
 */
const checkSelectValuesAgainstMapping = (domElementOfSelect, mappingObject) => {
    // Initialize default return structure
    const result = {
        hasValidOptions: false,
        allValuesInMapping: false,
        missingValues: [],
        allOptionValues: []
    };

    // Check if select element exists
    if (!domElementOfSelect) {
        return result;
    }

    const options = domElementOfSelect.options;
    const optionValues = [];

    // Process all valid options
    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        if (option.value && !option.disabled) {
            result.hasValidOptions = true;
            optionValues.push(option.value);
        }
    }

    // Set allOptionValues regardless of whether options are valid
    result.allOptionValues = optionValues;

    // Find missing values only if we have valid options
    if (result.hasValidOptions) {
        for (const value of optionValues) {
            if (!Object.prototype.hasOwnProperty.call(mappingObject, value)) {
                result.missingValues.push(value);
            }
        }

        result.allValuesInMapping = result.missingValues.length === 0;
    }

    return result;
}

/**
 * This function is needed to simulate blur, change and other events for better compatibility with frontend validation
 * frameworks and some themes that expect those events. Without it endereco js-sdk would set some field without
 * third party actors realising it, which lead to broken UX sometimes.
 *
 * @param DOMElement
 * @param addressObject
 */
window.EnderecoIntegrator.prepareDOMElement = (DOMElement, addressObject) => {
    // Check if the element has already been prepared
    if (DOMElement._enderecoBlurListenerAttached) {
        return; // Skip if already prepared
    }

    const enderecoBlurListener = async (e) => {
        // Wait for any active prediction applications to complete
        if (addressObject && addressObject.waitForPredictionApplication) {
            await addressObject.waitForPredictionApplication();
        }

        // Dispatch 'focus' and 'blur' events on the target element
        const prevActiveElement = document.activeElement;
        e.target.dispatchEvent(new CustomEvent('focus', { bubbles: true, cancelable: true }));
        e.target.dispatchEvent(new CustomEvent('blur', { bubbles: true, cancelable: true }));
        prevActiveElement.dispatchEvent(new CustomEvent('focus', { bubbles: true, cancelable: true }));
    }

    DOMElement.addEventListener('endereco-blur', enderecoBlurListener);

    // Mark the element as prepared
    DOMElement._enderecoBlurListenerAttached = true;
}

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
