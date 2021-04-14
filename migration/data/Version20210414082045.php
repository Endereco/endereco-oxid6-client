<?php declare(strict_types=1);

namespace Endereco\Oxid6Client\migration\data;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210414082045 extends AbstractMigration
{

    public function preUp(Schema $schema)
    {
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        if ($schema->getTable('oxaddress')->hasColumn('MOJOAMSPREDICTIONS')) {
            $this->skipIf(true, "is already installed");
        };
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql(
            "ALTER TABLE `oxaddress`
            ADD `MOJOAMSPREDICTIONS` TEXT NOT NULL AFTER `OXADDRESSUSERID`"
        );

        $this->addSql(
            "ALTER TABLE `oxuser`
            ADD `MOJOAMSPREDICTIONS` TEXT NOT NULL AFTER `OXPASSSALT`;"
        );

        $this->addSql(
            "ALTER TABLE `oxaddress` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NOT NULL"
        );

        $this->addSql(
            "ALTER TABLE `oxuser` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` text NOT NULL"
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `oxaddress` DROP `MOJOAMSPREDICTIONS`');
        $this->addSql('ALTER TABLE `oxuser` DROP `MOJOAMSPREDICTIONS`');
        $this->addSql('ALTER TABLE `oxaddress` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` varchar(64) NOT NULL');
        $this->addSql('ALTER TABLE `oxuser` CHANGE `MOJOAMSSTATUS` `MOJOAMSSTATUS` varchar(64) NOT NULL');
    }
}
