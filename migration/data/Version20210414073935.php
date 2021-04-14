<?php declare(strict_types=1);

namespace Endereco\Oxid6Client\migration\data;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210414073935 extends AbstractMigration
{
    public function preUp(Schema $schema)
    {
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        if ($schema->getTable('oxaddress')->hasColumn('MOJOAMSTS')) {
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
            ADD `MOJOAMSTS` varchar(64) NOT NULL AFTER `OXADDRESSUSERID`"
        );

        $this->addSql(
            "ALTER TABLE `oxaddress`
            ADD `MOJOAMSSTATUS` varchar(64) NOT NULL DEFAULT 'address_not_checked' AFTER `OXADDRESSUSERID`;"
        );

        $this->addSql(
            "ALTER TABLE `oxuser`
            ADD `MOJOAMSTS` varchar(64) NOT NULL AFTER `OXPASSSALT`"
        );

        $this->addSql(
            "ALTER TABLE `oxuser`
            ADD `MOJOAMSSTATUS` varchar(64) NOT NULL DEFAULT 'address_not_checked' AFTER `OXPASSSALT`;"
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `oxaddress` DROP `MOJOAMSTS`;');
        $this->addSql('ALTER TABLE `oxaddress` DROP `MOJOAMSSTATUS`;');
        $this->addSql('ALTER TABLE `oxuser` DROP `MOJOAMSTS`;');
        $this->addSql('ALTER TABLE `oxuser` DROP `MOJOAMSSTATUS`;');
    }
}
