<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220813192409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX QuestID ON quiz_questions');
        $this->addSql('DROP INDEX `primary` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions ADD quiz_id INT DEFAULT NULL, CHANGE QuestID quest_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_questions ADD CONSTRAINT FK_8CBC2533853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_8CBC2533853CD175 ON quiz_questions (quiz_id)');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (quest_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_questions DROP FOREIGN KEY FK_8CBC2533853CD175');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('ALTER TABLE quiz_questions MODIFY quest_id INT NOT NULL');
        $this->addSql('DROP INDEX IDX_8CBC2533853CD175 ON quiz_questions');
        $this->addSql('DROP INDEX `PRIMARY` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions DROP quiz_id, CHANGE quest_id QuestID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX QuestID ON quiz_questions (QuestID)');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (QuestID)');
    }
}
