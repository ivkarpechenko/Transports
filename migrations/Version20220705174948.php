<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705174948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE logistics_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE logistics_history (id INT NOT NULL, logistics_id INT NOT NULL, status VARCHAR(255) NOT NULL, created_at VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE logistics DROP parent');
        $this->addSql('ALTER TABLE logistics ALTER status SET DEFAULT \'Created\'');
        $this->addSql('ALTER TABLE logistics ALTER created_at TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE logistics ALTER created_at DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE logistics_history_id_seq CASCADE');
        $this->addSql('DROP TABLE logistics_history');
        $this->addSql('ALTER TABLE logistics ADD parent INT DEFAULT NULL');
        $this->addSql('ALTER TABLE logistics ALTER status SET DEFAULT \'Создан\'');
        $this->addSql('ALTER TABLE logistics ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE logistics ALTER created_at DROP DEFAULT');
    }
}
