<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114145712 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sector DROP INDEX UNIQ_4BA3D9E84D2A7E12, ADD INDEX IDX_4BA3D9E84D2A7E12 (building_id)');
        $this->addSql('ALTER TABLE sector CHANGE building_id building_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sector DROP INDEX IDX_4BA3D9E84D2A7E12, ADD UNIQUE INDEX UNIQ_4BA3D9E84D2A7E12 (building_id)');
        $this->addSql('ALTER TABLE sector CHANGE building_id building_id INT NOT NULL');
    }
}
