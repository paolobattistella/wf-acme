<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201226172766 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create tables: `commits`, `work_log`.';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE "commits" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, task_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, text CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_B327C4708DB60186 ON "commits" (task_id)');
        $this->addSql('CREATE INDEX IDX_B327C470A76ED395 ON "commits" (user_id)');
        $this->addSql('CREATE TABLE work_log (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, io VARCHAR(3) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_F5513F59A76ED395 ON work_log (user_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE "commits"');
        $this->addSql('DROP TABLE work_log');
    }
}
