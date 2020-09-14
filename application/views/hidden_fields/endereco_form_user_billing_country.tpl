<input type="hidden" name="invadr[oxuser__mojoamsts]" value="[{if isset( $invadr.oxuser__mojoamsts )}][{$invadr.oxuser__mojoamsts}][{else}][{$oxcmp_user->oxuser__mojoamsts->value}][{/if}]">
<input type="hidden" name="invadr[oxuser__mojoamsstatus]" value="[{if isset( $invadr.oxuser__mojoamsstatus )}][{$invadr.oxuser__mojoamsstatus}][{else}][{$oxcmp_user->oxuser__mojoamsstatus->value}][{/if}]">
[{$smarty.block.parent}]

<script>
    ( function() {
        var $interval = setInterval( function() {
            if (window.EnderecoIntegrator && window.EnderecoIntegrator.ready) {
                window.EnderecoIntegrator.initAMS('invadr[oxuser');
                window.EnderecoIntegrator.initPersonServices('invadr[oxuser');
                clearInterval($interval);
            }
        }, 100);
    })();
</script>

