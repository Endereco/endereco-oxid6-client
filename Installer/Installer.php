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

        if (!isset(self::$configReader->bEnderecoUseMigrations) && self::$configReader->bEnderecoUseMigrations) {
            return;
        }

        // Underneath is a fallback in case your system can't use migrations.

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOAMSTS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOAMSTS` varchar(64) NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOAMSSTATUS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOAMSSTATUS` TEXT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOAMSPREDICTIONS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOAMSPREDICTIONS` TEXT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxuser.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSTS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSTS` varchar(64) NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxuser.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSSTATUS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSSTATUS` TEXT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxaddress.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOAMSPREDICTIONS';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOAMSPREDICTIONS` TEXT NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Convert existing ams status to TEXT.
        $aOxUserDetail = DatabaseProvider::getDb()->select("SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
  WHERE table_name = 'oxuser' AND COLUMN_NAME = 'MOJOAMSSTATUS'");
        foreach ($aOxUserDetail as $rowDetail) {
            if ('text' !== strtolower($rowDetail[0])) {
                $sql = "ALTER TABLE `oxuser` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` TEXT NULL;";
                DatabaseProvider::getDb()->execute($sql);
            }
        }

        $aOxAddressDetail = DatabaseProvider::getDb()->select("SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
  WHERE table_name = 'oxaddress' AND COLUMN_NAME = 'MOJOAMSSTATUS'");
        foreach ($aOxAddressDetail as $rowDetail) {
            if ('text' !== strtolower($rowDetail[0])) {
                $sql = "ALTER TABLE `oxaddress` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` TEXT NULL;";
                DatabaseProvider::getDb()->execute($sql);
            }
        }

        // Add NAMESCORE
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJONAMESCORE';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJONAMESCORE` double NOT NULL DEFAULT '1.0';";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJONAMESCORE';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJONAMESCORE` double NOT NULL DEFAULT '1.0';";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Extend oxtates.
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxstates` LIKE 'MOJOISO31662';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxstates`
                    ADD `MOJOISO31662` char(6) NULL;";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Fill up missing states iso codes once. In general its better to double check, because the default OXISOALPHA2
        // only allows 2 characters, which is not enough for some countries e.g. Mexico
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxstates` LIKE 'MOJOISO31662';");
        if (0 !== count($aColumns)) {
            $sql = "INSERT INTO `oxstates` (`OXID`, `OXCOUNTRYID`, `MOJOISO31662`)
                    SELECT 
                        `oxstates`.`OXID`, 
                        `oxstates`.`OXCOUNTRYID`,
                        CASE 
                            WHEN `oxstates`.`OXISOALPHA2` REGEXP '^[A-Z]{2}-[A-Z0-9]{1,3}$' 
                                THEN `oxstates`.`OXISOALPHA2`
                            ELSE CONCAT(`oxcountry`.`OXISOALPHA2`, '-', `oxstates`.`OXISOALPHA2`)
                        END AS `MOJOISO31662`
                    FROM `oxstates`
                    JOIN `oxcountry` ON `oxcountry`.`OXID` = `oxstates`.`OXCOUNTRYID`
                    WHERE `oxstates`.`MOJOISO31662` IS NULL
                    ON DUPLICATE KEY UPDATE `MOJOISO31662` = VALUES(`MOJOISO31662`);";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);

        // Add HASH columns
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxuser` LIKE 'MOJOADDRESSHASH';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxuser`
            ADD `MOJOADDRESSHASH` VARCHAR(64) NOT NULL DEFAULT '';";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);
        $aColumns = DatabaseProvider::getDb()->getAll("SHOW COLUMNS FROM `oxaddress` LIKE 'MOJOADDRESSHASH';");
        if (0 === count($aColumns)) {
            $sql = "ALTER TABLE `oxaddress`
            ADD `MOJOADDRESSHASH` VARCHAR(64) NOT NULL DEFAULT '';";
            DatabaseProvider::getDb()->execute($sql);
        }
        unset($aColumns);
    }
}
