<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190324041329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_8D93D649AA08CB10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, role_id, room_id, login, password, token, money, rang FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER NOT NULL, room_id INTEGER NOT NULL, login VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, token VARCHAR(255) DEFAULT NULL COLLATE BINARY, money INTEGER DEFAULT NULL, rang INTEGER NOT NULL)');
        $this->addSql('INSERT INTO user (id, role_id, room_id, login, password, token, money, rang) SELECT id, role_id, room_id, login, password, token, money, rang FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON user (login)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_8D93D649AA08CB10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, role_id, room_id, login, password, token, money, rang FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER NOT NULL, room_id INTEGER NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, money INTEGER DEFAULT NULL, rang INTEGER DEFAULT 0 NOT NULL)');
        $this->addSql('INSERT INTO user (id, role_id, room_id, login, password, token, money, rang) SELECT id, role_id, room_id, login, password, token, money, rang FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON user (login)');
    }
}
