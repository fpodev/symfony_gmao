<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201010085730 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D43CCE3900');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E502438BAC62AF');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP INDEX UNIQ_E16F61D43CCE3900 ON building');
        $this->addSql('ALTER TABLE building DROP city_id_id');
        $this->addSql('ALTER TABLE users ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9A73F0036 ON users (ville_id)');
        $this->addSql('DROP INDEX UNIQ_F6E502438BAC62AF ON works');
        $this->addSql('ALTER TABLE works DROP city_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9A73F0036');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, contact_id_id INT DEFAULT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adress VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, zip_code INT NOT NULL, INDEX IDX_2D5B0234526E8E58 (contact_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234526E8E58 FOREIGN KEY (contact_id_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE ville');
        $this->addSql('ALTER TABLE building ADD city_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D43CCE3900 FOREIGN KEY (city_id_id) REFERENCES city (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E16F61D43CCE3900 ON building (city_id_id)');
        $this->addSql('DROP INDEX IDX_1483A5E9A73F0036 ON users');
        $this->addSql('ALTER TABLE users DROP ville_id');
        $this->addSql('ALTER TABLE works ADD city_id INT NOT NULL');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E502438BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6E502438BAC62AF ON works (city_id)');
    }
}
