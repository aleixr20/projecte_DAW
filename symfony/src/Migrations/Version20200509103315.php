<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200509103315 extends AbstractMigration
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
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(40) NOT NULL, ADD cognom VARCHAR(40) NOT NULL, ADD data_naixament DATE DEFAULT NULL, ADD genere VARCHAR(40) DEFAULT NULL, ADD codi_postal VARCHAR(12) DEFAULT NULL, ADD nom_usuari VARCHAR(40) NOT NULL, ADD imatge VARCHAR(200) DEFAULT NULL, ADD ultim_login DATETIME DEFAULT NULL, ADD data_registre DATETIME NOT NULL, CHANGE email email VARCHAR(200) NOT NULL, CHANGE roles roles VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE data_actualitzacio data_actualitzacio DATETIME DEFAULT \'NULL\', CHANGE tag_meta tag_meta LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE tag_web tag_web LONGTEXT CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE contingut contingut MEDIUMTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE homepage_sections CHANGE subtitol subtitol VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP nom, DROP cognom, DROP data_naixament, DROP genere, DROP codi_postal, DROP nom_usuari, DROP imatge, DROP ultim_login, DROP data_registre, CHANGE email email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
