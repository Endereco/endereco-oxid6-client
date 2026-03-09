<?php

namespace Endereco\Oxid6Client\Controller;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Application\Model\Country;
use Endereco\Oxid6Client\Component\EnderecoService;
use OxidEsales\Eshop\Core\Registry;

class OrderController extends OrderController_parent
{
    /**
     * Renders the order page and checks the addresses if necessary.
     * This method performs address validation for billing and delivery addresses
     * during the order process, especially for PayPal Express checkout.
     *
     * @return string The rendered template name.
     */
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

            // Check if its a PayPal Express checkout user
            if (
                $payment
                && ('0000-00-00 00:00:00' === $oUser->oxuser__oxregister->rawValue)
                && ('oxidpaypal' === $payment->getId() || 'oscpaypal_express' === $payment->getId())
                && $bCheckExistingPayPalExpress
            ) {
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
                if (
                    $oUser
                    && ($this->isBillingHashMismatch($oUser)
                        || $this->isValidationNeeded($oUser->oxuser__mojoamsstatus->rawValue))
                ) {
                    $oCountry = oxNew(Country::class);
                    $oCountry->load($oUser->oxuser__oxcountryid->rawValue);
                    $countryCode = strtolower($oCountry->oxcountry__oxisoalpha2->rawValue);

                    $billingHasSubdivisions = $EnderecoService->countryHasSubdivisions(
                        $oUser->oxuser__oxcountryid->rawValue
                    );
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
                    if ($billingHasSubdivisions) {
                        $billingAddress['subdivisionCode'] = $oUser->oxuser__oxstateid->rawValue ?? '';
                    }

                    // Check.
                    $checkedBillingAddress = $EnderecoService->checkAddress($billingAddress);

                    // Save.
                    if (!empty($checkedBillingAddress['__status'])) {
                        $oUser->oxuser__mojoamsstatus->rawValue = $checkedBillingAddress['__status'];
                        $oUser->oxuser__mojoamsts->rawValue = $checkedBillingAddress['__timestamp'];
                        $oUser->oxuser__mojoamspredictions->rawValue = $checkedBillingAddress['__predictions'];
                        $oUser->oxuser__mojoaddresshash->rawValue = $this->calculateHash(
                            $oUser->oxuser__oxcountryid->rawValue,
                            $billingHasSubdivisions ? ($oUser->oxuser__oxstateid->rawValue ?? '') : null,
                            $oUser->oxuser__oxzip->rawValue,
                            $oUser->oxuser__oxcity->rawValue,
                            $oUser->oxuser__oxstreet->rawValue,
                            $oUser->oxuser__oxstreetnr->rawValue,
                            $oUser->oxuser__oxaddinfo->rawValue
                        );
                        $oUser->save();
                    }
                }

                // Check invoice address.
                if (
                    $oDeliveryAddress
                    && ($this->isDeliveryHashMismatch($oDeliveryAddress)
                        || $this->isValidationNeeded($oDeliveryAddress->oxaddress__mojoamsstatus->rawValue))
                ) {
                    $oCountry = oxNew('oxCountry');
                    $oCountry->load($oDeliveryAddress->oxaddress__oxcountryid->rawValue);
                    $countryCode = strtolower($oCountry->oxcountry__oxisoalpha2->rawValue);

                    $shippingHasSubdivisions = $EnderecoService->countryHasSubdivisions(
                        $oDeliveryAddress->oxaddress__oxcountryid->rawValue
                    );
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
                    if ($shippingHasSubdivisions) {
                        $shippingAddress['subdivisionCode'] = $oDeliveryAddress->oxaddress__oxstateid->rawValue ?? '';
                    }

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
                        $oDeliveryAddress->oxaddress__mojoaddresshash->rawValue = $this->calculateHash(
                            $oDeliveryAddress->oxaddress__oxcountryid->rawValue,
                            $shippingHasSubdivisions ? ($oDeliveryAddress->oxaddress__oxstateid->rawValue ?? '') : null,
                            $oDeliveryAddress->oxaddress__oxzip->rawValue,
                            $oDeliveryAddress->oxaddress__oxcity->rawValue,
                            $oDeliveryAddress->oxaddress__oxstreet->rawValue,
                            $oDeliveryAddress->oxaddress__oxstreetnr->rawValue,
                            $oDeliveryAddress->oxaddress__oxaddinfo->rawValue
                        );
                        $oDeliveryAddress->save();
                    }
                }
            }
        }

        return parent::render();
    }

    /**
     * Exposes the subdivision check to templates (called as $oView->countryHasSubdivisions()).
     *
     * @param string $countryId OXID internal country ID.
     * @return bool
     */
    public function countryHasSubdivisions($countryId)
    {
        return (new EnderecoService())->countryHasSubdivisions($countryId);
    }

    /**
     * Checks if the billing address hash is mismatched.
     *
     * @param User $billingAddress The billing address to check.
     * @return bool True if the hash is mismatched, false otherwise.
     */
    private function isBillingHashMismatch($billingAddress)
    {
        $hasSubdivisions = (new EnderecoService())->countryHasSubdivisions(
            $billingAddress->oxuser__oxcountryid->rawValue
        );
        $hash = $this->calculateHash(
            $billingAddress->oxuser__oxcountryid->rawValue,
            $hasSubdivisions ? ($billingAddress->oxuser__oxstateid->rawValue ?? '') : null,
            $billingAddress->oxuser__oxzip->rawValue,
            $billingAddress->oxuser__oxcity->rawValue,
            $billingAddress->oxuser__oxstreet->rawValue,
            $billingAddress->oxuser__oxstreetnr->rawValue,
            $billingAddress->oxuser__oxaddinfo->rawValue
        );

        return $hash !== $billingAddress->oxuser__mojoaddresshash->rawValue;
    }

    /**
     * Checks if the delivery address hash is mismatched.
     *
     * @param Address $deliveryAddress The delivery address to check.
     * @return bool True if the hash is mismatched, false otherwise.
     */
    private function isDeliveryHashMismatch($deliveryAddress)
    {
        $hasSubdivisions = (new EnderecoService())->countryHasSubdivisions(
            $deliveryAddress->oxaddress__oxcountryid->rawValue
        );
        $hash = $this->calculateHash(
            $deliveryAddress->oxaddress__oxcountryid->rawValue,
            $hasSubdivisions ? ($deliveryAddress->oxaddress__oxstateid->rawValue ?? '') : null,
            $deliveryAddress->oxaddress__oxzip->rawValue,
            $deliveryAddress->oxaddress__oxcity->rawValue,
            $deliveryAddress->oxaddress__oxstreet->rawValue,
            $deliveryAddress->oxaddress__oxstreetnr->rawValue,
            $deliveryAddress->oxaddress__oxaddinfo->rawValue
        );

        return $hash !== $deliveryAddress->oxaddress__mojoaddresshash->rawValue;
    }

    /**
     * Calculates a hash based on the provided address components.
     * This is used to ensure the address integrity.
     *
     * TODO: Extract to a shared location — duplicated in AddressController and UserComponent.
     *
     * @param string $countryCode Country code of the address.
     * @param string|null $subdivisionCode ISO 3166-2 subdivision code, or null if not applicable.
     * @param string $postalCode Postal code of the address.
     * @param string $locality Locality (city) of the address.
     * @param string $streetName Street name of the address.
     * @param string $buildingNumber Building number of the address.
     * @param string $additionalInfo Additional information of the address.
     * @return string The calculated hash.
     */
    private function calculateHash(
        $countryCode,
        $subdivisionCode,
        $postalCode,
        $locality,
        $streetName,
        $buildingNumber,
        $additionalInfo
    ) {
        $hashBody = [
            'countryCode' => $countryCode,
            'postalCode' => $postalCode,
            'locality' => $locality,
            'streetName' => $streetName,
            'buildingNumber' => $buildingNumber,
            'additionalInfo' => $additionalInfo
        ];
        if ($subdivisionCode !== null) {
            $hashBody['subdivisionCode'] = $subdivisionCode;
        }
        return hash('sha256', json_encode($hashBody));
    }

    /**
     * Determines if a new AMS status check is needed based on the current AMS status of the address extension.
     *
     * A check is needed if the AMS status is empty or matches the constant AMS_STATUS_NOT_CHECKED
     *
     * @return bool True if a new AMS status check is required, false otherwise
     */
    public function isValidationNeeded($currentStatus): bool
    {


        $isEmpty = empty($currentStatus);

        // The JS SDK may set 'not-checked' as a default status value. In practice this
        // is always overwritten before form submission, but we check defensively.
        // Not using a class constant because PHP 7.0 doesn't support constant visibility
        // modifiers, and PSR-12 requires them.
        $hasDefaultValue = ($currentStatus === 'not-checked');

        $isCheckNeeded = $isEmpty || $hasDefaultValue;

        return $isCheckNeeded;
    }
}
