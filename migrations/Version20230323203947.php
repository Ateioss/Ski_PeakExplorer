<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20230323121141.php
final class Version20230323121141 extends AbstractMigration
========
final class Version20230323203947 extends AbstractMigration
>>>>>>>> d1a87ab2f30c109636a640d73324dd12fc804c9e:migrations/Version20230323203947.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230323121141.php
        $this->addSql('ALTER TABLE piste ADD fermeture_expectionelle VARCHAR(255) DEFAULT NULL, CHANGE difficulte difficulte VARCHAR(255) NOT NULL');
========
        $this->addSql('ALTER TABLE station_ski ADD image VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL');
>>>>>>>> d1a87ab2f30c109636a640d73324dd12fc804c9e:migrations/Version20230323203947.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230323121141.php
        $this->addSql('ALTER TABLE piste DROP fermeture_expectionelle, CHANGE difficulte difficulte VARCHAR(255) DEFAULT NULL');
========
        $this->addSql('ALTER TABLE station_ski DROP image, DROP description');
>>>>>>>> d1a87ab2f30c109636a640d73324dd12fc804c9e:migrations/Version20230323203947.php
    }
}
