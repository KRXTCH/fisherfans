<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111145202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, year_of_manufacture VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, license_type INT NOT NULL, type INT NOT NULL, equipment LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', deposit_amount INT NOT NULL, maximum_capacity INT NOT NULL, number_of_beds INT NOT NULL, port_city_origin VARCHAR(255) NOT NULL, origin VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, motorization_type INT NOT NULL, INDEX IDX_D86E834AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date DATE NOT NULL, booked_places INT NOT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fishing_notebook (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, fish_name VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, comment VARCHAR(255) NOT NULL, size DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, location VARCHAR(255) NOT NULL, date DATE NOT NULL, is_released TINYINT(1) NOT NULL, INDEX IDX_CA0F5D5CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outlet (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, informations VARCHAR(255) NOT NULL, type INT NOT NULL, amount_type INT NOT NULL, start_day_dates LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', end_day_dates LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', start_hour_dates LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', end_hour_dates LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', capacity INT NOT NULL, price INT NOT NULL, INDEX IDX_93205CDBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, languages LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', avatar_url VARCHAR(255) NOT NULL, boat_license_number VARCHAR(255) NOT NULL, insurance_number VARCHAR(255) NOT NULL, status INT NOT NULL, company_name VARCHAR(255) NOT NULL, siret_number VARCHAR(255) NOT NULL, rc_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boat ADD CONSTRAINT FK_D86E834AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fishing_notebook ADD CONSTRAINT FK_CA0F5D5CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE outlet ADD CONSTRAINT FK_93205CDBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boat DROP FOREIGN KEY FK_D86E834AA76ED395');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('ALTER TABLE fishing_notebook DROP FOREIGN KEY FK_CA0F5D5CA76ED395');
        $this->addSql('ALTER TABLE outlet DROP FOREIGN KEY FK_93205CDBA76ED395');
        $this->addSql('DROP TABLE boat');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE fishing_notebook');
        $this->addSql('DROP TABLE outlet');
        $this->addSql('DROP TABLE user');
    }
}
