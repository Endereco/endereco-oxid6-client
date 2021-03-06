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
            ADD `MOJOAMSTS` varchar(64) NOT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOAMSSTATUS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOAMSSTATUS` TEXT NOT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOAMSPREDICTIONS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOAMSPREDICTIONS` TEXT NOT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxuser.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSTS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSTS` varchar(64) NOT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxuser.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSSTATUS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSSTATUS` TEXT NOT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSPREDICTIONS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSPREDICTIONS` TEXT NOT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Convert existing ams status to TEXT.
        $aOxUserDetail = DatabaseProvider::getDb()->select("SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
  WHERE table_name = 'oxuser' AND COLUMN_NAME = 'MOJOAMSSTATUS'");
        foreach ($aOxUserDetail as $rowDetail) {
            if ('text' !== strtolower($rowDetail[0])) {
                $sql = "ALTER TABLE `oxuser` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NOT NULL;";
                DatabaseProvider::getDb()->execute($sql);
            }
        }

        $aOxAddressDetail = DatabaseProvider::getDb()->select("SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
  WHERE table_name = 'oxaddress' AND COLUMN_NAME = 'MOJOAMSSTATUS'");
        foreach ($aOxAddressDetail as $rowDetail) {
            if ('text' !== strtolower($rowDetail[0])) {
                $sql = "ALTER TABLE `oxaddress` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NOT NULL;";
                DatabaseProvider::getDb()->execute($sql);
            }
        }
    }
}
