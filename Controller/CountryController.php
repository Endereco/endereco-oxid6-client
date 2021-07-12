<?php

namespace Endereco\Oxid6Client\Controller;

use OxidEsales\Eshop\Core\Registry;

class CountryController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    /**
     * Disable components which needs to be initialized/rendered
     * @var bool
     */
    protected $_blLoadComponents = false;

    /**
     * @return void
     */
    public function render()
    {
        $countryId = Registry::getRequest()->getRequestEscapedParameter('countryId');
        $countryCode = Registry::getRequest()->getRequestEscapedParameter('countryCode');

        $returnValue = '';
        if (!empty($countryId)) {
            $oCountry = oxNew('oxCountry');
            $oCountry->load($countryId);
            $returnValue = strtolower($oCountry->oxcountry__oxisoalpha2->value);
        } elseif (!empty($countryCode)) {
            $oCountry = oxNew('oxCountry');
            $returnValue = $oCountry->getIdByCode($countryCode);
        }

        \OxidEsales\Eshop\Core\Registry::getUtils()->showMessageAndExit($returnValue);
    }
}
