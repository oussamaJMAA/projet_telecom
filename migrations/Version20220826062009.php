<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220826062009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(255) NOT NULL, ADD verification_code VARCHAR(255) DEFAULT NULL, ADD verified TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_course DROP created_at');
        $this->addSql('ALTER TABLE user_quiz DROP score, DROP created_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_questions MODIFY quest_id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON quiz_questions');
        $this->addSql('ALTER TABLE quiz_questions CHANGE quest_id QuestID INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_questions ADD PRIMARY KEY (QuestID)');
        $this->addSql('ALTER TABLE user DROP phone_number, DROP verification_code, DROP verified');
        $this->addSql('ALTER TABLE user_course ADD created_at DATE DEFAULT \'CURRENT_TIMESTAMP\'');
        $this->addSql('ALTER TABLE user_quiz ADD score INT NOT NULL, ADD created_at DATE DEFAULT \'CURRENT_TIMESTAMP\'');
    }
}
