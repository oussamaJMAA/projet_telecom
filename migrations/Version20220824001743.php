<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824001743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_course (quiz_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_FBDA9FE0853CD175 (quiz_id), INDEX IDX_FBDA9FE0591CC992 (course_id), PRIMARY KEY(quiz_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz_course ADD CONSTRAINT FK_FBDA9FE0853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_course ADD CONSTRAINT FK_FBDA9FE0591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD rate DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('DROP INDEX `primary` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions CHANGE QuestID quest_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (quest_id)');
        $this->addSql('ALTER TABLE user_quiz DROP score');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_course DROP FOREIGN KEY FK_FBDA9FE0853CD175');
        $this->addSql('ALTER TABLE quiz_course DROP FOREIGN KEY FK_FBDA9FE0591CC992');
        $this->addSql('DROP TABLE quiz_course');
        $this->addSql('ALTER TABLE course DROP rate');
        $this->addSql('ALTER TABLE quiz_questions MODIFY quest_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions CHANGE quest_id QuestID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (QuestID)');
        $this->addSql('ALTER TABLE user_quiz ADD score INT NOT NULL');
    }
}
