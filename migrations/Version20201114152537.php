<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201114152537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243A76ED395');
        $this->addSql('DROP INDEX IDX_F6E50243A76ED395 ON works');
        $this->addSql('ALTER TABLE works CHANGE user_id user_request_id INT NOT NULL');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243E5197E49 FOREIGN KEY (user_request_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_F6E50243E5197E49 ON works (user_request_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE works DROP FOREIGN KEY FK_F6E50243E5197E49');
        $this->addSql('DROP INDEX IDX_F6E50243E5197E49 ON works');
        $this->addSql('ALTER TABLE works CHANGE user_request_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE works ADD CONSTRAINT FK_F6E50243A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_F6E50243A76ED395 ON works (user_id)');
    }
}
