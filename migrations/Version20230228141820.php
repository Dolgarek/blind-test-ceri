<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228141820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accord_rgpd (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, nom VARCHAR(255) NOT NULL, fichier VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_17B7F540B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accord_utilisateur (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, accord_rgpd_id INT NOT NULL, UNIQUE INDEX UNIQ_B4FDD27FFB88E14F (utilisateur_id), UNIQUE INDEX UNIQ_B4FDD27F2A157B30 (accord_rgpd_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE connexion (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, connexion DATETIME NOT NULL, UNIQUE INDEX UNIQ_936BF99CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musique (id INT AUTO_INCREMENT NOT NULL, musique_info_id INT NOT NULL, is_global TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_EE1D56BCC033571B (musique_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musique_partie (musique_id INT NOT NULL, partie_id INT NOT NULL, INDEX IDX_6F7A53B825E254A1 (musique_id), INDEX IDX_6F7A53B8E075F7A4 (partie_id), PRIMARY KEY(musique_id, partie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musique_importe (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, musique_info_id INT NOT NULL, date_importation DATETIME NOT NULL, INDEX IDX_11F9CEAEFB88E14F (utilisateur_id), UNIQUE INDEX UNIQ_11F9CEAEC033571B (musique_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE musique_info (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, artiste VARCHAR(255) DEFAULT NULL, album VARCHAR(255) DEFAULT NULL, groupe VARCHAR(255) DEFAULT NULL, date_de_sortie DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partie (id INT AUTO_INCREMENT NOT NULL, nombre_de_musique INT NOT NULL, niveau_de_difficulte VARCHAR(255) NOT NULL, score INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partie_utilisateur (partie_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_87F5E0FBE075F7A4 (partie_id), INDEX IDX_87F5E0FBFB88E14F (utilisateur_id), PRIMARY KEY(partie_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_musique_info (theme_id INT NOT NULL, musique_info_id INT NOT NULL, INDEX IDX_E9A92CE459027487 (theme_id), INDEX IDX_E9A92CE4C033571B (musique_info_id), PRIMARY KEY(theme_id, musique_info_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accord_rgpd ADD CONSTRAINT FK_17B7F540B03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE accord_utilisateur ADD CONSTRAINT FK_B4FDD27FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE accord_utilisateur ADD CONSTRAINT FK_B4FDD27F2A157B30 FOREIGN KEY (accord_rgpd_id) REFERENCES accord_rgpd (id)');
        $this->addSql('ALTER TABLE connexion ADD CONSTRAINT FK_936BF99CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE musique ADD CONSTRAINT FK_EE1D56BCC033571B FOREIGN KEY (musique_info_id) REFERENCES musique_info (id)');
        $this->addSql('ALTER TABLE musique_partie ADD CONSTRAINT FK_6F7A53B825E254A1 FOREIGN KEY (musique_id) REFERENCES musique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE musique_partie ADD CONSTRAINT FK_6F7A53B8E075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE musique_importe ADD CONSTRAINT FK_11F9CEAEFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE musique_importe ADD CONSTRAINT FK_11F9CEAEC033571B FOREIGN KEY (musique_info_id) REFERENCES musique_info (id)');
        $this->addSql('ALTER TABLE partie_utilisateur ADD CONSTRAINT FK_87F5E0FBE075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partie_utilisateur ADD CONSTRAINT FK_87F5E0FBFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_musique_info ADD CONSTRAINT FK_E9A92CE459027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_musique_info ADD CONSTRAINT FK_E9A92CE4C033571B FOREIGN KEY (musique_info_id) REFERENCES musique_info (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accord_rgpd DROP FOREIGN KEY FK_17B7F540B03A8386');
        $this->addSql('ALTER TABLE accord_utilisateur DROP FOREIGN KEY FK_B4FDD27FFB88E14F');
        $this->addSql('ALTER TABLE accord_utilisateur DROP FOREIGN KEY FK_B4FDD27F2A157B30');
        $this->addSql('ALTER TABLE connexion DROP FOREIGN KEY FK_936BF99CFB88E14F');
        $this->addSql('ALTER TABLE musique DROP FOREIGN KEY FK_EE1D56BCC033571B');
        $this->addSql('ALTER TABLE musique_partie DROP FOREIGN KEY FK_6F7A53B825E254A1');
        $this->addSql('ALTER TABLE musique_partie DROP FOREIGN KEY FK_6F7A53B8E075F7A4');
        $this->addSql('ALTER TABLE musique_importe DROP FOREIGN KEY FK_11F9CEAEFB88E14F');
        $this->addSql('ALTER TABLE musique_importe DROP FOREIGN KEY FK_11F9CEAEC033571B');
        $this->addSql('ALTER TABLE partie_utilisateur DROP FOREIGN KEY FK_87F5E0FBE075F7A4');
        $this->addSql('ALTER TABLE partie_utilisateur DROP FOREIGN KEY FK_87F5E0FBFB88E14F');
        $this->addSql('ALTER TABLE theme_musique_info DROP FOREIGN KEY FK_E9A92CE459027487');
        $this->addSql('ALTER TABLE theme_musique_info DROP FOREIGN KEY FK_E9A92CE4C033571B');
        $this->addSql('DROP TABLE accord_rgpd');
        $this->addSql('DROP TABLE accord_utilisateur');
        $this->addSql('DROP TABLE connexion');
        $this->addSql('DROP TABLE musique');
        $this->addSql('DROP TABLE musique_partie');
        $this->addSql('DROP TABLE musique_importe');
        $this->addSql('DROP TABLE musique_info');
        $this->addSql('DROP TABLE partie');
        $this->addSql('DROP TABLE partie_utilisateur');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_musique_info');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
