<?php

namespace Endereco\Oxid6Client\Controller;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\Address;

class AddressController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    /**
     * @return string
     */
    public function render()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $isChanged = 1;
        if ('editBillingAddress' == $data['method']) {
            // Save billing address.
            $oUser = oxNew(User::class);
            if ($oUser->load($data['params']['addressId'])) {

                $hashBefore = $this->calculateHash(
                    $oUser->oxuser__oxcountryid->rawValue, // Country ID
                    $oUser->oxuser__oxzip->rawValue, // Postal code
                    $oUser->oxuser__oxcity->rawValue, // Locality
                    $oUser->oxuser__oxstreet->rawValue, // Street name
                    $oUser->oxuser__oxstreetnr->rawValue, // House number
                    $oUser->oxuser__oxaddinfo->rawValue // Additional info
                );

                $addressChanges = $this->getChangesFromPredictions($data['params']);

                $oUser->oxuser__oxzip->rawValue
                    = $addressChanges['postalCode'] ?? $oUser->oxuser__oxzip->rawValue;

                $oUser->oxuser__oxcity->rawValue
                    = $addressChanges['locality'] ?? $oUser->oxuser__oxcity->rawValue;

                $oUser->oxuser__oxstreet->rawValue
                    = $addressChanges['streetName'] ?? $oUser->oxuser__oxstreet->rawValue;

                $oUser->oxuser__oxstreetnr->rawValue
                    =$addressChanges['buildingNumber']
                        ? $data['params']['address']['buildingNumber']
                        : $oUser->oxuser__oxstreetnr->rawValue;

                $oUser->oxuser__oxaddinfo->rawValue
                    = $addressChanges['additionalInfo'] ?? $oUser->oxuser__oxaddinfo->rawValue;

                $status = implode(',', $data['params']['enderecometa']['status']);
                $oUser->oxuser__mojoamsstatus->rawValue = $status;
                $oUser->oxuser__mojoamsts->rawValue = $data['params']['enderecometa']['ts'];
                $predictions = json_encode($data['params']['enderecometa']['predictions']);
                $oUser->oxuser__mojoamspredictions->rawValue = $predictions;

                // When writing address through endereco modal, always recalculate hash.
                $hash = $this->calculateHash(
                    $oUser->oxuser__oxcountryid->rawValue, // Country ID
                    $oUser->oxuser__oxzip->rawValue, // Postal code
                    $oUser->oxuser__oxcity->rawValue, // Locality
                    $oUser->oxuser__oxstreet->rawValue, // Street name
                    $oUser->oxuser__oxstreetnr->rawValue, // House number
                    $oUser->oxuser__oxaddinfo->rawValue // Additional info
                );

                if($hash != $hashBefore){
                    $isChanged = 2;
                }

                $oUser->oxuser__mojoaddresshash->rawValue = $hash;
                $oUser->save();
            }
        }

        if ('editShippingAddress' == $data['method']) {
            // Save shipping address.
            $oAddress = oxNew(Address::class);
            if ($oAddress->load($data['params']['addressId'])) {

                $hashBefore = $this->calculateHash(
                    $oAddress->oxaddress__oxcountryid->rawValue, // Country ID
                    $oAddress->oxaddress__oxzip->rawValue, // Postal code
                    $oAddress->oxaddress__oxcity->rawValue, // Locality
                    $oAddress->oxaddress__oxstreet->rawValue, // Street name
                    $oAddress->oxaddress__oxstreetnr->rawValue, // House number
                    $oAddress->oxaddress__oxaddinfo->rawValue // Additional info
                );

                $addressChanges = $this->getChangesFromPredictions($data['params']);

                $oAddress->oxaddress__oxzip->rawValue
                    = $addressChanges['postalCode'] ?? $oAddress->oxaddress__oxzip->rawValue;

                $oAddress->oxaddress__oxcity->rawValue
                    = $addressChanges['locality'] ?? $oAddress->oxaddress__oxcity->rawValue;

                $oAddress->oxaddress__oxstreet->rawValue
                    = $addressChanges['streetName'] ?? $oAddress->oxaddress__oxstreet->rawValue;

                $oAddress->oxaddress__oxstreetnr->rawValue
                    = $addressChanges['buildingNumber'] ?? $oAddress->oxaddress__oxstreetnr->rawValue;

                $oAddress->oxaddress__oxaddinfo->rawValue
                    = $addressChanges['additionalInfo'] ?? $oAddress->oxaddress__oxaddinfo->rawValue;

                $status = implode(',', $data['params']['enderecometa']['status']);
                $oAddress->oxaddress__mojoamsstatus->rawValue = $status;
                $oAddress->oxaddress__mojoamsts->rawValue = $data['params']['enderecometa']['ts'];
                $predictions = json_encode($data['params']['enderecometa']['predictions']);
                $oAddress->oxaddress__mojoamspredictions->rawValue = $predictions;

                // When writing address through endereco modal, always recalculate hash.
                $hash = $this->calculateHash(
                    $oAddress->oxaddress__oxcountryid->rawValue, // Country ID
                    $oAddress->oxaddress__oxzip->rawValue, // Postal code
                    $oAddress->oxaddress__oxcity->rawValue, // Locality
                    $oAddress->oxaddress__oxstreet->rawValue, // Street name
                    $oAddress->oxaddress__oxstreetnr->rawValue, // House number
                    $oAddress->oxaddress__oxaddinfo->rawValue // Additional info
                );
                if($hash != $hashBefore){
                    $isChanged = 2;
                }
                $oAddress->oxaddress__mojoaddresshash->rawValue = $hash;
                $oAddress->save();
            }
        }

        echo $isChanged;
        \OxidEsales\Eshop\Core\Registry::getUtils()->showMessageAndExit($isChanged);

        return $isChanged;
    }

    /**
     * Calculates a hash based on the provided address components.
     * This is used to ensure the address integrity.
     *
     * @param string $countryCode Country code of the address.
     * @param string $postalCode Postal code of the address.
     * @param string $locality Locality (city) of the address.
     * @param string $streetName Street name of the address.
     * @param string $buildingNumber Building number of the address.
     * @param string $additionalInfo Additional information of the address.
     * @return string The calculated hash.
     */
    private function calculateHash(
        $countryCode,
        $postalCode,
        $locality,
        $streetName,
        $buildingNumber,
        $additionalInfo
    ) {
        $hashBody = [
            $countryCode,
            $postalCode,
            $locality,
            $streetName,
            $buildingNumber,
            $additionalInfo
        ];
        return hash('sha256', implode('', $hashBody));
    }

    private function getChangesFromPredictions($data){

        if($data){
            if(isset($data['enderecometa']['predictions']) && count($data['enderecometa']['predictions']) > 0){
                $predictions = $data['enderecometa']['predictions'];
                foreach($predictions as $prediction){
                    return $prediction;
                }
            }elseif($data['enderecometa']['status'][0] == "address_not_found"){
                return $data['address'];
            }

        }
    }
}
