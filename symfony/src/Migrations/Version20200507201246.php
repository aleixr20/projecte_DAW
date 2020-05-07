<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200507201246 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tema_id INT NOT NULL, titol VARCHAR(255) NOT NULL, subtitol VARCHAR(255) NOT NULL, data_publicacio DATETIME NOT NULL, data_actualitzacio DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, tag_meta LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', tag_web LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', contingut MEDIUMTEXT NOT NULL, INDEX IDX_23A0E66A76ED395 (user_id), INDEX IDX_23A0E66A64A8A17 (tema_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comentari (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, article_id INT NOT NULL, titol VARCHAR(255) NOT NULL, text VARCHAR(1000) NOT NULL, INDEX IDX_9A59356CA76ED395 (user_id), INDEX IDX_9A59356C7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE homepage_sections (id INT AUTO_INCREMENT NOT NULL, titol VARCHAR(255) NOT NULL, subtitol VARCHAR(255) DEFAULT NULL, contingut LONGTEXT NOT NULL, visible TINYINT(1) NOT NULL, menulink VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tema (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A64A8A17 FOREIGN KEY (tema_id) REFERENCES tema (id)');
        $this->addSql('ALTER TABLE comentari ADD CONSTRAINT FK_9A59356CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comentari ADD CONSTRAINT FK_9A59356C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comentari DROP FOREIGN KEY FK_9A59356C7294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A64A8A17');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE comentari DROP FOREIGN KEY FK_9A59356CA76ED395');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comentari');
        $this->addSql('DROP TABLE homepage_sections');
        $this->addSql('DROP TABLE tema');
        $this->addSql('DROP TABLE user');
    }
}
