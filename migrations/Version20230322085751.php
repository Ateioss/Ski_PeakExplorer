<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20230322091252.php
final class Version20230322091252 extends AbstractMigration
========
final class Version20230322085751 extends AbstractMigration
>>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006:migrations/Version20230322085751.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230322091252.php
        $this->addSql('ALTER TABLE piste ADD horaire_ouverture TIME NOT NULL, ADD horaire_fermeture TIME NOT NULL');
========
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
>>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006:migrations/Version20230322085751.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230322091252.php
        $this->addSql('ALTER TABLE piste DROP horaire_ouverture, DROP horaire_fermeture');
========
        $this->addSql('DROP TABLE station');
>>>>>>>> e4dceca349dee6fa0e42f775a1a98c5b12f6a006:migrations/Version20230322085751.php
    }
}
