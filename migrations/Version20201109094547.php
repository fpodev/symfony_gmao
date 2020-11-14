<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201109094547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE building ADD CONSTRAINT FK_E16F61D4A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_E16F61D4A73F0036 ON building (ville_id)');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C34D2A7E12');
        $this->addSql('DROP INDEX IDX_43C3D9C34D2A7E12 ON ville');
        $this->addSql('ALTER TABLE ville DROP building_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE building DROP FOREIGN KEY FK_E16F61D4A73F0036');
        $this->addSql('DROP INDEX IDX_E16F61D4A73F0036 ON building');
        $this->addSql('ALTER TABLE building DROP ville_id');
        $this->addSql('ALTER TABLE ville ADD building_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C34D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id)');
        $this->addSql('CREATE INDEX IDX_43C3D9C34D2A7E12 ON ville (building_id)');
    }
}
