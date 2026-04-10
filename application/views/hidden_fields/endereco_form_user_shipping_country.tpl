<input type="hidden"
    data-endereco-subdivision-helper="shipping_ams"
    data-country-id="[{$delivadr->oxaddress__oxcountryid->value}]"
    data-selected-state-id="[{$delivadr->oxaddress__oxstateid->value}]"
>
<input type="hidden" name="deladr[oxaddress__mojoamsts]" value="[{if isset( $deladr.oxaddress__mojoamsts )}][{$deladr.oxaddress__mojoamsts}][{else}][{$delivadr->oxaddress__mojoamsts->value}][{/if}]">
<input type="hidden" name="deladr[oxaddress__mojoamsstatus]" value="[{if isset( $deladr.oxaddress__mojoamsstatus )}][{$deladr.oxaddress__mojoamsstatus}][{else}][{$delivadr->oxaddress__mojoamsstatus->value}][{/if}]">
<input type="hidden" name="deladr[oxaddress__mojoamspredictions]" value="[{if isset( $deladr.oxaddress__mojoamspredictions )}][{$deladr.oxaddress__mojoamspredictions}][{else}][{$delivadr->oxaddress__mojoamspredictions->value}][{/if}]">

<input type="hidden" name="deladr[oxaddress__mojonamescore]" value="[{if isset( $deladr.oxaddress__mojonamescore )}][{$deladr.oxaddress__mojonamescore}][{else}][{$delivadr->oxaddress__mojonamescore->value}][{/if}]">
[{$smarty.block.parent}]

<script>
    ( function() {

        function afterCreateHandler(EAO) {

            if (!EAO) {
                return;
            }

            if (EAO) {

                EAO.onAfterModalRendered.push(function (EAO) {
                    if (!document.querySelector('[name="deladr[oxaddress__oxzip]"]').offsetParent) {
                        if ('billing_address' === EAO.addressType) {
                            if (document.querySelector('#userChangeAddress')) {
                                document.querySelector('#userChangeAddress').click();
                            }
                        } else if ('shipping_address' === EAO.addressType) {
                            if (document.querySelector('.dd-available-addresses .dd-edit-shipping-address')) {
                                document.querySelector('.dd-available-addresses .dd-edit-shipping-address').click();
                            }
                        }
                    }
                });

            }
        }

        var shippingAmsInitialized = false;

        function initShippingAMS(triggerCheck) {
            if (shippingAmsInitialized) {
                return;
            }
            shippingAmsInitialized = true;

            enderecoInitAMS(
                {
                    countryCode: '[name="deladr[oxaddress__oxcountryid]"]',
                    subdivisionCode: '[name="deladr[oxaddress__oxstateid]"]',
                    postalCode: '[name="deladr[oxaddress__oxzip]"]',
                    locality: '[name="deladr[oxaddress__oxcity]"]',
                    streetName: '[name="deladr[oxaddress__oxstreet]"]',
                    buildingNumber: '[name="deladr[oxaddress__oxstreetnr]"]',
                    additionalInfo: '[name="deladr[oxaddress__oxaddinfo]"]',
                    addressStatus: '[name="deladr[oxaddress__mojoamsstatus]"]',
                    addressTimestamp: '[name="deladr[oxaddress__mojoamsts]"]',
                    addressPredictions: '[name="deladr[oxaddress__mojoamspredictions]"]'
                },
                {
                    name: 'shipping_ams',
                    addressType: 'shipping_address',
                    intent: 'edit',
                },
                function(EAO) {
                    afterCreateHandler(EAO);
                    if (triggerCheck && EAO && EAO.util && EAO.util.checkAddress) {
                        EAO.util.checkAddress();
                    }
                }
            );
        }

        function isCountryFieldVisible() {
            var field = document.querySelector('[name="deladr[oxaddress__oxcountryid]"]');
            return field && field.offsetParent !== null;
        }

        if (isCountryFieldVisible()) {
            initShippingAMS(false);
        } else {
            var visibilityObserver = new MutationObserver(function() {
                if (isCountryFieldVisible()) {
                    visibilityObserver.disconnect();
                    initShippingAMS(true);
                }
            });
            visibilityObserver.observe(document.body, {
                attributes: true,
                attributeFilter: ['style', 'class'],
                subtree: true,
                childList: true
            });
        }

        enderecoInitPS(
            'deladr[oxaddress__',
            {
                name: 'shipping',
            }
        );

    })();

</script>
