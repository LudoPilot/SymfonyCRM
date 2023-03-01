<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230301145317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, owner_id INT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(15) DEFAULT NULL, INDEX IDX_4C62E638979B1AD6 (company_id), INDEX IDX_4C62E6387E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_invitation (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, event_id INT NOT NULL, contact_id INT NOT NULL, status SMALLINT NOT NULL, INDEX IDX_36A43835F624B39D (sender_id), INDEX IDX_36A4383571F7E88B (event_id), INDEX IDX_36A43835E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_invitation (id INT AUTO_INCREMENT NOT NULL, organizer_id INT NOT NULL, event_id INT NOT NULL, invited_employee_id INT NOT NULL, status SMALLINT NOT NULL, INDEX IDX_69CAD176876C4DDA (organizer_id), INDEX IDX_69CAD17671F7E88B (event_id), INDEX IDX_69CAD17655E485FB (invited_employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, organizer_id INT NOT NULL, title VARCHAR(60) NOT NULL, description LONGTEXT DEFAULT NULL, location VARCHAR(50) DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_3BAE0AA7876C4DDA (organizer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE external_company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, phone VARCHAR(12) DEFAULT NULL, address VARCHAR(60) NOT NULL, zipcode VARCHAR(12) NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(40) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE host_company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, phone VARCHAR(12) DEFAULT NULL, address VARCHAR(60) DEFAULT NULL, zipcode VARCHAR(12) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, email VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, title VARCHAR(100) NOT NULL, due_date DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, status SMALLINT NOT NULL, INDEX IDX_527EDB257E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638979B1AD6 FOREIGN KEY (company_id) REFERENCES external_company (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E6387E3C61F9 FOREIGN KEY (owner_id) REFERENCES host_company (id)');
        $this->addSql('ALTER TABLE contact_invitation ADD CONSTRAINT FK_36A43835F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact_invitation ADD CONSTRAINT FK_36A4383571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE contact_invitation ADD CONSTRAINT FK_36A43835E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE employee_invitation ADD CONSTRAINT FK_69CAD176876C4DDA FOREIGN KEY (organizer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employee_invitation ADD CONSTRAINT FK_69CAD17671F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE employee_invitation ADD CONSTRAINT FK_69CAD17655E485FB FOREIGN KEY (invited_employee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7876C4DDA FOREIGN KEY (organizer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB257E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES host_company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638979B1AD6');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E6387E3C61F9');
        $this->addSql('ALTER TABLE contact_invitation DROP FOREIGN KEY FK_36A43835F624B39D');
        $this->addSql('ALTER TABLE contact_invitation DROP FOREIGN KEY FK_36A4383571F7E88B');
        $this->addSql('ALTER TABLE contact_invitation DROP FOREIGN KEY FK_36A43835E7A1254A');
        $this->addSql('ALTER TABLE employee_invitation DROP FOREIGN KEY FK_69CAD176876C4DDA');
        $this->addSql('ALTER TABLE employee_invitation DROP FOREIGN KEY FK_69CAD17671F7E88B');
        $this->addSql('ALTER TABLE employee_invitation DROP FOREIGN KEY FK_69CAD17655E485FB');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7876C4DDA');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB257E3C61F9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contact_invitation');
        $this->addSql('DROP TABLE employee_invitation');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE external_company');
        $this->addSql('DROP TABLE host_company');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
