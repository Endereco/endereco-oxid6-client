<?php

namespace Endereco\Oxid6Client\Controller\Admin;

use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Request;

class Settings extends \OxidEsales\Eshop\Application\Controller\Admin\AdminController
{
    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'endereco_settings.tpl';

    /**
     * Executes parent method parent::render()
     *
     * @return string
     */
    public function render()
    {
        $oConfig = $this->getConfig();
        parent::render();

        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');
        if (!$sOxId) {
            $sOxId = $oConfig->getShopId();
        }

        $this->_aViewData['oxid'] =  $sOxId;

        $this->_aViewData['cstrs'] = [];

        $sql = "SELECT `OXVARNAME`, DECODE( `OXVARVALUE`, ? ) AS `OXVARVALUE` FROM `oxconfig` WHERE `OXSHOPID` = ? AND `OXMODULE` = 'module:endereco-oxid6-client'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sql,
            [$oConfig->getConfigParam('sConfigKey'), $sOxId]
        );

        foreach ($resultSet as $result) {
            $this->_aViewData['cstrs'][$result[0]] = $result[1];
        }

        // Check connection to remote server.
        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopId();
        $sApiKy = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('sAPIKEY', $sOxId, 'module:endereco-oxid6-client');
        $sEndpoint = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopConfVar('sSERVICEURL', $sOxId, 'module:endereco-oxid6-client');
        $moduleVersions = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('aModuleVersions');
        $sAgentInfo  = "Endereco Oxid6 Client v" . $moduleVersions['endereco-oxid6-client'];
        $bHasConnection = false;
        try {
            $message = [
                'jsonrpc' => '2.0',
                'id' => 1,
                'method' => 'readinessCheck'
            ];
            $client = new Client(['timeout' => 5.0]);

            $newHeaders = [
                'Content-Type' => 'application/json',
                'X-Auth-Key' => $sApiKy,
                'X-Transaction-Id' => 'not_required',
                'X-Transaction-Referer' => 'Settings.php',
                'X-Agent' => $sAgentInfo,
            ];
            $request = new Request('POST', $sEndpoint, $newHeaders, json_encode($message));
            $client->send($request);
            $bHasConnection = true;

        } catch(\Exception $e) {
            // Do nothing.
        }

        $this->_aViewData['cstrs']['bHasConnection'] = $bHasConnection;

        return $this->_sThisTemplate;
    }


    /**
     * Saves changed modules configuration parameters.
     *
     * @return void
     */
    public function save()
    {
        $oConfig = $this->getConfig();
        $checkboxes = [
            'sUSEAMS',
            'sCHECKALL',
            'sAMSBLURTRIGGER',
            'sSMARTFILL',
            'bUseEmailservice',
            'bUsePersonalService',
            'bAllowControllerFilter',
            'bPreselectCountry',
            'sAMSSubmitTrigger',
            'sAMSResumeSubmit',
            'bUseCss',
            'bShowDebug',
            'bShowEmailserviceErrors',
            'bChangeFieldsOrder'
        ];

        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxid');
        $aConfStrs = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('cstrs');

        if (
            class_exists(\OxidEsales\EshopCommunity\Internal\Container\ContainerFactory::class)
        ) {
            $moduleSettingBridge = \OxidEsales\EshopCommunity\Internal\Container\ContainerFactory::getInstance()
                ->getContainer()
                ->get(\OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ModuleSettingBridgeInterface::class);

            if (is_array($aConfStrs)) {
                foreach ($aConfStrs as $sVarName => $sVarVal) {
                    if (in_array($sVarName, $checkboxes)) {
                        $moduleSettingBridge->save($sVarName, true, 'endereco-oxid6-client');
                    } else {
                        $moduleSettingBridge->save($sVarName, $sVarVal, 'endereco-oxid6-client');
                    }
                }
            }

            foreach ($checkboxes as $checkboxname) {
                if (!isset($aConfStrs[$checkboxname])) {
                    $moduleSettingBridge->save($checkboxname, false, 'endereco-oxid6-client');
                }
            }
        } else {

            if (is_array($aConfStrs)) {
                foreach ($aConfStrs as $sVarName => $sVarVal) {
                    if (in_array($sVarName, $checkboxes)) {
                        $oConfig->saveShopConfVar('bool', $sVarName, true, $sOxId, 'module:endereco-oxid6-client');
                    } else {
                        $oConfig->saveShopConfVar('str', $sVarName, $sVarVal, $sOxId, 'module:endereco-oxid6-client');
                    }

                }
            }

            foreach ($checkboxes as $checkboxname) {
                if (!isset($aConfStrs[$checkboxname])) {
                    $oConfig->saveShopConfVar('bool', $checkboxname, false, $sOxId, 'module:endereco-oxid6-client');
                }
            }
        }





        return;
    }


    /**
     * Checks if endereco service is available and if the api key is correct.
     *
     * @return int
     */
    public function checkConnection()
    {

    }
}
