<input type="hidden" name="invadr[oxuser__mojoamsts]" value="[{if isset( $invadr.oxuser__mojoamsts )}][{$invadr.oxuser__mojoamsts}][{else}][{$oxcmp_user->oxuser__mojoamsts->value}][{/if}]">
<input type="hidden" name="invadr[oxuser__mojoamsstatus]" value="[{if isset( $invadr.oxuser__mojoamsstatus )}][{$invadr.oxuser__mojoamsstatus}][{else}][{$oxcmp_user->oxuser__mojoamsstatus->value}][{/if}]">
[{$smarty.block.parent}]

<script>
    function initInvoiceAMS() {
        var integratedObject = window.EnderecoIntegrator.initAMS('invadr[oxuser');
    }
    if (window.EnderecoIntegrator && window.EnderecoIntegrator.initAMS) {
        window.EnderecoIntegrator.waitUntilReady().then(initInvoiceAMS).catch();
    } else if (window.EnderecoIntegrator && !window.EnderecoIntegrator.initAMS && window.EnderecoIntegrator.asyncCallbacks) {
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(initInvoiceAMS).catch();
        });
    } else {
        window.EnderecoIntegrator = {
            asyncCallbacks: []
        };
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(initInvoiceAMS).catch();
        });
    }
</script>

<script>
    if (window.EnderecoIntegrator && window.EnderecoIntegrator.initPersonServices) {
        window.EnderecoIntegrator.waitUntilReady().then(function() {
            window.EnderecoIntegrator.initPersonServices('invadr[oxuser');
        }).catch();
    } else if (window.EnderecoIntegrator && !window.EnderecoIntegrator.initPersonServices && window.EnderecoIntegrator.asyncCallbacks) {
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(function() {
                window.EnderecoIntegrator.initPersonServices('invadr[oxuser');
            }).catch();
        });
    } else {
        window.EnderecoIntegrator = {
            asyncCallbacks: []
        };
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(function() {
                window.EnderecoIntegrator.initPersonServices('invadr[oxuser');
            }).catch();
        });
    }
</script>
