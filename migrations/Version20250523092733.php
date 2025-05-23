<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523092733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE competition_saison (id INT AUTO_INCREMENT NOT NULL, saison_id INT NOT NULL, competition_id INT NOT NULL, INDEX IDX_AF931555F965414C (saison_id), INDEX IDX_AF9315557B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition_saison ADD CONSTRAINT FK_AF931555F965414C FOREIGN KEY (saison_id) REFERENCES saison (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition_saison ADD CONSTRAINT FK_AF9315557B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE competition_saison DROP FOREIGN KEY FK_AF931555F965414C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition_saison DROP FOREIGN KEY FK_AF9315557B39D312
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE competition_saison
        SQL);
    }
}
