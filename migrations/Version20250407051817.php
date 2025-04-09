<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407051817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE domaine (id INT AUTO_INCREMENT NOT NULL, nom_domaine VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cv ADD domaine_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE924272FC9F FOREIGN KEY (domaine_id) REFERENCES domaine (id)');
        $this->addSql('CREATE INDEX IDX_B66FFE924272FC9F ON cv (domaine_id)');
        $this->addSql('ALTER TABLE project CHANGE description description VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE924272FC9F');
        $this->addSql('DROP TABLE domaine');
        $this->addSql('DROP INDEX IDX_B66FFE924272FC9F ON cv');
        $this->addSql('ALTER TABLE cv DROP domaine_id, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE project CHANGE description description LONGTEXT NOT NULL');
    }
}
