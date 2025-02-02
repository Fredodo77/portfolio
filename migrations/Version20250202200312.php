<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202200312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technologies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologies_project (technologies_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_74F02E118F8A14FA (technologies_id), INDEX IDX_74F02E11166D1F9C (project_id), PRIMARY KEY(technologies_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE technologies_project ADD CONSTRAINT FK_74F02E118F8A14FA FOREIGN KEY (technologies_id) REFERENCES technologies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technologies_project ADD CONSTRAINT FK_74F02E11166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technologies_project DROP FOREIGN KEY FK_74F02E118F8A14FA');
        $this->addSql('ALTER TABLE technologies_project DROP FOREIGN KEY FK_74F02E11166D1F9C');
        $this->addSql('DROP TABLE technologies');
        $this->addSql('DROP TABLE technologies_project');
    }
}
