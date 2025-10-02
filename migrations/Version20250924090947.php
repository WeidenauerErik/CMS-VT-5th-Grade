<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250924090947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movie (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quote (id SERIAL NOT NULL, movie_relation_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, msg VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6B71CBF41DD01DAC ON quote (movie_relation_id)');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF41DD01DAC FOREIGN KEY (movie_relation_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE quote DROP CONSTRAINT FK_6B71CBF41DD01DAC');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE quote');
    }
}
