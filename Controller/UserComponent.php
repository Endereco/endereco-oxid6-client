<?php

namespace Endereco\Oxid6Client\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class UserComponent extends UserComponent_parent
{
    /**
     * This functions inspects POST and tries to find open sessions in it.
     * In case something is found, doaccountings are sent.
     *
     * This should happen before any validation
     * @see https://github.com/Endereco/endereco-oxid6-client/issues/9
     */
    private function findAndCloseEnderecoSessions()
    {
        $sOxId = (string) \OxidEsales\Eshop\Core\Registry::getConfig()->getShopId();
        $sApiKy = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar(
            'sAPIKEY',
            $sOxId,
            'module:endereco-oxid6-client'
        );
        $sEndpoint = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar(
            'sSERVICEURL',
            $sOxId,
            'module:endereco-oxid6-client'
        );
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
                            'X-Transaction-Referer' => $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : __FILE__,
                            'X-Agent' => $sAgentInfo,
                        ];
                        $request = new Request('POST', $sEndpoint, $newHeaders, json_encode($message));
                        $client->send($request);
                        $bAnyDoAccounting = true;
                    } catch (\Exception $e) {
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
                    'X-Transaction-Referer' => $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : __FILE__,
                    'X-Agent' => $sAgentInfo,
                ];
                $request = new Request('POST', $sEndpoint, $newHeaders, json_encode($message));
                $client->send($request);
            } catch (\Exception $e) {
                // Do nothing.
            }
        }
    }

    // phpcs:disable
    public function changeuser_testvalues()
    {
        // phpcs:enable
        $this->findAndCloseEnderecoSessions();
        return parent::changeuser_testvalues();
    }

    public function changeUser()
    {
        $this->findAndCloseEnderecoSessions();
        return parent::changeUser();
    }

    public function createUser()
    {
        $this->findAndCloseEnderecoSessions();
        return parent::createUser();
    }
}
