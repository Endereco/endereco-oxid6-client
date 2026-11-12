<?php

namespace Endereco\Oxid6Client\Controller;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Model\Address;
use OxidEsales\Eshop\Core\Registry;
use Endereco\Oxid6Client\Component\EnderecoService;

class AddressController extends \OxidEsales\Eshop\Application\Controller\FrontendController
{
    /**
     * @return string
     */
    public function render()
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            $this->deny(405);
        }

        if (!Registry::getSession()->checkSessionChallenge()) {
            $this->deny(403);
        }

        $oCurrentUser = $this->getUser();
        if (!$oCurrentUser || !$oCurrentUser->getId()) {
            $this->deny(401);
        }

        $data = json_decode((string) file_get_contents('php://input'), true);
        if (!$this->isValidPayload($data)) {
            $this->deny(400);
        }

        $addressId = (string) $data['params']['addressId'];
        $addressChanged = 1;
        if ('editBillingAddress' === $data['method']) {
            // Only the billing address of the currently logged-in user may be changed.
            if ($addressId !== (string) $oCurrentUser->getId()) {
                $this->deny(403);
            }

            // Save billing address.
            $oUser = oxNew(User::class);
            if ($oUser->load($addressId)) {
                $oUser->oxuser__oxzip->rawValue
                    = $data['params']['address']['postalCode']
                    ? $data['params']['address']['postalCode']
                    : $oUser->oxuser__oxzip->rawValue;

                $oUser->oxuser__oxcity->rawValue
                    = $data['params']['address']['locality']
                    ? $data['params']['address']['locality']
                    : $oUser->oxuser__oxcity->rawValue;

                $oUser->oxuser__oxstreet->rawValue
                    = $data['params']['address']['streetName']
                    ? $data['params']['address']['streetName']
                    : $oUser->oxuser__oxstreet->rawValue;

                $oUser->oxuser__oxstreetnr->rawValue
                    = $data['params']['address']['buildingNumber']
                    ? $data['params']['address']['buildingNumber']
                    : $oUser->oxuser__oxstreetnr->rawValue;

                $oUser->oxuser__oxaddinfo->rawValue
                    = $data['params']['address']['additionalInfo']
                    ? $data['params']['address']['additionalInfo']
                    : $oUser->oxuser__oxaddinfo->rawValue;

                $enderecoService = new EnderecoService();
                $hasSubdivisions = $enderecoService->countryHasSubdivisions(
                    $oUser->oxuser__oxcountryid->rawValue
                );
                if ($hasSubdivisions && !empty($data['params']['address']['subdivisionCode'])) {
                    $oUser->oxuser__oxstateid->rawValue = $enderecoService->resolveSubdivisionToStateId(
                        $data['params']['address']['subdivisionCode']
                    );
                }

                $status = implode(',', $data['params']['enderecometa']['status']);
                $oUser->oxuser__mojoamsstatus->rawValue = $status;
                $oUser->oxuser__mojoamsts->rawValue = $data['params']['enderecometa']['ts'] ?? '';
                $predictions = json_encode($data['params']['enderecometa']['predictions'] ?? []);
                $oUser->oxuser__mojoamspredictions->rawValue = $predictions;

                // When writing address through endereco modal, always recalculate hash.
                $hash = $this->calculateHash(
                    $oUser->oxuser__oxcountryid->rawValue,
                    $hasSubdivisions ? ($oUser->oxuser__oxstateid->rawValue ?? '') : null,
                    $oUser->oxuser__oxzip->rawValue,
                    $oUser->oxuser__oxcity->rawValue,
                    $oUser->oxuser__oxstreet->rawValue,
                    $oUser->oxuser__oxstreetnr->rawValue,
                    $oUser->oxuser__oxaddinfo->rawValue
                );
                $oUser->oxuser__mojoaddresshash->rawValue = $hash;
                if ($oUser->save()) {
                    $addressChanged = 2;
                }
            }
        }

        if ('editShippingAddress' === $data['method']) {
            // Save shipping address.
            $oAddress = oxNew(Address::class);
            // A missing record and a foreign record are rejected identically, so the
            // response cannot be used to probe which address ids exist.
            if (
                !$oAddress->load($addressId)
                || (string) $oAddress->oxaddress__oxuserid->rawValue !== (string) $oCurrentUser->getId()
            ) {
                $this->deny(403);
            }

            $oAddress->oxaddress__oxzip->rawValue
                = $data['params']['address']['postalCode']
                ? $data['params']['address']['postalCode']
                : $oAddress->oxaddress__oxzip->rawValue;

            $oAddress->oxaddress__oxcity->rawValue
                = $data['params']['address']['locality']
                ? $data['params']['address']['locality']
                : $oAddress->oxaddress__oxcity->rawValue;

            $oAddress->oxaddress__oxstreet->rawValue
                = $data['params']['address']['streetName']
                ? $data['params']['address']['streetName']
                : $oAddress->oxaddress__oxstreet->rawValue;

            $oAddress->oxaddress__oxstreetnr->rawValue
                = $data['params']['address']['buildingNumber']
                ? $data['params']['address']['buildingNumber']
                : $oAddress->oxaddress__oxstreetnr->rawValue;

            $oAddress->oxaddress__oxaddinfo->rawValue
                = $data['params']['address']['additionalInfo']
                ? $data['params']['address']['additionalInfo']
                : $oAddress->oxaddress__oxaddinfo->rawValue;

            $enderecoService = new EnderecoService();
            $hasSubdivisions = $enderecoService->countryHasSubdivisions(
                $oAddress->oxaddress__oxcountryid->rawValue
            );
            if ($hasSubdivisions && !empty($data['params']['address']['subdivisionCode'])) {
                $oAddress->oxaddress__oxstateid->rawValue = $enderecoService->resolveSubdivisionToStateId(
                    $data['params']['address']['subdivisionCode']
                );
            }

            $status = implode(',', $data['params']['enderecometa']['status']);
            $oAddress->oxaddress__mojoamsstatus->rawValue = $status;
            $oAddress->oxaddress__mojoamsts->rawValue = $data['params']['enderecometa']['ts'] ?? '';
            $predictions = json_encode($data['params']['enderecometa']['predictions'] ?? []);
            $oAddress->oxaddress__mojoamspredictions->rawValue = $predictions;

            // When writing address through endereco modal, always recalculate hash.
            $hash = $this->calculateHash(
                $oAddress->oxaddress__oxcountryid->rawValue,
                $hasSubdivisions ? ($oAddress->oxaddress__oxstateid->rawValue ?? '') : null,
                $oAddress->oxaddress__oxzip->rawValue,
                $oAddress->oxaddress__oxcity->rawValue,
                $oAddress->oxaddress__oxstreet->rawValue,
                $oAddress->oxaddress__oxstreetnr->rawValue,
                $oAddress->oxaddress__oxaddinfo->rawValue
            );
            $oAddress->oxaddress__mojoaddresshash->rawValue = $hash;
            if ($oAddress->save()) {
                $addressChanged = 2;
            }
        }

        echo $addressChanged;
        exit();
    }

    /**
     * Validates the structure of the incoming JSON payload.
     *
     * @param mixed $data Decoded request body.
     * @return bool
     */
    private function isValidPayload($data)
    {
        if (!is_array($data) || !isset($data['method'], $data['params']) || !is_array($data['params'])) {
            return false;
        }

        if (!in_array($data['method'], ['editBillingAddress', 'editShippingAddress'], true)) {
            return false;
        }

        $params = $data['params'];
        if (!isset($params['addressId']) || !is_string($params['addressId']) || '' === $params['addressId']) {
            return false;
        }

        if (!isset($params['address']) || !is_array($params['address'])) {
            return false;
        }

        $addressFields = [
            'postalCode',
            'locality',
            'streetName',
            'buildingNumber',
            'additionalInfo',
            'subdivisionCode',
        ];
        foreach ($addressFields as $key) {
            if (isset($params['address'][$key]) && !is_scalar($params['address'][$key])) {
                return false;
            }
        }

        if (
            !isset($params['enderecometa'])
            || !is_array($params['enderecometa'])
            || !isset($params['enderecometa']['status'])
            || !is_array($params['enderecometa']['status'])
        ) {
            return false;
        }

        foreach ($params['enderecometa']['status'] as $status) {
            if (!is_string($status)) {
                return false;
            }
        }

        if (isset($params['enderecometa']['ts']) && !is_scalar($params['enderecometa']['ts'])) {
            return false;
        }

        return true;
    }

    /**
     * Terminates the request with the given HTTP status code.
     *
     * @param int $httpCode
     * @return never
     */
    private function deny($httpCode)
    {
        http_response_code($httpCode);
        echo 0;
        exit();
    }

    /**
     * Calculates a hash based on the provided address components.
     * This is used to ensure the address integrity.
     *
     * TODO: Extract to a shared location — duplicated in OrderController and UserComponent.
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
}
