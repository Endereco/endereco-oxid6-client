<?php

namespace Endereco\Oxid6Client\Controller;

use OxidEsales\Eshop\Core\Header;
use OxidEsales\Eshop\Core\Registry;

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
        } elseif (!empty($countryCode)) {
            $oCountry = oxNew('oxCountry');
            $returnValue = $oCountry->getIdByCode($countryCode);
        }

        $this->setContentTyp('text/plain');
        $this->setBrowserCache('+2 Year');

        \OxidEsales\Eshop\Core\Registry::getUtils()->showMessageAndExit($returnValue);
    }

    private function setContentTyp($type)
    {
        Registry::get(Header::class)->setHeader(
            'Content-Type: ' . $type
        );
    }

    private function setBrowserCache($time)
    {
        $dateTime = date_create($time);

        Registry::get(Header::class)->setHeader(
            'Cache-Control: public, only-if-cached, max-age=' . $dateTime->getTimestamp()
        );

        Registry::get(Header::class)->setHeader(
            'Expires: ' . $dateTime->format(DATE_RFC7231)
        );
    }
}
