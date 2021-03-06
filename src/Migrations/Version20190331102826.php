<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190331102826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE way (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_form INTEGER NOT NULL, id_to INTEGER NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, name, description, money, world_type FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description VARCHAR(255) DEFAULT NULL COLLATE BINARY, money INTEGER DEFAULT NULL, world_type INTEGER NOT NULL)');
        $this->addSql('INSERT INTO room (id, name, description, money, world_type) SELECT id, name, description, money, world_type FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE way');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, name, description, money, world_type FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, money INTEGER DEFAULT NULL, world_type BLOB NOT NULL)');
        $this->addSql('INSERT INTO room (id, name, description, money, world_type) SELECT id, name, description, money, world_type FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
    }
}