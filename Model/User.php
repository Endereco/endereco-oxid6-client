<?php
namespace Endereco\Oxid6Client\Model;

use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;

class User extends User_parent
{

    /**
     * When changing/updating user information in frontend this method validates user
     * input. If data is fine - automatically assigns this values. Additionally calls
     * methods (\OxidEsales\Eshop\Application\Model\User::_setAutoGroups, \OxidEsales\Eshop\Application\Model\User::setNewsSubscription) to perform automatic
     * groups assignment and returns newsletter subscription status. If some action
     * fails - exception is thrown.
     *
     * @param string $sUser       user login name
     * @param string $sPassword   user password
     * @param string $sPassword2  user confirmation password
     * @param array  $aInvAddress user billing address
     * @param array  $aDelAddress delivery address
     *
     * @throws oxUserException, oxInputException, oxConnectionException
     */
    public function changeUserData($sUser, $sPassword, $sPassword2, $aInvAddress, $aDelAddress)
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
                            'X-Transaction-Referer' => 'UserComponent.php',
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
                    'X-Transaction-Referer' => 'UserComponent.php',
                    'X-Agent' => $sAgentInfo,
                ];
                $request = new Request('POST', $sEndpoint, $newHeaders, json_encode($message));
                $client->send($request);
            } catch(\Exception $e) {
                // Do nothing.
            }
        }

        parent::changeUserData($sUser, $sPassword, $sPassword2, $aInvAddress, $aDelAddress);
    }
}
