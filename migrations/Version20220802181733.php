<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802181733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enrollments_user (enrollments_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_2173381D1B4748EB (enrollments_id), INDEX IDX_2173381DA76ED395 (user_id), PRIMARY KEY(enrollments_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enrollments_course (enrollments_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_8FFB94761B4748EB (enrollments_id), INDEX IDX_8FFB9476591CC992 (course_id), PRIMARY KEY(enrollments_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enrollments_user ADD CONSTRAINT FK_2173381D1B4748EB FOREIGN KEY (enrollments_id) REFERENCES enrollments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enrollments_user ADD CONSTRAINT FK_2173381DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enrollments_course ADD CONSTRAINT FK_8FFB94761B4748EB FOREIGN KEY (enrollments_id) REFERENCES enrollments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enrollments_course ADD CONSTRAINT FK_8FFB9476591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enrollments DROP FOREIGN KEY FK_CCD8C132A76ED395');
        $this->addSql('ALTER TABLE enrollments DROP FOREIGN KEY FK_CCD8C132591CC992');
        $this->addSql('DROP INDEX UNIQ_CCD8C132591CC992 ON enrollments');
        $this->addSql('DROP INDEX UNIQ_CCD8C132A76ED395 ON enrollments');
        $this->addSql('ALTER TABLE enrollments DROP user_id, DROP course_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE enrollments_user');
        $this->addSql('DROP TABLE enrollments_course');
        $this->addSql('ALTER TABLE enrollments ADD user_id INT DEFAULT NULL, ADD course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE enrollments ADD CONSTRAINT FK_CCD8C132A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE enrollments ADD CONSTRAINT FK_CCD8C132591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CCD8C132591CC992 ON enrollments (course_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CCD8C132A76ED395 ON enrollments (user_id)');
    }
}
