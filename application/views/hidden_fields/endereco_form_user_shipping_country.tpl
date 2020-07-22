<input type="hidden" name="deladr[oxaddress__mojoamsts]" value="[{if isset( $deladr.oxaddress__mojoamsts )}][{$deladr.oxaddress__mojoamsts}][{else}][{$delivadr->oxaddress__mojoamsts->value}][{/if}]">
<input type="hidden" name="deladr[oxaddress__mojoamsstatus]" value="[{if isset( $deladr.oxaddress__mojoamsstatus )}][{$deladr.oxaddress__mojoamsstatus}][{else}][{$delivadr->oxaddress__mojoamsstatus->value}][{/if}]">
[{$smarty.block.parent}]

<script>
    if (window.EnderecoIntegrator && window.EnderecoIntegrator.initAMS) {
        window.EnderecoIntegrator.waitUntilReady().then(function() {
            window.EnderecoIntegrator.initAMS('deladr[oxaddress');
        }).catch();
    } else if (window.EnderecoIntegrator && !window.EnderecoIntegrator.initAMS && window.EnderecoIntegrator.asyncCallbacks) {
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(function() {
                window.EnderecoIntegrator.initAMS('deladr[oxaddress');
            }).catch();
        });
    } else {
        window.EnderecoIntegrator = {
            asyncCallbacks: []
        };
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(function() {
                window.EnderecoIntegrator.initAMS('deladr[oxaddress');
            }).catch();
        });
    }
</script>

<script>
    if (window.EnderecoIntegrator && window.EnderecoIntegrator.initPersonServices) {
        window.EnderecoIntegrator.waitUntilReady().then(function() {
            window.EnderecoIntegrator.initPersonServices('deladr[oxaddress');
        }).catch();
    } else if (window.EnderecoIntegrator && !window.EnderecoIntegrator.initPersonServices && window.EnderecoIntegrator.asyncCallbacks) {
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(function() {
                window.EnderecoIntegrator.initPersonServices('deladr[oxaddress');
            }).catch();
        });
    } else {
        window.EnderecoIntegrator = {
            asyncCallbacks: []
        };
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(function() {
                window.EnderecoIntegrator.initPersonServices('deladr[oxaddress');
            }).catch();
        });
    }
</script>
