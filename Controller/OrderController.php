<?php

namespace Endereco\Oxid6Client\Controller;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Application\Model\Country;
use Endereco\Oxid6Client\Component\EnderecoService;
use OxidEsales\Eshop\Core\Registry;

class OrderController extends OrderController_parent
{
    public function render()
    {
        $sOxId = (string) Registry::getConfig()->getShopId();

        $bCheckExisting = (bool) Registry::getConfig()->getShopConfVar(
            'sCHECKALL',
            $sOxId,
            'module:endereco-oxid6-client'
        );

        $bCheckExistingPayPalExpress = (bool) Registry::getConfig()->getShopConfVar(
            'sCHECKPAYPAL',
            $sOxId,
            'module:endereco-oxid6-client'
        );

        if ($this->getIsOrderStep()) {
            // Do we need to check delivery address?

            $oUser = $this->getUser();
            $oDeliveryAddress = $this->getDelAddress();

            $shouldCheck = false;
            $payment = $this->getPayment();

            // Check if its a paypal express checkout user
            if (
                ('0000-00-00 00:00:00' === $oUser->oxuser__oxregister->rawValue)
                && ('oxidpaypal' === $payment->getId())
                && $bCheckExistingPayPalExpress
            ) {
                // Reset user status, bacause paypal express checkout reuses the same user entry in db.
                $oUser->oxuser__mojoamsstatus->rawValue = '';
                $shouldCheck = true;
            } elseif (
                ('0000-00-00 00:00:00' !== $oUser->oxuser__oxregister->rawValue)
                && $bCheckExisting
            ) {
                $shouldCheck = true;
            }

            if ($shouldCheck) {
                $EnderecoService = new EnderecoService();
                $oLang = \OxidEsales\Eshop\Core\Registry::getLang();
                $localLanguage = $oLang->getLanguageAbbr();

                // Check invoice address.
                if (empty($oUser->oxuser__mojoamsstatus->rawValue)) {
                    $oCountry = oxNew(Country::class);
                    $oCountry->load($oUser->oxuser__oxcountryid->rawValue);
                    $countryCode = strtolower($oCountry->oxcountry__oxisoalpha2->rawValue);

                    $billingAddress = array(
                        'countryCode' => $countryCode,
                        '__language' => $localLanguage,
                        'additionalInfo' => $oUser->oxuser__oxaddinfo->rawValue,
                        'postalCode' => $oUser->oxuser__oxzip->rawValue,
                        'locality' => $oUser->oxuser__oxcity->rawValue,
                        'streetName' => $oUser->oxuser__oxstreet->rawValue,
                        'buildingNumber' => $oUser->oxuser__oxstreetnr->rawValue,
                        '__status' => (
                            ('' !== $oUser->oxuser__mojoamsstatus->rawValue)
                                ? $oUser->oxuser__mojoamsstatus->rawValue
                                : ''
                            ),
                        '__predictions' => '',
                        '__timestamp' => '',
                    );

                    if (
                        $EnderecoService->shouldBeChecked(explode(',', $billingAddress['__status']))
                    ) {
                        // Check.
                        $checkedBillingAddress = $EnderecoService->checkAddress($billingAddress);

                        // Save.
                        if (!empty($checkedBillingAddress['__status'])) {
                            $oUser->oxuser__mojoamsstatus->rawValue = $checkedBillingAddress['__status'];
                            $oUser->oxuser__mojoamsts->rawValue = $checkedBillingAddress['__timestamp'];
                            $oUser->oxuser__mojoamspredictions->rawValue = $checkedBillingAddress['__predictions'];
                            $oUser->save();
                        }
                    }
                }

                // Check invoice address.
                if ($oDeliveryAddress && empty($oDeliveryAddress->oxaddress__mojoamsstatus->rawValue)) {
                    $oCountry = oxNew('oxCountry');
                    $oCountry->load($oDeliveryAddress->oxaddress__oxcountryid->rawValue);
                    $countryCode = strtolower($oCountry->oxcountry__oxisoalpha2->rawValue);

                    $shippingAddress = array(
                        'countryCode' => $countryCode,
                        '__language' => $localLanguage,
                        'additionalInfo' => $oDeliveryAddress->oxaddress__oxaddinfo->rawValue,
                        'postalCode' => $oDeliveryAddress->oxaddress__oxzip->rawValue,
                        'locality' => $oDeliveryAddress->oxaddress__oxcity->rawValue,
                        'streetName' => $oDeliveryAddress->oxaddress__oxstreet->rawValue,
                        'buildingNumber' => $oDeliveryAddress->oxaddress__oxstreetnr->rawValue,
                        '__status' => (
                            ('' !== $oDeliveryAddress->oxaddress__mojoamsstatus->rawValue)
                                ? $oDeliveryAddress->oxaddress__mojoamsstatus->rawValue
                                : ''
                        ),
                        '__predictions' => '',
                        '__timestamp' => '',
                    );

                    if (
                        $EnderecoService->shouldBeChecked(explode(',', $shippingAddress['__status']))
                    ) {
                        // Check.
                        $checkedShippingAddress = $EnderecoService->checkAddress($shippingAddress);

                        // Save.
                        if (!empty($checkedShippingAddress['__status'])) {
                            $oDeliveryAddress->oxaddress__mojoamsstatus->rawValue
                                = $checkedShippingAddress['__status'];
                            $oDeliveryAddress->oxaddress__mojoamsts->rawValue
                                = $checkedShippingAddress['__timestamp'];
                            $oDeliveryAddress->oxaddress__mojoamspredictions->rawValue
                                = $checkedShippingAddress['__predictions'];
                            $oDeliveryAddress->save();
                        }
                    }
                }
            }
        }

        return parent::render();
    }
}
