<input type="hidden" name="deladr[oxaddress__mojoamsts]" value="[{if isset( $deladr.oxaddress__mojoamsts )}][{$deladr.oxaddress__mojoamsts}][{else}][{$delivadr->oxaddress__mojoamsts->value}][{/if}]">
<input type="hidden" name="deladr[oxaddress__mojoamsstatus]" value="[{if isset( $deladr.oxaddress__mojoamsstatus )}][{$deladr.oxaddress__mojoamsstatus}][{else}][{$delivadr->oxaddress__mojoamsstatus->value}][{/if}]">
<input type="hidden" name="deladr[oxaddress__mojoamspredictions]" value="[{if isset( $deladr.oxaddress__mojoamspredictions )}][{$deladr.oxaddress__mojoamspredictions}][{else}][{$delivadr->oxaddress__mojoamspredictions->value}][{/if}]">
[{$smarty.block.parent}]

<script>
    ( function() {
        var $interval = setInterval( function() {
            if (window.EnderecoIntegrator && window.EnderecoIntegrator.ready) {
                var EAO = window.EnderecoIntegrator.initAMS(
                    'deladr[oxaddress__',
                    {
                        name: 'shipping',
                        addressType: 'shipping_address'
                    }
                );

                EAO.waitForAllExtension().then( function(EAO) {
                    EAO.onAfterModalRendered.push(function(EAO) {
                        if (!document.querySelector('[name="deladr[oxaddress__oxcountryid]"]').offsetParent) {
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
                    })
                }).catch();

                window.EnderecoIntegrator.initPersonServices('deladr[oxaddress__');
                clearInterval($interval);
            }
        }, 100);
    })();
</script>
