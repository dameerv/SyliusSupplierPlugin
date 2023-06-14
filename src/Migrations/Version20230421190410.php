<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421190410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Hola';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dameerv_supplier_file (id INT AUTO_INCREMENT NOT NULL, supplier_id INT NOT NULL, type VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_E1261B402ADD6D8C (supplier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dameerv_supplier_file ADD CONSTRAINT FK_E1261B402ADD6D8C FOREIGN KEY (supplier_id) REFERENCES dameerv_supplier (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dameerv_supplier_file');
    }
}
