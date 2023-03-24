<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324082213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piste ADD block TINYINT(1) NOT NULL, CHANGE difficulté difficulte VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE piste ADD CONSTRAINT FK_59E2507721BDB235 FOREIGN KEY (station_id) REFERENCES station_ski (id)');
        $this->addSql('ALTER TABLE remontee ADD block TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE remontee ADD CONSTRAINT FK_50829C5721BDB235 FOREIGN KEY (station_id) REFERENCES station_ski (id)');
        $this->addSql('ALTER TABLE station_ski ADD domain_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE station_ski ADD CONSTRAINT FK_26D77589115F0EE5 FOREIGN KEY (domain_id) REFERENCES gdomaine (id)');
        $this->addSql('CREATE INDEX IDX_26D77589115F0EE5 ON station_ski (domain_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piste DROP FOREIGN KEY FK_59E2507721BDB235');
        $this->addSql('ALTER TABLE piste DROP block, CHANGE difficulte difficulté VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE remontee DROP FOREIGN KEY FK_50829C5721BDB235');
        $this->addSql('ALTER TABLE remontee DROP block');
        $this->addSql('ALTER TABLE station_ski DROP FOREIGN KEY FK_26D77589115F0EE5');
        $this->addSql('DROP INDEX IDX_26D77589115F0EE5 ON station_ski');
        $this->addSql('ALTER TABLE station_ski DROP domain_id');
    }
}
