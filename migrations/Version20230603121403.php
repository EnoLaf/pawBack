<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603121403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, specie_id INT NOT NULL, veterinary_id INT DEFAULT NULL, owner_id INT NOT NULL, breed VARCHAR(50) NOT NULL, dob DATE NOT NULL, gender TINYINT(1) NOT NULL, name VARCHAR(50) NOT NULL, color VARCHAR(50) NOT NULL, id_chip INT DEFAULT NULL, sterelisation TINYINT(1) DEFAULT NULL, medical_history VARCHAR(255) DEFAULT NULL, activate TINYINT(1) NOT NULL, INDEX IDX_6AAB231FD5436AB7 (specie_id), INDEX IDX_6AAB231FD954EB99 (veterinary_id), INDEX IDX_6AAB231F7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, type_document_id INT NOT NULL, animal_id INT NOT NULL, owner_id INT NOT NULL, name VARCHAR(50) NOT NULL, date DATETIME NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_D8698A768826AFA6 (type_document_id), INDEX IDX_D8698A768E962C16 (animal_id), INDEX IDX_D8698A767E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, veterinary_id INT NOT NULL, name VARCHAR(50) NOT NULL, date DATETIME NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_C42F77848E962C16 (animal_id), INDEX IDX_C42F7784D954EB99 (veterinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) DEFAULT NULL, activate TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vaccination (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, vaccine_id INT NOT NULL, veterinary_id INT NOT NULL, date DATETIME NOT NULL, reference VARCHAR(255) NOT NULL, INDEX IDX_1B0999998E962C16 (animal_id), INDEX IDX_1B0999992BFE75C3 (vaccine_id), INDEX IDX_1B099999D954EB99 (veterinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vaccine (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinary (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, phone_number INT NOT NULL, url VARCHAR(100) DEFAULT NULL, street_number INT NOT NULL, street_name VARCHAR(50) NOT NULL, post_code INT NOT NULL, city VARCHAR(50) NOT NULL, activate TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FD5436AB7 FOREIGN KEY (specie_id) REFERENCES specie (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FD954EB99 FOREIGN KEY (veterinary_id) REFERENCES veterinary (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A768826AFA6 FOREIGN KEY (type_document_id) REFERENCES type_document (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A768E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A767E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F77848E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784D954EB99 FOREIGN KEY (veterinary_id) REFERENCES veterinary (id)');
        $this->addSql('ALTER TABLE vaccination ADD CONSTRAINT FK_1B0999998E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE vaccination ADD CONSTRAINT FK_1B0999992BFE75C3 FOREIGN KEY (vaccine_id) REFERENCES vaccine (id)');
        $this->addSql('ALTER TABLE vaccination ADD CONSTRAINT FK_1B099999D954EB99 FOREIGN KEY (veterinary_id) REFERENCES veterinary (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FD5436AB7');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FD954EB99');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F7E3C61F9');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A768826AFA6');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A768E962C16');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A767E3C61F9');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F77848E962C16');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784D954EB99');
        $this->addSql('ALTER TABLE vaccination DROP FOREIGN KEY FK_1B0999998E962C16');
        $this->addSql('ALTER TABLE vaccination DROP FOREIGN KEY FK_1B0999992BFE75C3');
        $this->addSql('ALTER TABLE vaccination DROP FOREIGN KEY FK_1B099999D954EB99');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE specie');
        $this->addSql('DROP TABLE type_document');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vaccination');
        $this->addSql('DROP TABLE vaccine');
        $this->addSql('DROP TABLE veterinary');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
