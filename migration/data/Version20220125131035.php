<?php
namespace Endereco\Oxid6Client\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220125131035 extends AbstractMigration
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function preUp(Schema $schema): void
    {
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * @param Schema $schema
     * 
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function up(Schema $schema): void
    {
        // Add a column for name scoring.
        if (!$schema->getTable('oxuser')->hasColumn('MOJONAMESCORE')) {
            $this->addSql(
                "ALTER TABLE `oxuser`
                    ADD `MOJONAMESCORE` double NOT NULL DEFAULT '1.0';"
            );
        }
        if (!$schema->getTable('oxaddress')->hasColumn('MOJONAMESCORE')) {
            $this->addSql(
                "ALTER TABLE `oxaddress`
                    ADD `MOJONAMESCORE` double NOT NULL DEFAULT '1.0';"
            );
        }

        // Add a column for state mapping.
        if (!$schema->getTable('oxstates')->hasColumn('MOJOISO31662')) {
            $this->addSql(
                "ALTER TABLE `oxstates`
                    ADD `MOJOISO31662` char(6) NULL;"
            );

            // Fill up missing states iso codes once. In general its better to double check, because the default OXISOALPHA2
            // only allows 2 characters, which is not enough for some countries e.g. Mexico
            $this->addSql("
                INSERT INTO `oxstates` (`OXID`, `OXCOUNTRYID`, `MOJOISO31662`)
                SELECT 
                    `oxstates`.`OXID`, 
                    `oxstates`.`OXCOUNTRYID`,
                    CASE 
                        WHEN `oxstates`.`OXISOALPHA2` REGEXP '^[A-Z]{2}-[A-Z0-9]{1,3}$' THEN `oxstates`.`OXISOALPHA2`
                        ELSE CONCAT(`oxcountry`.`OXISOALPHA2`, '-', `oxstates`.`OXISOALPHA2`)
                    END AS `MOJOISO31662`
                FROM `oxstates`
                JOIN `oxcountry` ON `oxcountry`.`OXID` = `oxstates`.`OXCOUNTRYID`
                WHERE `oxstates`.`MOJOISO31662` IS NULL
                ON DUPLICATE KEY UPDATE `MOJOISO31662` = VALUES(`MOJOISO31662`)
            ");
        }

        // Allow created columns to be NULL
        if ($schema->getTable('oxuser')->hasColumn('MOJOAMSTS')) {
            $this->addSql(
                "ALTER TABLE `oxuser`
                    CHANGE `MOJOAMSTS` `MOJOAMSTS` text NULL;"
            );
        }
        if ($schema->getTable('oxuser')->hasColumn('MOJOAMSSTATUS')) {
            $this->addSql(
                "ALTER TABLE `oxuser`
                    CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NULL;"
            );
        }
        if ($schema->getTable('oxuser')->hasColumn('MOJOAMSPREDICTIONS')) {
            $this->addSql(
                "ALTER TABLE `oxuser`
                    CHANGE `MOJOAMSPREDICTIONS` `MOJOAMSPREDICTIONS` text NULL;"
            );
        }

        // Allow created columns to be NULL
        if ($schema->getTable('oxaddress')->hasColumn('MOJOAMSTS')) {
            $this->addSql(
                "ALTER TABLE `oxaddress`
                    CHANGE `MOJOAMSTS` `MOJOAMSTS` text NULL;"
            );
        }
        if ($schema->getTable('oxaddress')->hasColumn('MOJOAMSSTATUS')) {
            $this->addSql(
                "ALTER TABLE `oxaddress`
                    CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NULL;"
            );
        }
        if ($schema->getTable('oxaddress')->hasColumn('MOJOAMSPREDICTIONS')) {
            $this->addSql(
                "ALTER TABLE `oxaddress`
                    CHANGE `MOJOAMSPREDICTIONS` `MOJOAMSPREDICTIONS` text NULL;"
            );
        }
    }

    /**
     * @param Schema $schema
     * 
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `oxuser` DROP `MOJONAMESCORE`;');
        $this->addSql('ALTER TABLE `oxaddress` DROP `MOJONAMESCORE`;');
        $this->addSql('ALTER TABLE `oxstates` DROP `MOJOISO31662`;');

        // Not NULL is buggy and doesn't need to be restored.
    }
}
