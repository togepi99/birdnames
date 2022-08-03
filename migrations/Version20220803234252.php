<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220803234252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bird ADD old_name_slugged VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE bird ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE bird ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE bird ADD created_by VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bird ADD updated_by VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE bird_name ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE bird_name ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE vote ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE vote ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE bird DROP old_name_slugged');
        $this->addSql('ALTER TABLE bird DROP created_at');
        $this->addSql('ALTER TABLE bird DROP updated_at');
        $this->addSql('ALTER TABLE bird DROP created_by');
        $this->addSql('ALTER TABLE bird DROP updated_by');
        $this->addSql('ALTER TABLE bird_name DROP created_at');
        $this->addSql('ALTER TABLE bird_name DROP updated_at');
        $this->addSql('ALTER TABLE vote DROP created_at');
        $this->addSql('ALTER TABLE vote DROP updated_at');
    }
}
