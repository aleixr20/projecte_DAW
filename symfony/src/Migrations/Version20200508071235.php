<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200508071235 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE homepage_sections (id INT AUTO_INCREMENT NOT NULL, titol VARCHAR(255) NOT NULL, subtitol VARCHAR(255) DEFAULT NULL, contingut LONGTEXT NOT NULL, visible TINYINT(1) NOT NULL, menulink VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article CHANGE data_actualitzacio data_actualitzacio DATETIME DEFAULT NULL, CHANGE tag_meta tag_meta LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE tag_web tag_web LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE contingut contingut MEDIUMTEXT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE homepage_sections');
        $this->addSql('ALTER TABLE article CHANGE data_actualitzacio data_actualitzacio DATETIME DEFAULT \'NULL\', CHANGE tag_meta tag_meta LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE tag_web tag_web LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE contingut contingut MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
