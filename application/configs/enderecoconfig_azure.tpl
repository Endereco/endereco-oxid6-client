[{assign var="sitepath" value=$oViewConf->getBaseDir()}]

[{if !$enderecoclient.bAllowControllerFilter || $enderecoclient.sControllerClass|in_array:$enderecoclient.aAllowedControllerClasses }]
    <script async defer src="[{$oViewConf->getModuleUrl('endereco-oxid6-client', 'out/assets/js/oxid6-bundle.js')}]"></script>

    [{if $enderecoclient.bUseCss }]
        <link rel="stylesheet" href="[{$oViewConf->getModuleUrl('endereco-oxid6-client', 'out/assets/css/oxid-azure.css')}]">
    [{/if}]

    [{assign var="popUpHeadline" value="ENDERECOOXID6CLIENT_POPUP_HEADLINE"|oxmultilangassign}]
    [{assign var="popUpSubline" value="ENDERECOOXID6CLIENT_POPUP_SUBLINE"|oxmultilangassign}]
    [{assign var="yourInput" value="ENDERECOOXID6CLIENT_POPUP_INPUT"|oxmultilangassign}]
    [{assign var="editYourInput" value="ENDERECOOXID6CLIENT_POPUP_EDITINPUT"|oxmultilangassign}]
    [{assign var="ourSuggestions" value="ENDERECOOXID6CLIENT_POPUP_SUGGESTIONS"|oxmultilangassign}]
    [{assign var="useSelected" value="ENDERECOOXID6CLIENT_POPUP_USE"|oxmultilangassign}]

    <script>
        var enderecoConfigureIntegrator = function() {
            window.EnderecoIntegrator.config.apiUrl = "[{$oViewConf->getModuleUrl('endereco-oxid6-client', 'proxy/io.php')}]";
            window.EnderecoIntegrator.config.apiKey = '[{$enderecoclient.sAPIKEY}]';
            window.EnderecoIntegrator.defaultCountry = '[{$enderecoclient.sPreselectableCountries}]';
            window.EnderecoIntegrator.defaultCountrySelect = [{if $enderecoclient.bPreselectCountry }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.config.showDebugInfo = [{if $enderecoclient.bShowDebug }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.config.remoteApiUrl = '[{$enderecoclient.sSERVICEURL}]';
            window.EnderecoIntegrator.config.trigger.onblur = [{if $enderecoclient.sAMSBLURTRIGGER }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.config.trigger.onsubmit = [{if $enderecoclient.sAMSSubmitTrigger }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.config.ux.resumeSubmit = [{if $enderecoclient.sAMSResumeSubmit }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.config.ux.smartFill = [{if $enderecoclient.sSMARTFILL }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.config.ux.checkExisting = [{if $enderecoclient.sCHECKALL }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.countryMappingUrl = '[{$sitepath}]?cl=enderecocountrycontroller';
            window.EnderecoIntegrator.config.templates.button = '<div class="lineBox clear"><button class="submitButton largeButton nextStep" endereco-use-selection type="button">[{$useSelected|escape:quotes}]</button></div>';
            window.EnderecoIntegrator.config.texts = {
                popUpHeadline: '[{$popUpHeadline|escape:quotes}]',
                popUpSubline: '[{$popUpSubline|escape:quotes}]',
                yourInput: '[{$yourInput|escape:quotes}]',
                editYourInput: '[{$editYourInput|escape:quotes}]',
                ourSuggestions: '[{$ourSuggestions|escape:quotes}]',
                useSelected: '[{$useSelected|escape:quotes}]'
            };
            window.EnderecoIntegrator.activeServices = {
                ams: [{if $enderecoclient.sUSEAMS }]true[{else}]false[{/if}],
                emailService: [{if $enderecoclient.bUseEmailservice }]true[{else}]false[{/if}],
                personService: [{if $enderecoclient.bUsePersonalService }]true[{else}]false[{/if}]
            }

            window.EnderecoIntegrator.checkAllCallback = function(EAO) {
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

            window.EnderecoIntegrator.ready = true;
        }

        var $interval = setInterval( function() {
            if (window.EnderecoIntegrator && window.EnderecoIntegrator.loaded) {
                enderecoConfigureIntegrator()
                clearInterval($interval);
            }
        }, 100);
    </script>
    [{oxid_include_widget cl="enderecocolor"}]
[{/if}]


