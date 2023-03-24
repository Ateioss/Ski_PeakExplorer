<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323215802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station_ski ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE station_ski ADD CONSTRAINT FK_26D775897E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26D775897E3C61F9 ON station_ski (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE station_ski DROP FOREIGN KEY FK_26D775897E3C61F9');
        $this->addSql('DROP INDEX UNIQ_26D775897E3C61F9 ON station_ski');
        $this->addSql('ALTER TABLE station_ski DROP owner_id');
    }
}
