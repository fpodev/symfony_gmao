<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201112091208 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3E7A1254A');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3E7A1254A FOREIGN KEY (contact_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3E7A1254A');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3E7A1254A FOREIGN KEY (contact_id) REFERENCES users (id)');
    }
}
