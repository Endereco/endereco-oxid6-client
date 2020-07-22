<?php
$sMetadataVersion = '2.0';
$aModule = array(
    'id'            => 'endereco-oxid6-client',
    'title'         => 'Endereco Adress-Services für Oxid',
    'description'   => 'Kundenstammdaten-Validierung und Korrekturvorschläge.',
    'thumbnail'     => 'endereco.png',
    'version'       => '4.0.0',
    'author'        => 'Endereco UG (Haftungsbeschränkt) - Gesellschaft für Master Data Quality Management',
    'email'         => 'info@endereco.de',
    'url'           => 'https://www.endereco.de',
    'blocks' => array(
        array(
            'template' => 'layout/base.tpl',
            'block' => 'base_js',
            'file' => '/application/views/agent-include.tpl',
        ),
        array(
            'template' => 'form/fieldset/user_billing.tpl',
            'block' => 'form_user_billing_country',
            'file' => '/application/views/hidden_fields/endereco_form_user_billing_country.tpl',
        ),
        array(
            'template' => 'form/fieldset/user_shipping.tpl',
            'block' => 'form_user_shipping_country',
            'file' => '/application/views/hidden_fields/endereco_form_user_shipping_country.tpl',
        ),
        array(
            'template' => 'form/fieldset/user_noaccount.tpl',
            'block' => 'user_noaccount_email',
            'file' => '/application/views/hidden_fields/endereco_form_user_noaccount.tpl',
        ),
        array(
            'template' => 'form/fieldset/user_account.tpl',
            'block' => 'user_account_username',
            'file' => '/application/views/hidden_fields/endereco_form_user_account.tpl',
        ),
    ),
    'controllers'  => array(
        'enderecoconfig' => \Endereco\Oxid6Client\Widget\IncludeConfigWidget::class,
        'enderecocolor' => \Endereco\Oxid6Client\Widget\IncludeColorWidget::class,
        'enderecosettings' => \Endereco\Oxid6Client\Controller\Admin\Settings::class,
        'enderecocountrycontroller' => \Endereco\Oxid6Client\Controller\CountryController::class,
    ),
    'extend' => array(
        \OxidEsales\Eshop\Application\Model\User::class =>  \Endereco\Oxid6Client\Model\User::class,
        \OxidEsales\Eshop\Application\Model\User\UserUpdatableFields::class => \Endereco\Oxid6Client\Model\User\UserUpdatableFields::class,
        \OxidEsales\Eshop\Application\Model\User\UserShippingAddressUpdatableFields::class => \Endereco\Oxid6Client\Model\User\UserShippingAddressUpdatableFields::class,
    ),
    'templates' => array(
        'enderecocolor.tpl' => 'endereco/endereco-oxid6-client/application/views/enderecocolor.tpl',
        'enderecoconfig_default.tpl' => 'endereco/endereco-oxid6-client/application/configs/enderecoconfig_default.tpl',
        'enderecoconfig_flow.tpl' => 'endereco/endereco-oxid6-client/application/configs/enderecoconfig_flow.tpl',
        'enderecoconfig_wave.tpl' => 'endereco/endereco-oxid6-client/application/configs/enderecoconfig_wave.tpl',
        'enderecoconfig_azure.tpl' => 'endereco/endereco-oxid6-client/application/configs/enderecoconfig_azure.tpl',
        'endereco_settings.tpl' => 'endereco/endereco-oxid6-client/application/views/admin/tpl/endereco_settings.tpl',
    ),
    'events'       => array(
        'onActivate'   => '\Endereco\Oxid6Client\Installer\Installer::onActivate',
        'onDeactivate' => '\Endereco\Oxid6Client\Installer\Installer::onDeactivate',
    ),
    'settings' => array(
        array('group' => 'ACCESS', 'name' => 'sAPIKEY', 'type' => 'str', 'value' => ''),
        array('group' => 'ACCESS', 'name' => 'sSERVICEURL', 'type' => 'str', 'value' => 'https://endereco-service.de/rpc/v1'),
        array('group' => 'AMS', 'name' => 'sUSEAMS', 'type' => 'bool', 'value' => true),
        array('group' => 'AMS', 'name' => 'sCHECKALL', 'type' => 'bool', 'value' => true),
        array('group' => 'AMS', 'name' => 'sAMSBLURTRIGGER', 'type' => 'bool', 'value' => 'true'),
        array('group' => 'AMS', 'name' => 'sSMARTFILL', 'type' => 'bool', 'value' => 'true'),
        array('group' => 'EmailServices', 'name' => 'bUseEmailservice', 'type' => 'bool', 'value' => true),
        array('group' => 'PersonalService', 'name' => 'bUsePersonalService', 'type' => 'bool', 'value' => true),
        array('group' => 'VISUAL', 'name' => 'bUseCss', 'type' => 'bool', 'value' => 'true'),
        array('group' => 'VISUAL', 'name' => 'sMainColor', 'type' => 'str', 'value' => ''),
        array('group' => 'VISUAL', 'name' => 'sErrorColor', 'type' => 'str', 'value' => ''),
        array('group' => 'VISUAL', 'name' => 'sSelectionColor', 'type' => 'str', 'value' => ''),
        array('group' => 'ADVANCED', 'name' => 'sAllowedControllerClasses', 'type' => 'str', 'value' => 'account_user,user,register'),
        array('group' => 'ADVANCED', 'name' => 'bShowDebug', 'type' => 'bool', 'value' => false),
    )
);
