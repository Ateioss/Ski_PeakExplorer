<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD
<<<<<<<< HEAD:migrations/Version20230322091252.php
final class Version20230322091252 extends AbstractMigration
========
final class Version20230322085751 extends AbstractMigration
>>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006:migrations/Version20230322085751.php
=======
final class Version20230322091252 extends AbstractMigration
>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD
<<<<<<<< HEAD:migrations/Version20230322091252.php
        $this->addSql('ALTER TABLE piste ADD horaire_ouverture TIME NOT NULL, ADD horaire_fermeture TIME NOT NULL');
========
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
>>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006:migrations/Version20230322085751.php
=======
        $this->addSql('CREATE TABLE remontée (id INT AUTO_INCREMENT NOT NULL, station_id INT NOT NULL, nom VARCHAR(255) NOT NULL, ouverture TINYINT(1) NOT NULL, horaire_ouverture TIME NOT NULL, horaire_fermeture TIME NOT NULL, INDEX IDX_A03F850121BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE remontée ADD CONSTRAINT FK_A03F850121BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD
<<<<<<<< HEAD:migrations/Version20230322091252.php
        $this->addSql('ALTER TABLE piste DROP horaire_ouverture, DROP horaire_fermeture');
========
        $this->addSql('DROP TABLE station');
>>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006:migrations/Version20230322085751.php
=======
        $this->addSql('ALTER TABLE remontée DROP FOREIGN KEY FK_A03F850121BDB235');
        $this->addSql('DROP TABLE remontée');
>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006
    }
}
