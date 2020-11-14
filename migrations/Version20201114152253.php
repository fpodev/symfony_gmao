<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114152253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement DROP INDEX UNIQ_B8B4C6F3DE95C867, ADD INDEX IDX_B8B4C6F3DE95C867 (sector_id)');
        $this->addSql('ALTER TABLE equipement CHANGE sector_id sector_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE works DROP INDEX UNIQ_F6E50243DE95C867, ADD INDEX IDX_F6E50243DE95C867 (sector_id)');
        $this->addSql('ALTER TABLE works DROP INDEX UNIQ_F6E502434D2A7E12, ADD INDEX IDX_F6E502434D2A7E12 (building_id)');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E5024317DFEC03');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E502431BCA4333');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243E6C5D496');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243F3D4F2B5');
        $this->addSql('DROP INDEX IDX_F6E5024317DFEC03 ON works');
        $this->addSql('DROP INDEX IDX_F6E50243F3D4F2B5 ON works');
        $this->addSql('DROP INDEX UNIQ_F6E502431BCA4333 ON works');
        $this->addSql('DROP INDEX IDX_F6E50243E6C5D496 ON works');
        $this->addSql('ALTER TABLE works ADD user_id INT NOT NULL, ADD user_technicien_id INT NOT NULL, ADD equipement_id INT NOT NULL, ADD compagny_service_id INT NOT NULL, DROP epuipement_id, DROP user_applicant_id, DROP technician_id, DROP external_responce_id');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243FDCBDF06 FOREIGN KEY (user_technicien_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E502437E8C0DC FOREIGN KEY (compagny_service_id) REFERENCES compagny_service (id)');
        $this->addSql('CREATE INDEX IDX_F6E50243A76ED395 ON works (user_id)');
        $this->addSql('CREATE INDEX IDX_F6E50243FDCBDF06 ON works (user_technicien_id)');
        $this->addSql('CREATE INDEX IDX_F6E50243806F0F5C ON works (equipement_id)');
        $this->addSql('CREATE INDEX IDX_F6E502437E8C0DC ON works (compagny_service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement DROP INDEX IDX_B8B4C6F3DE95C867, ADD UNIQUE INDEX UNIQ_B8B4C6F3DE95C867 (sector_id)');
        $this->addSql('ALTER TABLE equipement CHANGE sector_id sector_id INT NOT NULL');
        $this->addSql('ALTER TABLE works DROP INDEX IDX_F6E502434D2A7E12, ADD UNIQUE INDEX UNIQ_F6E502434D2A7E12 (building_id)');
        $this->addSql('ALTER TABLE works DROP INDEX IDX_F6E50243DE95C867, ADD UNIQUE INDEX UNIQ_F6E50243DE95C867 (sector_id)');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243A76ED395');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243FDCBDF06');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243806F0F5C');
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E502437E8C0DC');
        $this->addSql('DROP INDEX IDX_F6E50243A76ED395 ON works');
        $this->addSql('DROP INDEX IDX_F6E50243FDCBDF06 ON works');
        $this->addSql('DROP INDEX IDX_F6E50243806F0F5C ON works');
        $this->addSql('DROP INDEX IDX_F6E502437E8C0DC ON works');
        $this->addSql('ALTER TABLE works ADD epuipement_id INT NOT NULL, ADD user_applicant_id INT NOT NULL, ADD technician_id INT DEFAULT NULL, ADD external_responce_id INT DEFAULT NULL, DROP user_id, DROP user_technicien_id, DROP equipement_id, DROP compagny_service_id');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E5024317DFEC03 FOREIGN KEY (user_applicant_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E502431BCA4333 FOREIGN KEY (epuipement_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243E6C5D496 FOREIGN KEY (technician_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243F3D4F2B5 FOREIGN KEY (external_responce_id) REFERENCES compagny_service (id)');
        $this->addSql('CREATE INDEX IDX_F6E5024317DFEC03 ON works (user_applicant_id)');
        $this->addSql('CREATE INDEX IDX_F6E50243F3D4F2B5 ON works (external_responce_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6E502431BCA4333 ON works (epuipement_id)');
        $this->addSql('CREATE INDEX IDX_F6E50243E6C5D496 ON works (technician_id)');
    }
}
