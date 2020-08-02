<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724141146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE works (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, building_id INT NOT NULL, sector_id INT NOT NULL, epuipement_id INT NOT NULL, user_applicant_id INT NOT NULL, technician_id INT DEFAULT NULL, external_responce_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, task VARCHAR(255) NOT NULL, create_date DATETIME NOT NULL, validate_date DATE DEFAULT NULL, estimate VARCHAR(255) DEFAULT NULL, invoice VARCHAR(255) DEFAULT NULL, start_datetime DATETIME DEFAULT NULL, finish_datetime DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F6E502438BAC62AF (city_id), UNIQUE INDEX UNIQ_F6E502434D2A7E12 (building_id), UNIQUE INDEX UNIQ_F6E50243DE95C867 (sector_id), UNIQUE INDEX UNIQ_F6E502431BCA4333 (epuipement_id), INDEX IDX_F6E5024317DFEC03 (user_applicant_id), INDEX IDX_F6E50243E6C5D496 (technician_id), INDEX IDX_F6E50243F3D4F2B5 (external_responce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E502438BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E502434D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E502431BCA4333 FOREIGN KEY (epuipement_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E5024317DFEC03 FOREIGN KEY (user_applicant_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243E6C5D496 FOREIGN KEY (technician_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243F3D4F2B5 FOREIGN KEY (external_responce_id) REFERENCES compagny_service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE works');
    }
}
