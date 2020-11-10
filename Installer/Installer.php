<?php
namespace Endereco\Oxid6Client\Installer;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use tm\oxid\SchemaExpander\DesireExpander;

class Installer
{

    public static function onActivate()
    {
        $desireExpander = new DesireExpander();

        // Extend oxaddress.
        $desireExpander->table('oxaddress')
            ->addField('MOJOAMSSTATUS', "varchar(64) NOT NULL DEFAULT 'address_not_checked'")->after('OXADDRESSUSERID')
            ->addField('MOJOAMSTS', 'varchar(64) NOT NULL');

        // Extend oxuser.
        $desireExpander->table('oxuser')
            ->addField('MOJOAMSSTATUS', "varchar(64) NOT NULL DEFAULT 'address_not_checked'")->after('OXPASSSALT')
            ->addField('MOJOAMSTS', 'varchar(64) NOT NULL');

        $desireExpander->execute();
    }

    public static function onDeactivate()
    {
        self::cleanTmp();
    }

    public static function cleanTmp($sClearFolderPath = '')
    {
        $sTempFolderPath = realpath(Registry::getConfig()->getConfigParam('sCompileDir'));

        if (!empty($sClearFolderPath) &&
            ( strpos($sClearFolderPath, $sTempFolderPath) !== false ) &&
            is_dir($sClearFolderPath)
        ) {
            $sFolderPath = $sClearFolderPath;
        } elseif (empty($sClearFolderPath)) {
            $sFolderPath = $sTempFolderPath;
        } else {
            return false;
        }

        $hDir = opendir($sFolderPath);

        if (!empty($hDir)) {
            while (false !== ($sFileName = readdir($hDir))) {
                $sFilePath = $sFolderPath . '/' . $sFileName;

                if (!in_array($sFileName, ['.', '..', '.htaccess']) &&
                    is_file($sFilePath)
                ) {
                    @unlink($sFilePath);
                } elseif (('smarty' === $sFileName) && is_dir($sFilePath)) {
                    self::cleanTmp($sFilePath);
                }
            }
        }

        return true;
    }
}
