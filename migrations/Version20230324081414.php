<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324081414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE defis (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, difficulte VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, echeance VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, recompense VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE defis_piste (defis_id INT NOT NULL, piste_id INT NOT NULL, INDEX IDX_E3010F224208F841 (defis_id), INDEX IDX_E3010F22C34065BC (piste_id), PRIMARY KEY(defis_id, piste_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piste (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, difficulté VARCHAR(255) NOT NULL, ouverture TINYINT(1) NOT NULL, horaire_ouverture TIME NOT NULL, horaire_fermeture TIME NOT NULL, INDEX IDX_59E2507721BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remontee (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, open TINYINT(1) NOT NULL, open_time TIME NOT NULL, close_time TIME NOT NULL, INDEX IDX_50829C5721BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, defis_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6494208F841 (defis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE defis_piste ADD CONSTRAINT FK_E3010F224208F841 FOREIGN KEY (defis_id) REFERENCES defis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE defis_piste ADD CONSTRAINT FK_E3010F22C34065BC FOREIGN KEY (piste_id) REFERENCES piste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE piste ADD CONSTRAINT FK_59E2507721BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE remontee ADD CONSTRAINT FK_50829C5721BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6494208F841 FOREIGN KEY (defis_id) REFERENCES defis (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE defis_piste DROP FOREIGN KEY FK_E3010F224208F841');
        $this->addSql('ALTER TABLE defis_piste DROP FOREIGN KEY FK_E3010F22C34065BC');
        $this->addSql('ALTER TABLE piste DROP FOREIGN KEY FK_59E2507721BDB235');
        $this->addSql('ALTER TABLE remontee DROP FOREIGN KEY FK_50829C5721BDB235');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494208F841');
        $this->addSql('DROP TABLE defis');
        $this->addSql('DROP TABLE defis_piste');
        $this->addSql('DROP TABLE piste');
        $this->addSql('DROP TABLE remontee');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
