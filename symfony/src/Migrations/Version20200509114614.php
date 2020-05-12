<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200509114614 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE data_actualitzacio data_actualitzacio DATETIME DEFAULT NULL, CHANGE tag_meta tag_meta LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE tag_web tag_web LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE contingut contingut MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE homepage_sections CHANGE subtitol subtitol VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE data_naixament data_naixament DATE DEFAULT NULL, CHANGE genere genere VARCHAR(40) DEFAULT NULL, CHANGE codi_postal codi_postal VARCHAR(12) DEFAULT NULL, CHANGE imatge imatge VARCHAR(200) DEFAULT NULL, CHANGE ultim_login ultim_login DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE data_actualitzacio data_actualitzacio DATETIME DEFAULT \'NULL\', CHANGE tag_meta tag_meta LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE tag_web tag_web LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE contingut contingut MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE homepage_sections CHANGE subtitol subtitol VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE data_naixament data_naixament DATE DEFAULT \'NULL\', CHANGE genere genere VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE codi_postal codi_postal VARCHAR(12) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE imatge imatge VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE ultim_login ultim_login DATETIME DEFAULT \'NULL\'');
    }
}
