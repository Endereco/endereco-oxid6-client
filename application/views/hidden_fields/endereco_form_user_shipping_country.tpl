<input type="hidden" name="deladr[oxaddress__mojoamsts]" value="[{if isset( $deladr.oxaddress__mojoamsts )}][{$deladr.oxaddress__mojoamsts}][{else}][{$delivadr->oxaddress__mojoamsts->value}][{/if}]">
<input type="hidden" name="deladr[oxaddress__mojoamsstatus]" value="[{if isset( $deladr.oxaddress__mojoamsstatus )}][{$deladr.oxaddress__mojoamsstatus}][{else}][{$delivadr->oxaddress__mojoamsstatus->value}][{/if}]">
[{$smarty.block.parent}]

<script>
    ( function() {
        var $interval = setInterval( function() {
            if (window.EnderecoIntegrator && window.EnderecoIntegrator.ready) {
                window.EnderecoIntegrator.initAMS('deladr[oxaddress');
                window.EnderecoIntegrator.initPersonServices('deladr[oxaddress');
                clearInterval($interval);
            }
        }, 100);
    })();
</script>
