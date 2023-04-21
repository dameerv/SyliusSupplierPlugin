<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416221716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Supplier ADD address LONGTEXT NOT NULL, ADD phone1 VARCHAR(255) NOT NULL, ADD phone2 VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD companyDetails LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Supplier DROP address, DROP phone1, DROP phone2, DROP email, DROP companyDetails');
    }
}
