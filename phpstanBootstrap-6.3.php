<?php

include "./shops/6.3/vendor/autoload.php"; 
include "./shops/6.3/source/oxfunctions.php"; 


if (class_exists('\OxidEsales\Eshop\Application\Controller\OrderController') && 
    !class_exists('Endereco\Oxid6Client\Controller\OrderController_parent')
) {
    class_alias(
        '\OxidEsales\Eshop\Application\Controller\OrderController', 
        'Endereco\Oxid6Client\Controller\OrderController_parent'
    );
}

if (class_exists('OxidEsales\Eshop\Application\Component\UserComponent') && 
    !class_exists('Endereco\Oxid6Client\Controller\UserComponent_parent')
) {
    class_alias(
        'OxidEsales\Eshop\Application\Component\UserComponent', 
        'Endereco\Oxid6Client\Controller\UserComponent_parent'
    );
}

if (class_exists('OxidEsales\Eshop\Application\Model\User\UserShippingAddressUpdatableFields') && 
    !class_exists('Endereco\Oxid6Client\Model\User\UserShippingAddressUpdatableFields_parent')
) {
    class_alias(
        'OxidEsales\Eshop\Application\Model\User\UserShippingAddressUpdatableFields', 
        'Endereco\Oxid6Client\Model\User\UserShippingAddressUpdatableFields_parent'
    );
}

if (class_exists('OxidEsales\Eshop\Application\Model\User\UserUpdatableFields') && 
    !class_exists('Endereco\Oxid6Client\Model\User\UserUpdatableFields_parent')
) {
    class_alias(
        'OxidEsales\Eshop\Application\Model\User\UserUpdatableFields', 
        'Endereco\Oxid6Client\Model\User\UserUpdatableFields_parent'
    );
}