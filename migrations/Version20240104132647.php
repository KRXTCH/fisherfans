<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240104132647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boat ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE boat ADD CONSTRAINT FK_D86E834AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D86E834AA76ED395 ON boat (user_id)');
        $this->addSql('ALTER TABLE booking ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEA76ED395 ON booking (user_id)');
        $this->addSql('ALTER TABLE fishing_notebook ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE fishing_notebook ADD CONSTRAINT FK_CA0F5D5CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CA0F5D5CA76ED395 ON fishing_notebook (user_id)');
        $this->addSql('ALTER TABLE outlet ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE outlet ADD CONSTRAINT FK_93205CDBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_93205CDBA76ED395 ON outlet (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boat DROP FOREIGN KEY FK_D86E834AA76ED395');
        $this->addSql('DROP INDEX IDX_D86E834AA76ED395 ON boat');
        $this->addSql('ALTER TABLE boat DROP user_id');
        $this->addSql('ALTER TABLE fishing_notebook DROP FOREIGN KEY FK_CA0F5D5CA76ED395');
        $this->addSql('DROP INDEX IDX_CA0F5D5CA76ED395 ON fishing_notebook');
        $this->addSql('ALTER TABLE fishing_notebook DROP user_id');
        $this->addSql('ALTER TABLE outlet DROP FOREIGN KEY FK_93205CDBA76ED395');
        $this->addSql('DROP INDEX IDX_93205CDBA76ED395 ON outlet');
        $this->addSql('ALTER TABLE outlet DROP user_id');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA76ED395');
        $this->addSql('DROP INDEX IDX_E00CEDDEA76ED395 ON booking');
        $this->addSql('ALTER TABLE booking DROP user_id');
    }
}
