<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826233330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
       
        $this->addSql('ALTER TABLE user ADD levels_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF9C3A25 FOREIGN KEY (levels_id) REFERENCES levels (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AF9C3A25 ON user (levels_id)');
       
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_questions MODIFY quest_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions CHANGE quest_id QuestID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (QuestID)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF9C3A25');
        $this->addSql('DROP INDEX IDX_8D93D649AF9C3A25 ON user');
        $this->addSql('ALTER TABLE user DROP levels_id');
        $this->addSql('ALTER TABLE user_quiz ADD score INT DEFAULT NULL, ADD created_at DATE DEFAULT \'CURRENT_TIMESTAMP\'');
    }
}
