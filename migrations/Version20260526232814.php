<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260526232814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recommendation (id INT AUTO_INCREMENT NOT NULL, texte LONGTEXT NOT NULL, from_user_id INT NOT NULL, to_user_id INT NOT NULL, UNIQUE INDEX UNIQ_433224D22130303A (from_user_id), UNIQUE INDEX UNIQ_433224D229F6EE60 (to_user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE recommendation ADD CONSTRAINT FK_433224D22130303A FOREIGN KEY (from_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recommendation ADD CONSTRAINT FK_433224D229F6EE60 FOREIGN KEY (to_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recommendation DROP FOREIGN KEY FK_433224D22130303A');
        $this->addSql('ALTER TABLE recommendation DROP FOREIGN KEY FK_433224D229F6EE60');
        $this->addSql('DROP TABLE recommendation');
    }
}
