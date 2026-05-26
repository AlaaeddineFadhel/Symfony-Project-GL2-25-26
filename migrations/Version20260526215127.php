<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260526215127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE insatien (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, promo_year INT DEFAULT NULL, parcours_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_4930660AE7927C74 (email), INDEX IDX_4930660A6E38C0DB (parcours_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE insatien ADD CONSTRAINT FK_4930660A6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE insatien DROP FOREIGN KEY FK_4930660A6E38C0DB');
        $this->addSql('DROP TABLE insatien');
    }
}
