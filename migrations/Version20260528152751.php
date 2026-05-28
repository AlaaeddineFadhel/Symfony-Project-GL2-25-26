<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260528152751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE insatien ADD filiere_id INT NOT NULL');
        $this->addSql('ALTER TABLE insatien ADD CONSTRAINT FK_4930660A180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('CREATE INDEX IDX_4930660A180AA129 ON insatien (filiere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE insatien DROP FOREIGN KEY FK_4930660A180AA129');
        $this->addSql('DROP INDEX IDX_4930660A180AA129 ON insatien');
        $this->addSql('ALTER TABLE insatien DROP filiere_id');
    }
}
