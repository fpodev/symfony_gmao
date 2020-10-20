<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201010075248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city ADD contact_id_id INT DEFAULT NULL, DROP id_contact');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234526E8E58 FOREIGN KEY (contact_id_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234526E8E58 ON city (contact_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234526E8E58');
        $this->addSql('DROP INDEX IDX_2D5B0234526E8E58 ON city');
        $this->addSql('ALTER TABLE city ADD id_contact INT NOT NULL, DROP contact_id_id');
    }
}
