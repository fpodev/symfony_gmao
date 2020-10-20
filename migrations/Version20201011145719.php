<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201011145719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9A73F0036');
        $this->addSql('DROP INDEX IDX_1483A5E9A73F0036 ON users');
        $this->addSql('ALTER TABLE users DROP ville_id');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C340C6E3A6');
        $this->addSql('DROP INDEX UNIQ_43C3D9C340C6E3A6 ON ville');
        $this->addSql('ALTER TABLE ville DROP user_contact_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9A73F0036 ON users (ville_id)');
        $this->addSql('ALTER TABLE ville ADD user_contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C340C6E3A6 FOREIGN KEY (user_contact_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_43C3D9C340C6E3A6 ON ville (user_contact_id)');
    }
}
