<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607165414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD weight DOUBLE PRECISION DEFAULT NULL, CHANGE activate activate TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE activate activate TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE veterinary CHANGE activate activate TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP weight, CHANGE activate activate TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE activate activate TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE veterinary CHANGE activate activate TINYINT(1) DEFAULT 1 NOT NULL');
    }
}
