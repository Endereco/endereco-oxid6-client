<?php

namespace Endereco\Oxid6Client\Controller;

class CountryController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    public function render()
    {
        $oConfig = $this->getConfig();
        $countryId = $oConfig->getRequestParameter('countryId', true);
        $countryCode = $oConfig->getRequestParameter('countryCode', true);
        $returnValue = '';
        if (!empty($countryId)) {
            $oCountry = oxNew('oxCountry');
            $oCountry->load($countryId);
            $returnValue = strtolower($oCountry->oxcountry__oxisoalpha2->value);
        }

        if (!empty($countryCode)) {
            $oCountry = oxNew('oxCountry');
            $returnValue = $oCountry->getIdByCode($countryCode);
        }

        echo $returnValue;
        exit;
    }
}
