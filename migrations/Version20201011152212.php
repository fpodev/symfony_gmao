<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201011152212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_43C3D9C3A76ED395 ON ville (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3A76ED395');
        $this->addSql('DROP INDEX UNIQ_43C3D9C3A76ED395 ON ville');
        $this->addSql('ALTER TABLE ville DROP user_id');
    }
}
