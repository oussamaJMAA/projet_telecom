<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826210631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD levels_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9AF9C3A25 FOREIGN KEY (levels_id) REFERENCES levels (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9AF9C3A25 ON course (levels_id)');
        $this->addSql('ALTER TABLE quiz ADD levels_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92AF9C3A25 FOREIGN KEY (levels_id) REFERENCES levels (id)');
        $this->addSql('CREATE INDEX IDX_A412FA92AF9C3A25 ON quiz (levels_id)');
        $this->addSql('ALTER TABLE user ADD levels_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF9C3A25 FOREIGN KEY (levels_id) REFERENCES levels (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AF9C3A25 ON user (levels_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9AF9C3A25');
        $this->addSql('DROP INDEX IDX_169E6FB9AF9C3A25 ON course');
        $this->addSql('ALTER TABLE course DROP levels_id');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92AF9C3A25');
        $this->addSql('DROP INDEX IDX_A412FA92AF9C3A25 ON quiz');
        $this->addSql('ALTER TABLE quiz DROP levels_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF9C3A25');
        $this->addSql('DROP INDEX IDX_8D93D649AF9C3A25 ON user');
        $this->addSql('ALTER TABLE user DROP levels_id');
    }
}
