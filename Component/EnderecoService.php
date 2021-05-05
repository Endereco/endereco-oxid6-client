<?php

namespace Endereco\Oxid6Client\Component;

use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;

class EnderecoService
{
    private $_apiKey;
    private $_endpoint;
    private $_moduleVer;

    public function __construct() {
        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopId();
        $this->_apiKey = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('sAPIKEY', $sOxId, 'module:endereco-oxid6-client');
        $this->_endpoint = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('sSERVICEURL', $sOxId, 'module:endereco-oxid6-client');
        $moduleVersions = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('aModuleVersions');
        $this->_moduleVer  = "Endereco Oxid6 Client v" . $moduleVersions['endereco-oxid6-client'];
    }

    public function closeSession($sessionId)
    {

    }

    public function closeConversion($sessionId)
    {

    }

    /**
     * This functions inspects POST and tries to find open sessions in it.
     * In case something is found, doaccountings are sent.
     *
     * This should happen before any validation
     * @see https://github.com/Endereco/endereco-oxid6-client/issues/9
     */
    public function findAndCloseEnderecoSessions()
    {
        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopId();
        $sApiKy = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('sAPIKEY', $sOxId, 'module:endereco-oxid6-client');
        $sEndpoint = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('sSERVICEURL', $sOxId, 'module:endereco-oxid6-client');
        $moduleVersions = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('aModuleVersions');
        $sAgentInfo  = "Endereco Oxid6 Client v" . $moduleVersions['endereco-oxid6-client'];

        $bAnyDoAccounting = false;

        if ($_POST) {
            foreach ($_POST as $sVarName => $sVarValue) {

                if ((strpos($sVarName, '_session_counter') !== false) && 0 < intval($sVarValue)) {
                    $sSessionIdName = str_replace('_session_counter', '', $sVarName) . '_session_id';
                    $sSessionId = $_POST[$sSessionIdName];
                    try {
                        $message = [
                            'jsonrpc' => '2.0',
                            'id' => 1,
                            'method' => 'doAccounting',
                            'params' => [
                                'sessionId' => $sSessionId
                            ]
                        ];
                        $client = new Client(['timeout' => 5.0]);

                        $newHeaders = [
                            'Content-Type' => 'application/json',
                            'X-Auth-Key' => $sApiKy,
                            'X-Transaction-Id' => $sSessionId,
                            'X-Transaction-Referer' => $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:__FILE__,
                            'X-Agent' => $sAgentInfo,
                        ];
                        $request = new Request('POST', $sEndpoint, $newHeaders, json_encode($message));
                        $client->send($request);
                        $bAnyDoAccounting = true;

                    } catch(\Exception $e) {
                        // Do nothing.
                    }
                }
            }
        }

        if ($bAnyDoAccounting) {
            try {
                $message = [
                    'jsonrpc' => '2.0',
                    'id' => 1,
                    'method' => 'doConversion',
                    'params' => []
                ];
                $client = new Client(['timeout' => 5.0]);
                $newHeaders = [
                    'Content-Type' => 'application/json',
                    'X-Auth-Key' => $sApiKy,
                    'X-Transaction-Id' => 'not_required',
                    'X-Transaction-Referer' => $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:__FILE__,
                    'X-Agent' => $sAgentInfo,
                ];
                $request = new Request('POST', $sEndpoint, $newHeaders, json_encode($message));
                $client->send($request);
            } catch(\Exception $e) {
                // Do nothing.
            }
        }
    }

    public function checkAddress($address)
    {
        try {
            $message = [
                'jsonrpc' => '2.0',
                'id' => 1,
                'method' => 'addressCheck',
                'params' => [
                    'country' => $address['countryCode'],
                    'language' => $address['__language'],
                    'postCode' => $address['postalCode'],
                    'cityName' => $address['locality'],
                    'street' => $address['streetName'],
                    'houseNumber' => $address['buildingNumber'],
                ]
            ];
            $client = new Client(['timeout' => 6.0]);
            $sSessionId = $this->generateSessionId();
            $newHeaders = [
                'Content-Type' => 'application/json',
                'X-Auth-Key' => $this->_apiKey,
                'X-Transaction-Id' => $sSessionId,
                'X-Transaction-Referer' => $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:__FILE__,
                'X-Agent' => $this->_moduleVer,
            ];

            $request = new Request('POST', $this->_endpoint, $newHeaders, json_encode($message));
            $response = $client->send($request);
            $responseJson = $response->getBody()->getContents();
            $reponseArray = json_decode($responseJson, true);
            if (array_key_exists('result', $reponseArray)) {
                $result = $reponseArray['result'];

                $predictions = array();
                $maxPredictions = 6;
                $counter = 0;
                foreach ($result['predictions'] as $prediction) {
                    $tempAddress = array(
                        'countryCode' => $prediction['countryCode']?$prediction['countryCode']:$address['countryCode'],
                        'postalCode' => $prediction['postCode'],
                        'locality' => $prediction['cityName'],
                        'streetName' => $prediction['street'],
                        'buildingNumber' => $prediction['houseNumber']
                    );
                    if (array_key_exists('additionalInfo', $prediction)) {
                        $tempAddress['additionalInfo'] = $prediction['additionalInfo'];
                    }

                    $predictions[] = $tempAddress;
                    $counter++;
                    if ($counter >= $maxPredictions) {
                        break;
                    }
                }

                $address['__predictions'] = json_encode($predictions);
                $address['__timestamp'] = time();
                $address['__status'] = implode(',', $this->normalizeStatusCodes($result['status']));
            }
        } catch(\Exception $e) {
            // Do nothing.
        }

        // If checked, send doAccounting.
        $bAnyDoAccounting = false;
        try {
            $message = [
                'jsonrpc' => '2.0',
                'id' => 1,
                'method' => 'doAccounting',
                'params' => [
                    'sessionId' => $sSessionId
                ]
            ];
            $client = new Client(['timeout' => 5.0]);

            $newHeaders = [
                'Content-Type' => 'application/json',
                'X-Auth-Key' => $this->_apiKey,
                'X-Transaction-Id' => $sSessionId,
                'X-Transaction-Referer' => $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:__FILE__,
                'X-Agent' => $this->_moduleVer,
            ];
            $request = new Request('POST', $this->_endpoint, $newHeaders, json_encode($message));
            $client->send($request);
            $bAnyDoAccounting = true;
        } catch(\Exception $e) {
            // Do nothing.
        }

        if ($bAnyDoAccounting) {
            try {
                $message = [
                    'jsonrpc' => '2.0',
                    'id' => 1,
                    'method' => 'doConversion',
                    'params' => []
                ];
                $client = new Client(['timeout' => 5.0]);
                $newHeaders = [
                    'Content-Type' => 'application/json',
                    'X-Auth-Key' => $this->_apiKey,
                    'X-Transaction-Id' => 'not_required',
                    'X-Transaction-Referer' => $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:__FILE__,
                    'X-Agent' => $this->_moduleVer,
                ];
                $request = new Request('POST', $this->_endpoint, $newHeaders, json_encode($message));
                $client->send($request);
            } catch(\Exception $e) {
                // Do nothing.
            }
        }

        return $address;
    }

    public function generateSessionId()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function normalizeStatusCodes($statusCodes) {
        // Create an array of statuses.
        if (
            in_array('A1000', $statusCodes) &&
            !in_array('A1100', $statusCodes)
        ) {
            $statusCodes[] = 'address_correct';
            if (($key = array_search('A1000', $statusCodes)) !== false) {
                unset($statusCodes[$key]);
            }
        }
        if (
            in_array('A1000', $statusCodes) &&
            in_array('A1100', $statusCodes)
        ) {
            $statusCodes[] = 'address_needs_correction';
            if (($key = array_search('A1000', $statusCodes)) !== false) {
                unset($statusCodes[$key]);
            }
            if (($key = array_search('A1100', $statusCodes)) !== false) {
                unset($statusCodes[$key]);
            }
        }
        if (
            in_array('A2000', $statusCodes)
        ) {
            $statusCodes[] = 'address_multiple_variants';
            if (($key = array_search('A2000', $statusCodes)) !== false) {
                unset($statusCodes[$key]);
            }
        }
        if (
            in_array('A3000', $statusCodes)
        ) {
            $statusCodes[] = 'address_not_found';
            if (($key = array_search('A3000', $statusCodes)) !== false) {
                unset($statusCodes[$key]);
            }
        }
        if (
            in_array('A3100', $statusCodes)
        ) {
            $statusCodes[] = 'address_is_packstation';
            if (($key = array_search('A3100', $statusCodes)) !== false) {
                unset($statusCodes[$key]);
            }
        }

        return $statusCodes;
    }

    public function shouldBeChecked($statusCodes) {
        return !(
            in_array('address_not_found', $statusCodes) ||
            in_array('address_needs_correction', $statusCodes) ||
            in_array('address_correct', $statusCodes) ||
            in_array('address_multiple_variants', $statusCodes) ||
            in_array('address_of_not_supported_type', $statusCodes) ||
            in_array('address_selected_by_customer', $statusCodes)
        );
    }
}
