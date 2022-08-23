<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823003613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_quiz (course_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_6CB02794591CC992 (course_id), INDEX IDX_6CB02794853CD175 (quiz_id), PRIMARY KEY(course_id, quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_quiz ADD CONSTRAINT FK_6CB02794591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_quiz ADD CONSTRAINT FK_6CB02794853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD rate DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user_quiz DROP score');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_quiz DROP FOREIGN KEY FK_6CB02794591CC992');
        $this->addSql('ALTER TABLE course_quiz DROP FOREIGN KEY FK_6CB02794853CD175');
        $this->addSql('DROP TABLE course_quiz');
        $this->addSql('ALTER TABLE course DROP rate');
        $this->addSql('ALTER TABLE user_quiz ADD score INT DEFAULT NULL');
    }
}
