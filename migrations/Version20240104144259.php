<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240104144259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boat CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fishing_notebook CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outlet CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE postal_code postal_code VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boat CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE fishing_notebook CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE outlet CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE booking CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE phone phone INT NOT NULL, CHANGE postal_code postal_code INT NOT NULL');
    }
}
