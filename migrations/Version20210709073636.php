<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210709073636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_454D9673C7440455');
        $this->addSql('CREATE TEMPORARY TABLE __temp__oauth2_access_token AS SELECT identifier, client, expiry, user_identifier, scopes, revoked FROM oauth2_access_token');
        $this->addSql('DROP TABLE oauth2_access_token');
        $this->addSql('CREATE TABLE oauth2_access_token (identifier CHAR(80) NOT NULL COLLATE BINARY, client VARCHAR(32) NOT NULL COLLATE BINARY, expiry DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , user_identifier VARCHAR(128) DEFAULT NULL COLLATE BINARY, scopes CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:oauth2_scope)
        , revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier), CONSTRAINT FK_454D9673C7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO oauth2_access_token (identifier, client, expiry, user_identifier, scopes, revoked) SELECT identifier, client, expiry, user_identifier, scopes, revoked FROM __temp__oauth2_access_token');
        $this->addSql('DROP TABLE __temp__oauth2_access_token');
        $this->addSql('CREATE INDEX IDX_454D9673C7440455 ON oauth2_access_token (client)');
        $this->addSql('DROP INDEX IDX_509FEF5FC7440455');
        $this->addSql('CREATE TEMPORARY TABLE __temp__oauth2_authorization_code AS SELECT identifier, client, expiry, user_identifier, scopes, revoked FROM oauth2_authorization_code');
        $this->addSql('DROP TABLE oauth2_authorization_code');
        $this->addSql('CREATE TABLE oauth2_authorization_code (identifier CHAR(80) NOT NULL COLLATE BINARY, client VARCHAR(32) NOT NULL COLLATE BINARY, expiry DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , user_identifier VARCHAR(128) DEFAULT NULL COLLATE BINARY, scopes CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:oauth2_scope)
        , revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier), CONSTRAINT FK_509FEF5FC7440455 FOREIGN KEY (client) REFERENCES oauth2_client (identifier) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO oauth2_authorization_code (identifier, client, expiry, user_identifier, scopes, revoked) SELECT identifier, client, expiry, user_identifier, scopes, revoked FROM __temp__oauth2_authorization_code');
        $this->addSql('DROP TABLE __temp__oauth2_authorization_code');
        $this->addSql('CREATE INDEX IDX_509FEF5FC7440455 ON oauth2_authorization_code (client)');
        $this->addSql('DROP INDEX IDX_4DD90732B6A2DD68');
        $this->addSql('CREATE TEMPORARY TABLE __temp__oauth2_refresh_token AS SELECT identifier, access_token, expiry, revoked FROM oauth2_refresh_token');
        $this->addSql('DROP TABLE oauth2_refresh_token');
        $this->addSql('CREATE TABLE oauth2_refresh_token (identifier CHAR(80) NOT NULL COLLATE BINARY, access_token CHAR(80) DEFAULT NULL COLLATE BINARY, expiry DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier), CONSTRAINT FK_4DD90732B6A2DD68 FOREIGN KEY (access_token) REFERENCES oauth2_access_token (identifier) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO oauth2_refresh_token (identifier, access_token, expiry, revoked) SELECT identifier, access_token, expiry, revoked FROM __temp__oauth2_refresh_token');
        $this->addSql('DROP TABLE __temp__oauth2_refresh_token');
        $this->addSql('CREATE INDEX IDX_4DD90732B6A2DD68 ON oauth2_refresh_token (access_token)');
        $this->addSql('ALTER TABLE user ADD COLUMN is_verified BOOLEAN NOT NULL DEFAULT FALSE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_454D9673C7440455');
        $this->addSql('CREATE TEMPORARY TABLE __temp__oauth2_access_token AS SELECT identifier, client, expiry, user_identifier, scopes, revoked FROM oauth2_access_token');
        $this->addSql('DROP TABLE oauth2_access_token');
        $this->addSql('CREATE TABLE oauth2_access_token (identifier CHAR(80) NOT NULL, client VARCHAR(32) NOT NULL, expiry DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , user_identifier VARCHAR(128) DEFAULT NULL, scopes CLOB DEFAULT NULL --(DC2Type:oauth2_scope)
        , revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('INSERT INTO oauth2_access_token (identifier, client, expiry, user_identifier, scopes, revoked) SELECT identifier, client, expiry, user_identifier, scopes, revoked FROM __temp__oauth2_access_token');
        $this->addSql('DROP TABLE __temp__oauth2_access_token');
        $this->addSql('CREATE INDEX IDX_454D9673C7440455 ON oauth2_access_token (client)');
        $this->addSql('DROP INDEX IDX_509FEF5FC7440455');
        $this->addSql('CREATE TEMPORARY TABLE __temp__oauth2_authorization_code AS SELECT identifier, client, expiry, user_identifier, scopes, revoked FROM oauth2_authorization_code');
        $this->addSql('DROP TABLE oauth2_authorization_code');
        $this->addSql('CREATE TABLE oauth2_authorization_code (identifier CHAR(80) NOT NULL, client VARCHAR(32) NOT NULL, expiry DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , user_identifier VARCHAR(128) DEFAULT NULL, scopes CLOB DEFAULT NULL --(DC2Type:oauth2_scope)
        , revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('INSERT INTO oauth2_authorization_code (identifier, client, expiry, user_identifier, scopes, revoked) SELECT identifier, client, expiry, user_identifier, scopes, revoked FROM __temp__oauth2_authorization_code');
        $this->addSql('DROP TABLE __temp__oauth2_authorization_code');
        $this->addSql('CREATE INDEX IDX_509FEF5FC7440455 ON oauth2_authorization_code (client)');
        $this->addSql('DROP INDEX IDX_4DD90732B6A2DD68');
        $this->addSql('CREATE TEMPORARY TABLE __temp__oauth2_refresh_token AS SELECT identifier, access_token, expiry, revoked FROM oauth2_refresh_token');
        $this->addSql('DROP TABLE oauth2_refresh_token');
        $this->addSql('CREATE TABLE oauth2_refresh_token (identifier CHAR(80) NOT NULL, access_token CHAR(80) DEFAULT NULL, expiry DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , revoked BOOLEAN NOT NULL, PRIMARY KEY(identifier))');
        $this->addSql('INSERT INTO oauth2_refresh_token (identifier, access_token, expiry, revoked) SELECT identifier, access_token, expiry, revoked FROM __temp__oauth2_refresh_token');
        $this->addSql('DROP TABLE __temp__oauth2_refresh_token');
        $this->addSql('CREATE INDEX IDX_4DD90732B6A2DD68 ON oauth2_refresh_token (access_token)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, first_name, password FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , first_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, first_name, password) SELECT id, email, roles, first_name, password FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
