<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210706071137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE observe ADD COLUMN id_user INTEGER NOT NULL');
        $this->addSql('ALTER TABLE observe ADD COLUMN id_hash INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__observe AS SELECT id FROM observe');
        $this->addSql('DROP TABLE observe');
        $this->addSql('CREATE TABLE observe (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO observe (id) SELECT id FROM __temp__observe');
        $this->addSql('DROP TABLE __temp__observe');
    }
}
