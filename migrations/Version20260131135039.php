<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260131135039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, patient_code BINARY(16) NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(50) DEFAULT NULL, sex VARCHAR(1) NOT NULL, birth_date DATE DEFAULT NULL, contact_no VARCHAR(13) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE user ADD user_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499D419299 FOREIGN KEY (user_type_id) REFERENCES patient (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6499D419299 ON user (user_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE patient');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499D419299');
        $this->addSql('DROP INDEX UNIQ_8D93D6499D419299 ON user');
        $this->addSql('ALTER TABLE user DROP user_type_id');
    }
}
