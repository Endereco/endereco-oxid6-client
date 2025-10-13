<input type="hidden" name="invadr[oxuser__mojoamsts]" value="[{if isset( $invadr.oxuser__mojoamsts )}][{$invadr.oxuser__mojoamsts}][{else}][{$oxcmp_user->oxuser__mojoamsts->value}][{/if}]">
<input type="hidden" name="invadr[oxuser__mojoamsstatus]" value="[{if isset( $invadr.oxuser__mojoamsstatus )}][{$invadr.oxuser__mojoamsstatus}][{else}][{$oxcmp_user->oxuser__mojoamsstatus->value}][{/if}]">
<input type="hidden" name="invadr[oxuser__mojoamspredictions]" value="[{if isset( $invadr.oxuser__mojoamspredictions )}][{$invadr.oxuser__mojoamspredictions}][{else}][{$oxcmp_user->oxuser__mojoamspredictions->value}][{/if}]">

<input type="hidden" name="invadr[oxuser__mojonamescore]" value="[{if isset( $invadr.oxuser__mojonamescore )}][{$invadr.oxuser__mojonamescore}][{else}][{$oxcmp_user->oxuser__mojonamescore->value}][{/if}]">
[{$smarty.block.parent}]

<script>

    ( function() {

        function afterCreateHandler(EAO) {

            if (!EAO) {
                return;
            }

            if (EAO) {

                EAO.onAfterModalRendered.push(function (EAO) {
                    if (!document.querySelector('[name="invadr[oxuser__oxzip]"]').offsetParent) {
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

            window.EnderecoIntegrator.initPersonServices(
                'invadr[oxuser__',
                {
                    name: 'billing',
                }
            );
        }

        enderecoInitAMS(
            {
                countryCode: '[name="invadr[oxuser__oxcountryid]"]',
                postalCode: '[name="invadr[oxuser__oxzip]"]',
                locality: '[name="invadr[oxuser__oxcity]"]',
                streetName: '[name="invadr[oxuser__oxstreet]"]',
                buildingNumber: '[name="invadr[oxuser__oxstreetnr]"]',
                additionalInfo: '[name="invadr[oxuser__oxaddinfo]"]',
                addressStatus: '[name="invadr[oxuser__mojoamsstatus]"]',
                addressTimestamp: '[name="invadr[oxuser__mojoamsts]"]',
                addressPredictions: '[name="invadr[oxuser__mojoamspredictions]"]'
            },
            {
                name: 'billing',
                addressType: 'billing_address',
                intent: 'edit',
            },
            afterCreateHandler
        );

    })();

</script>

