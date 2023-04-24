<?php

declare(strict_types=1);

namespace Dameerv\SyliusSupplierPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421190409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Hola';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS dameerv_supplier_channel (supplier_id INT NOT NULL, PRIMARY KEY(supplier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IF NOT EXISTS dameerv_supplier_product (product_id INT NOT NULL, supplier_id INT NOT NULL, INDEX IDX_653BEDDA4584665A (product_id), INDEX IDX_653BEDDA2ADD6D8C (supplier_id), PRIMARY KEY(product_id, supplier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dameerv_supplier_product ADD CONSTRAINT FK_653BEDDA4584665A FOREIGN KEY (product_id) REFERENCES dameerv_supplier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dameerv_supplier_product ADD CONSTRAINT FK_653BEDDA2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES sylius_product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE IF EXISTS dameerv_supplier_channels');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS dameerv_supplier_channels (channel_id INT NOT NULL, supplier_id INT NOT NULL, INDEX IDX_E8830B372F5A1AA (channel_id), INDEX IDX_E8830B32ADD6D8C (supplier_id), PRIMARY KEY(channel_id, supplier_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dameerv_supplier_channels ADD CONSTRAINT  IF NOT EXISTS FK_E8830B32ADD6D8C FOREIGN KEY (supplier_id) REFERENCES dameerv_supplier (id)');
        $this->addSql('ALTER TABLE dameerv_supplier_channels ADD CONSTRAINT  IF NOT EXISTS FK_E8830B372F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id)');
        $this->addSql('DROP TABLE IF  EXISTS dameerv_supplier_channel');
        $this->addSql('DROP TABLE IF EXISTS dameerv_supplier_product');
        $this->addSql('ALTER TABLE IF  EXISTS sylius_product ADD supplier_id INT NOT NULL');
    }
}
