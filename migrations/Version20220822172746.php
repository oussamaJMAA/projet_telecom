<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822172746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_quiz (user_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_DE93B65BA76ED395 (user_id), INDEX IDX_DE93B65B853CD175 (quiz_id), PRIMARY KEY(user_id, quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_quiz ADD CONSTRAINT FK_DE93B65BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_quiz ADD CONSTRAINT FK_DE93B65B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD rate DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('DROP INDEX QuestID ON quiz_questions');
        $this->addSql('DROP INDEX `primary` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions CHANGE QuestID quest_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (quest_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_quiz DROP FOREIGN KEY FK_DE93B65BA76ED395');
        $this->addSql('ALTER TABLE user_quiz DROP FOREIGN KEY FK_DE93B65B853CD175');
        $this->addSql('DROP TABLE user_quiz');
        $this->addSql('ALTER TABLE course DROP rate');
        $this->addSql('ALTER TABLE quiz_questions MODIFY quest_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions CHANGE quest_id QuestID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX QuestID ON quiz_questions (QuestID)');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (QuestID)');
    }
}
