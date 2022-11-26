<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121190259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock (
                            id INT AUTO_INCREMENT NOT NULL,     
                            symbol VARCHAR(8) NOT NULL, 
                            mid NUMERIC(10, 4) DEFAULT NULL, 
                            bid NUMERIC(10, 4) DEFAULT NULL, 
                            ask NUMERIC(10, 4) DEFAULT NULL, 
                            last_price NUMERIC(10, 4) DEFAULT NULL, 
                            low NUMERIC(10, 4) DEFAULT NULL, 
                            high NUMERIC(10, 4) DEFAULT NULL, 
                            volume NUMERIC(10, 4) DEFAULT NULL, 
                            timestamp DATETIME DEFAULT NULL, 
                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stock');
    }
}
