<?php
namespace Endereco\Oxid6Client\Model;

use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;
use \Endereco\Oxid6Client\Component\EnderecoService;

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

        parent::changeUserData($sUser, $sPassword, $sPassword2, $aInvAddress, $aDelAddress);
    }

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
                $this->oxuser__mojoamsstatus->value = $checkedBillingAddress['__status'];
                $this->oxuser__mojoamsts->rawValue = $checkedBillingAddress['__timestamp'];
                $this->oxuser__mojoamspredictions->rawValue = $checkedBillingAddress['__predictions'];
                $this->save();
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
                    $oAddress->oxaddress__mojoamsstatus->value = $checkedShippingAddress['__status'];
                    $oAddress->oxaddress__mojoamsts->rawValue = $checkedShippingAddress['__timestamp'];
                    $oAddress->oxaddress__mojoamspredictions->rawValue = $checkedShippingAddress['__predictions'];
                    $oAddress->save();
                }
            }
        }

        parent::onLogin($sUser, $sPassword);
    }
}
