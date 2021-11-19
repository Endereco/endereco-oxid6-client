<?php

namespace Endereco\Oxid6Client\Widget;


class IncludeColorWidget extends \OxidEsales\Eshop\Application\Component\Widget\WidgetController
{
    /**
     * @var string Widget template
     */
    protected $_sThisTemplate = 'enderecocolor.tpl';


    /**
     * Render
     *
     * @return string Template name.
     */
    public function render()
    {
        parent::render();

        $oConfig = $this->getConfig();
        $sOxId = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestEscapedParameter('oxid');
        if (!$sOxId) {
            $sOxId = $oConfig->getShopId();
        }
        $this->_aViewData['enderecoclient'] = [];

        $sql = "SELECT `OXVARNAME`, DECODE( `OXVARVALUE`, ? ) AS `OXVARVALUE` FROM `oxconfig` WHERE `OXSHOPID` = ? AND `OXMODULE` = 'module:endereco-oxid6-client'";
        $resultSet = \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->getAll(
            $sql,
            [$oConfig->getConfigParam('sConfigKey'), $sOxId]
        );
        $settings = [];

        foreach ($resultSet as $result) {
            $settings[$result[0]] = $result[1];
            $this->_aViewData['enderecoclient'][$result[0]] = $result[1];
        }

        if ($settings['sMainColor']) {
            list($red, $gren, $blue) = $this->_hex2rgb($settings['sMainColor']);
            $this->_aViewData['enderecoclient']['sMainColorBG'] = "rgba($red, $gren, $blue, 0.1)";
        }

        if ($settings['sErrorColor']) {
            list($red, $gren, $blue) = $this->_hex2rgb($settings['sErrorColor']);
            $this->_aViewData['enderecoclient']['sErrorColorBG'] = "rgba($red, $gren, $blue, 0.125)";
        }

        if ($settings['sSelectionColor']) {
            list($red, $gren, $blue) = $this->_hex2rgb($settings['sSelectionColor']);
            $this->_aViewData['enderecoclient']['sSelectionColorBG'] = "rgba($red, $gren, $blue, 0.125)";
        }

        return $this->_sThisTemplate;
    }

    private function _hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        return [$r, $g, $b];
    }
}
