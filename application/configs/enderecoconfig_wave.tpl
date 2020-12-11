[{assign var="sitepath" value=$oViewConf->getBaseDir()}]

[{if
    !$enderecoclient.bAllowControllerFilter ||
    $enderecoclient.sControllerClass|in_array:$enderecoclient.aAllowedControllerClasses ||
    ('order' == $enderecoclient.sControllerClass && $enderecoclient.sCHECKALL)
}]
    <script async defer src="[{$oViewConf->getModuleUrl('endereco-oxid6-client', 'out/assets/js/endereco.min.js')}]?ver=[{$enderecoclient.sModuleVersion}]"></script>

    [{assign var="popUpHeadline" value="ENDERECOOXID6CLIENT_POPUP_HEADLINE"|oxmultilangassign}]
    [{assign var="popUpSubline" value="ENDERECOOXID6CLIENT_POPUP_SUBLINE"|oxmultilangassign}]
    [{assign var="yourInput" value="ENDERECOOXID6CLIENT_POPUP_INPUT"|oxmultilangassign}]
    [{assign var="editYourInput" value="ENDERECOOXID6CLIENT_POPUP_EDITINPUT"|oxmultilangassign}]
    [{assign var="ourSuggestions" value="ENDERECOOXID6CLIENT_POPUP_SUGGESTIONS"|oxmultilangassign}]
    [{assign var="useSelected" value="ENDERECOOXID6CLIENT_POPUP_USE"|oxmultilangassign}]

    [{assign var="generalAddress" value="ENDERECOOXID6CLIENT_POPUP_HEADLINE_GENERAL_ADDRESS"|oxmultilangassign}]
    [{assign var="billingAddress" value="ENDERECOOXID6CLIENT_POPUP_HEADLINE_BILLING_ADDRESS"|oxmultilangassign}]
    [{assign var="shippingAddress" value="ENDERECOOXID6CLIENT_POPUP_HEADLINE_SHIPPING_ADDRESS"|oxmultilangassign}]
    [{assign var="emailNotCorrect" value="ENDERECOOXID6CLIENT_STATUS_EMAIL_NOT_CORRECT"|oxmultilangassign}]
    [{assign var="emailVantReceive" value="ENDERECOOXID6CLIENT_STATUS_EMAIL_CANT_RECEIVE"|oxmultilangassign}]
    [{assign var="emailSyntaxError" value="ENDERECOOXID6CLIENT_STATUS_EMAIL_SYNTAX"|oxmultilangassign}]
    [{assign var="emailNoMx" value="ENDERECOOXID6CLIENT_STATUS_EMAIL_NO_MX"|oxmultilangassign}]

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
            window.EnderecoIntegrator.config.ux.changeFieldsOrder = [{if $enderecoclient.bChangeFieldsOrder }]true[{else}]false[{/if}];;
            window.EnderecoIntegrator.config.ux.showEmailStatus = [{if $enderecoclient.bShowEmailserviceErrors }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.config.ux.useStandardCss = [{if $enderecoclient.bUseCss }]true[{else}]false[{/if}];
            window.EnderecoIntegrator.countryMappingUrl = '[{$sitepath}]?cl=enderecocountrycontroller';
            window.EnderecoIntegrator.config.templates.button = '<button class="btn btn-primary" type="button" endereco-use-selection>[{$useSelected|escape:quotes}]</button>';
            window.EnderecoIntegrator.config.texts = {
                popUpHeadline: '[{$popUpHeadline|escape:quotes}]',
                popUpSubline: '[{$popUpSubline|escape:quotes}]',
                yourInput: '[{$yourInput|escape:quotes}]',
                editYourInput: '[{$editYourInput|escape:quotes}]',
                ourSuggestions: '[{$ourSuggestions|escape:quotes}]',
                useSelected: '[{$useSelected|escape:quotes}]',
                popupHeadlines: {
                    general_address: '[{$generalAddress|escape:quotes}]',
                    billing_address: '[{$billingAddress|escape:quotes}]',
                    shipping_address: '[{$shippingAddress|escape:quotes}]'
                },
                statuses: {
                    'email_not_correct': '[{$emailNotCorrect|escape:quotes}]',
                    'email_cant_receive': '[{$emailVantReceive|escape:quotes}]',
                    'email_syntax_error': '[{$emailSyntaxError|escape:quotes}]',
                    'email_no_mx': '[{$emailNoMx|escape:quotes}]'
                }
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


