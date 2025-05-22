<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522170842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, type_competition_id INT NOT NULL, nom VARCHAR(30) NOT NULL, INDEX IDX_B50A2CB1A6E44244 (pays_id), INDEX IDX_B50A2CB12DFAFA86 (type_competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB12DFAFA86 FOREIGN KEY (type_competition_id) REFERENCES type_competition (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1A6E44244
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB12DFAFA86
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE competition
        SQL);
    }
}
