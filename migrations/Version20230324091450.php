<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324091450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE defis_piste ADD CONSTRAINT FK_E3010F224208F841 FOREIGN KEY (defis_id) REFERENCES defis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE defis_piste ADD CONSTRAINT FK_E3010F22C34065BC FOREIGN KEY (piste_id) REFERENCES piste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD defis_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494208F841 FOREIGN KEY (defis_id) REFERENCES defis (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494208F841 ON user (defis_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE defis_piste DROP FOREIGN KEY FK_E3010F224208F841');
        $this->addSql('ALTER TABLE defis_piste DROP FOREIGN KEY FK_E3010F22C34065BC');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494208F841');
        $this->addSql('DROP INDEX IDX_8D93D6494208F841 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP defis_id');
    }
}
