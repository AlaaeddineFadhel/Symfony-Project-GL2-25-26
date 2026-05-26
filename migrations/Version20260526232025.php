<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260526232025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, country_id INT DEFAULT NULL, INDEX IDX_2D5B0234F92F3E70 (country_id), UNIQUE INDEX unique_city_country (country_id, name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, city_id INT DEFAULT NULL, INDEX IDX_5373C9668BAC62AF (city_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, UNIQUE INDEX UNIQ_2ED05D9E5E237E06 (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE insatien (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, promo_year INT DEFAULT NULL, parcours_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_4930660AE7927C74 (email), INDEX IDX_4930660A6E38C0DB (parcours_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, entreprise VARCHAR(255) DEFAULT NULL, job_type VARCHAR(255) NOT NULL, job_mode VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, application_link LONGTEXT DEFAULT NULL, company_link LONGTEXT DEFAULT NULL, contact_email VARCHAR(150) NOT NULL, requirements LONGTEXT DEFAULT NULL, responsibilities LONGTEXT DEFAULT NULL, salary_min NUMERIC(10, 2) DEFAULT NULL, salary_max NUMERIC(10, 2) DEFAULT NULL, currency CHAR(3) DEFAULT \'TND\' NOT NULL, req_experience INT DEFAULT NULL, date_publication DATETIME DEFAULT CURRENT_TIMESTAMP, deadline DATETIME DEFAULT NULL, country_id INT DEFAULT NULL, city_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_FBD8E0F8CAB86C7B (contact_email), INDEX IDX_FBD8E0F8F92F3E70 (country_id), INDEX IDX_FBD8E0F88BAC62AF (city_id), INDEX IDX_FBD8E0F8B03A8386 (created_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE parcours (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, filiere_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_99B1DEE35E237E06 (name), INDEX IDX_99B1DEE3180AA129 (filiere_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(150) NOT NULL, password_hash VARCHAR(255) NOT NULL, profile_link LONGTEXT DEFAULT NULL, github_link LONGTEXT DEFAULT NULL, linkedin_link LONGTEXT DEFAULT NULL, tagline VARCHAR(255) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, avatar_url LONGTEXT DEFAULT NULL, updated_at DATETIME NOT NULL, insatien_id INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6497EA8BC22 (insatien_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C9668BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE insatien ADD CONSTRAINT FK_4930660A6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcours (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F88BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE parcours ADD CONSTRAINT FK_99B1DEE3180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497EA8BC22 FOREIGN KEY (insatien_id) REFERENCES insatien (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C9668BAC62AF');
        $this->addSql('ALTER TABLE insatien DROP FOREIGN KEY FK_4930660A6E38C0DB');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8F92F3E70');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F88BAC62AF');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8B03A8386');
        $this->addSql('ALTER TABLE parcours DROP FOREIGN KEY FK_99B1DEE3180AA129');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497EA8BC22');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE insatien');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE parcours');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
