<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220807155046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bird_image (bird_id INT NOT NULL, image_id INT NOT NULL, PRIMARY KEY(bird_id, image_id))');
        $this->addSql('CREATE INDEX IDX_A9133CBFE813F9 ON bird_image (bird_id)');
        $this->addSql('CREATE INDEX IDX_A9133CBF3DA5256D ON bird_image (image_id)');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, filename VARCHAR(255) NOT NULL, alt TEXT NOT NULL, attribution TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE bird_image ADD CONSTRAINT FK_A9133CBFE813F9 FOREIGN KEY (bird_id) REFERENCES bird (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bird_image ADD CONSTRAINT FK_A9133CBF3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bird ADD description TEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE bird_image DROP CONSTRAINT FK_A9133CBF3DA5256D');
        $this->addSql('DROP SEQUENCE image_id_seq CASCADE');
        $this->addSql('DROP TABLE bird_image');
        $this->addSql('DROP TABLE image');
        $this->addSql('ALTER TABLE bird DROP description');
    }
}
