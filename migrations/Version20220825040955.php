<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220825040955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, user INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX `primary` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions CHANGE QuestID quest_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (quest_id)');
        $this->addSql('ALTER TABLE user_course DROP created_at');
        $this->addSql('ALTER TABLE user_quiz DROP score, DROP created_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE history');
        $this->addSql('ALTER TABLE quiz_questions MODIFY quest_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions CHANGE quest_id QuestID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (QuestID)');
        $this->addSql('ALTER TABLE user_course ADD created_at DATE DEFAULT \'CURRENT_TIMESTAMP\'');
        $this->addSql('ALTER TABLE user_quiz ADD score INT NOT NULL, ADD created_at DATE DEFAULT \'CURRENT_TIMESTAMP\'');
    }
}
