<?php
namespace Endereco\Oxid6Client\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210614111035 extends AbstractMigration
{
    public function preUp(Schema $schema)
    {
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // Create columns in oxuser.
        if (!$schema->getTable('oxuser')->hasColumn('MOJOAMSTS')) {
            $this->addSql(
                "ALTER TABLE `oxuser`
                ADD `MOJOAMSTS` varchar(64) NOT NULL;"
            );
        }
        if (!$schema->getTable('oxuser')->hasColumn('MOJOAMSSTATUS')) {
            $this->addSql(
                "ALTER TABLE `oxuser`
                ADD `MOJOAMSSTATUS` text NOT NULL;"
            );
        }
        if (!$schema->getTable('oxuser')->hasColumn('MOJOAMSPREDICTIONS')) {
            $this->addSql(
                "ALTER TABLE `oxuser`
                ADD `MOJOAMSPREDICTIONS` text NOT NULL;"
            );
        }

        // Create columns in oxaddress
        if (!$schema->getTable('oxaddress')->hasColumn('MOJOAMSTS')) {
            $this->addSql(
                "ALTER TABLE `oxaddress`
                ADD `MOJOAMSTS` varchar(64) NOT NULL;"
            );
        }
        if (!$schema->getTable('oxaddress')->hasColumn('MOJOAMSSTATUS')) {
            $this->addSql(
                "ALTER TABLE `oxaddress`
                ADD `MOJOAMSSTATUS` text NOT NULL;"
            );
        }
        if (!$schema->getTable('oxaddress')->hasColumn('MOJOAMSPREDICTIONS')) {
            $this->addSql(
                "ALTER TABLE `oxaddress`
                ADD `MOJOAMSPREDICTIONS` text NOT NULL;"
            );
        }

        // Check if the type of MOJOAMSSTATUS is not "text" and change it to "text" if needed.
        if (
            $schema->getTable('oxuser')->hasColumn('MOJOAMSSTATUS') &&
            ('text' !== strtolower($schema->getTable('oxuser')->getColumn('MOJOAMSSTATUS')->getType()))
        ) {
            $this->addSql(
                "ALTER TABLE `oxuser` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NOT NULL;"
            );
        }

        if (
            $schema->getTable('oxaddress')->hasColumn('MOJOAMSSTATUS') &&
            ('text' !== strtolower($schema->getTable('oxaddress')->getColumn('MOJOAMSSTATUS')->getType()))
        ) {
            $this->addSql(
                "ALTER TABLE `oxaddress` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NOT NULL;"
            );
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `oxaddress` DROP `MOJOAMSTS`;');
        $this->addSql('ALTER TABLE `oxaddress` DROP `MOJOAMSSTATUS`;');
        $this->addSql('ALTER TABLE `oxaddress` DROP `MOJOAMSPREDICTIONS`;');
        $this->addSql('ALTER TABLE `oxuser` DROP `MOJOAMSTS`;');
        $this->addSql('ALTER TABLE `oxuser` DROP `MOJOAMSSTATUS`;');
        $this->addSql('ALTER TABLE `oxuser` DROP `MOJOAMSPREDICTIONS`;');
    }
}
