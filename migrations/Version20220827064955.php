<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220827064955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, author_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_9474526C591CC992 (course_id), INDEX IDX_9474526CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, levels_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, nb_enrollments INT DEFAULT NULL, details LONGTEXT NOT NULL, link VARCHAR(255) NOT NULL, nb_likes INT NOT NULL, rate DOUBLE PRECISION DEFAULT NULL, INDEX IDX_169E6FB9AF9C3A25 (levels_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enrollments (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, course INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, user INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE levels (id INT AUTO_INCREMENT NOT NULL, difficulty INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, levels_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_A412FA92AF9C3A25 (levels_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_course (quiz_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_FBDA9FE0853CD175 (quiz_id), INDEX IDX_FBDA9FE0591CC992 (course_id), PRIMARY KEY(quiz_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_questions (quest_id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, question VARCHAR(255) NOT NULL, choice_a VARCHAR(255) NOT NULL, choice_b VARCHAR(255) NOT NULL, choice_c VARCHAR(255) DEFAULT NULL, choice_d VARCHAR(255) DEFAULT NULL, correct_answer VARCHAR(255) NOT NULL, explanation VARCHAR(255) NOT NULL, INDEX IDX_8CBC2533853CD175 (quiz_id), PRIMARY KEY(quest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, levels_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, verification_code VARCHAR(255) DEFAULT NULL, verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649AF9C3A25 (levels_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_course (user_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_73CC7484A76ED395 (user_id), INDEX IDX_73CC7484591CC992 (course_id), PRIMARY KEY(user_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_quiz (user_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_DE93B65BA76ED395 (user_id), INDEX IDX_DE93B65B853CD175 (quiz_id), PRIMARY KEY(user_id, quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9AF9C3A25 FOREIGN KEY (levels_id) REFERENCES levels (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92AF9C3A25 FOREIGN KEY (levels_id) REFERENCES levels (id)');
        $this->addSql('ALTER TABLE quiz_course ADD CONSTRAINT FK_FBDA9FE0853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_course ADD CONSTRAINT FK_FBDA9FE0591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_questions ADD CONSTRAINT FK_8CBC2533853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AF9C3A25 FOREIGN KEY (levels_id) REFERENCES levels (id)');
        $this->addSql('ALTER TABLE user_course ADD CONSTRAINT FK_73CC7484A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_course ADD CONSTRAINT FK_73CC7484591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_quiz ADD CONSTRAINT FK_DE93B65BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_quiz ADD CONSTRAINT FK_DE93B65B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C591CC992');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9AF9C3A25');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92AF9C3A25');
        $this->addSql('ALTER TABLE quiz_course DROP FOREIGN KEY FK_FBDA9FE0853CD175');
        $this->addSql('ALTER TABLE quiz_course DROP FOREIGN KEY FK_FBDA9FE0591CC992');
        $this->addSql('ALTER TABLE quiz_questions DROP FOREIGN KEY FK_8CBC2533853CD175');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AF9C3A25');
        $this->addSql('ALTER TABLE user_course DROP FOREIGN KEY FK_73CC7484A76ED395');
        $this->addSql('ALTER TABLE user_course DROP FOREIGN KEY FK_73CC7484591CC992');
        $this->addSql('ALTER TABLE user_quiz DROP FOREIGN KEY FK_DE93B65BA76ED395');
        $this->addSql('ALTER TABLE user_quiz DROP FOREIGN KEY FK_DE93B65B853CD175');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE enrollments');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE levels');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_course');
        $this->addSql('DROP TABLE quiz_questions');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_course');
        $this->addSql('DROP TABLE user_quiz');
    }
}
