<?php
namespace Endereco\Oxid6Client\Model;

use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;
use \Endereco\Oxid6Client\Component\EnderecoService;

class User extends User_parent
{
    /**
     * Method is used for overriding and add additional actions when logging in.
     *
     * @param string $sUser
     * @param string $sPassword
     */
    protected function onLogin($sUser, $sPassword)
    {
        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopId();
        $bCheckExisting = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('sCHECKALL', $sOxId, 'module:endereco-oxid6-client');
        if (1 === intval($bCheckExisting) && !$this->isAdmin() && !empty($this->oxuser__oxid->value)) {
            $enderecoService = new EnderecoService();

            $oLang = \OxidEsales\Eshop\Core\Registry::getLang();
            $localLanguage = $oLang->getLanguageAbbr();

            $oCountry = oxNew('oxCountry');
            $oCountry->load($this->oxuser__oxcountryid->value);
            $countryCode = strtolower($oCountry->oxcountry__oxisoalpha2->value);

            $billingAddress = array(
                'countryCode' => $countryCode,
                '__language' => $localLanguage,
                'additionalInfo' => $this->oxuser__oxaddinfo->value,
                'postalCode' => $this->oxuser__oxzip->value,
                'locality' => $this->oxuser__oxcity->value,
                'streetName' => $this->oxuser__oxstreet->value,
                'buildingNumber' => $this->oxuser__oxstreetnr->value,
                '__status' => (('' !== $this->oxuser__mojoamsstatus->value) ? $this->oxuser__mojoamsstatus->value : 'address_not_checked'),
                '__predictions' => '',
                '__timestamp' => '',
            );

            if (
                $enderecoService->shouldBeChecked(explode(',', $billingAddress['__status']))
            ) {
                // Check.
                $checkedBillingAddress = $enderecoService->checkAddress($billingAddress);

                // Save.
                if (!empty($checkedBillingAddress['__status'])) {
                    $this->oxuser__mojoamsstatus->value = $checkedBillingAddress['__status'];
                    $this->oxuser__mojoamsts->rawValue = $checkedBillingAddress['__timestamp'];
                    $this->oxuser__mojoamspredictions->rawValue = $checkedBillingAddress['__predictions'];
                    $this->save();
                }
            }

            // check delivery addresses.
            $aAddresses = $this->getUserAddresses();
            $aAddressList = $aAddresses->getArray();
            foreach ($aAddressList as $oAddress) {

                $oCountry = oxNew('oxCountry');
                $oCountry->load($oAddress->oxaddress__oxcountryid->value);
                $countryCode = strtolower($oCountry->oxcountry__oxisoalpha2->value);

                $shippingAddress = array(
                    'countryCode' => $countryCode,
                    '__language' => $localLanguage,
                    'additionalInfo' => $oAddress->oxaddress__oxaddinfo->value,
                    'postalCode' => $oAddress->oxaddress__oxzip->value,
                    'locality' => $oAddress->oxaddress__oxcity->value,
                    'streetName' => $oAddress->oxaddress__oxstreet->value,
                    'buildingNumber' => $oAddress->oxaddress__oxstreetnr->value,
                    '__status' => (('' !== $oAddress->oxaddress__mojoamsstatus->value) ? $oAddress->oxaddress__mojoamsstatus->value : 'address_not_checked'),
                    '__predictions' => '',
                    '__timestamp' => '',
                );

                if (
                    $enderecoService->shouldBeChecked(explode(',', $shippingAddress['__status']))
                ) {
                    // Check.
                    $checkedShippingAddress = $enderecoService->checkAddress($shippingAddress);

                    // Save.
                    if (!empty($checkedShippingAddress['__status'])) {
                        $oAddress->oxaddress__mojoamsstatus->value = $checkedShippingAddress['__status'];
                        $oAddress->oxaddress__mojoamsts->rawValue = $checkedShippingAddress['__timestamp'];
                        $oAddress->oxaddress__mojoamspredictions->rawValue = $checkedShippingAddress['__predictions'];
                        $oAddress->save();
                    }
                }
            }
        }

        parent::onLogin($sUser, $sPassword);
    }
}
