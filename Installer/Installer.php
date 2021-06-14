<?php
namespace Endereco\Oxid6Client\Installer;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Facts\Config\ConfigFile;

class Installer
{
    private static $configReader;

    public static function onActivate()
    {
        if (is_null(self::$configReader)) {
            self::$configReader = new ConfigFile();
        }

        if (!empty(self::$configReader->bEnderecoUseMigrations) && self::$configReader->bEnderecoUseMigrations) {
            return;
        }

        // Underneath is a fallback in case your system can't use migrations.

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOAMSTS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOAMSTS` varchar(64) NOT NULL AFTER `OXADDRESSUSERID`;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOAMSSTATUS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOAMSSTATUS` TEXT NOT NULL DEFAULT 'address_not_checked' AFTER `OXADDRESSUSERID`;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOAMSPREDICTIONS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOAMSPREDICTIONS` TEXT NOT NULL AFTER `OXADDRESSUSERID`;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxuser.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSTS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSTS` varchar(64) NOT NULL AFTER `OXPASSSALT`;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxuser.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSSTATUS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSSTATUS` TEXT NOT NULL DEFAULT 'address_not_checked' AFTER `OXPASSSALT`;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSPREDICTIONS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSPREDICTIONS` TEXT NOT NULL AFTER `OXPASSSALT`;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Convert existing ams status to TEXT.
        $aOxUserDetail = DatabaseProvider::getDb()->select("DESCRIBE oxuser;");
        foreach ($aOxUserDetail as $rowDetail) {
            if ('MOJOAMSSTATUS' === $rowDetail[0] && 'text' !== $rowDetail[0]) {
                $sql = "ALTER TABLE `oxuser` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NOT NULL;";
                DatabaseProvider::getDb()->execute($sql);
            }
        }
        $aOxAddressDetail = DatabaseProvider::getDb()->select("DESCRIBE oxaddress;");
        foreach ($aOxAddressDetail as $rowDetail) {
            if ('MOJOAMSSTATUS' === $rowDetail[0] && 'text' !== $rowDetail[0]) {
                $sql = "ALTER TABLE `oxaddress` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NOT NULL;";
                DatabaseProvider::getDb()->execute($sql);
            }
        }
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
