[{$smarty.block.parent}]

<script>
    if (window.EnderecoIntegrator && window.EnderecoIntegrator.initEmailServices) {
        window.EnderecoIntegrator.waitUntilReady().then(function() {
            window.EnderecoIntegrator.initEmailServices(
                    {
                        'email': 'order"] [name="lgn_usr'
                    }
            );
        }).catch();
    } else if (window.EnderecoIntegrator && !window.EnderecoIntegrator.initEmailServices && window.EnderecoIntegrator.asyncCallbacks) {
        window.EnderecoIntegrator.waitUntilReady().then(function() {
            window.EnderecoIntegrator.initEmailServices(
                {
                    'email': 'order"] [name="lgn_usr'
                }
            );
        }).catch();
    } else {
        window.EnderecoIntegrator = {
            asyncCallbacks: []
        };
        window.EnderecoIntegrator.asyncCallbacks.push(function() {
            window.EnderecoIntegrator.waitUntilReady().then(function() {
                window.EnderecoIntegrator.initEmailServices(
                    {
                        'email': 'order"] [name="lgn_usr'
                    }
                );
            }).catch();
        });
    }
</script>
