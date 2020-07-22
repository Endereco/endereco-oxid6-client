<?php

namespace Endereco\Oxid6Client\Controller;

class CountryController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    public function render()
    {
        $oConfig = $this->getConfig();
        $countryId = $oConfig->getRequestParameter('countryId', true);
        $countryCode = $oConfig->getRequestParameter('countryCode', true);

        if ($countryId) {
            $oCountry = oxNew('oxCountry');
            $oCountry->load($countryId);
            die(strtolower($oCountry->oxcountry__oxisoalpha2->value));
        }

        if ($countryCode) {
            $oCountry = oxNew('oxCountry');
            die($oCountry->getIdByCode($countryCode));
        }
    }
}
