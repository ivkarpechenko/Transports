<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628085249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company ADD volume_cost INT NOT NULL');
        $this->addSql('ALTER TABLE company ADD weight_cost INT NOT NULL');
        $this->addSql('ALTER TABLE company DROP max_volume');
        $this->addSql('ALTER TABLE company DROP max_weight');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company ADD max_volume INT NOT NULL');
        $this->addSql('ALTER TABLE company ADD max_weight INT NOT NULL');
        $this->addSql('ALTER TABLE company DROP volume_cost');
        $this->addSql('ALTER TABLE company DROP weight_cost');
    }
}
