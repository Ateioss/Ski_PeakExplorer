<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326085825 extends AbstractMigration
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
        $this->addSql('ALTER TABLE defis_piste ADD CONSTRAINT FK_E3010F224208F841 FOREIGN KEY (defis_id) REFERENCES defis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE defis_piste ADD CONSTRAINT FK_E3010F22C34065BC FOREIGN KEY (piste_id) REFERENCES piste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE piste ADD fermeture_expectionelle VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD defis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494208F841 FOREIGN KEY (defis_id) REFERENCES defis (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494208F841 ON user (defis_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494208F841');
        $this->addSql('ALTER TABLE defis_piste DROP FOREIGN KEY FK_E3010F224208F841');
        $this->addSql('ALTER TABLE defis_piste DROP FOREIGN KEY FK_E3010F22C34065BC');
        $this->addSql('DROP TABLE defis');
        $this->addSql('DROP TABLE defis_piste');
        $this->addSql('ALTER TABLE piste DROP fermeture_expectionelle');
        $this->addSql('DROP INDEX IDX_8D93D6494208F841 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP defis_id');
    }
}
