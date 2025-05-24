<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250524151544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE match_foot (id INT AUTO_INCREMENT NOT NULL, statut_id INT NOT NULL, competition_saison_id INT NOT NULL, club_recevant_id INT NOT NULL, club_exterieur_id INT NOT NULL, score_equipe_recevant INT NOT NULL, score_equipe_exterieur INT NOT NULL, stade VARCHAR(50) DEFAULT NULL, INDEX IDX_A8E088E1F6203804 (statut_id), INDEX IDX_A8E088E152850D2E (competition_saison_id), INDEX IDX_A8E088E1CE5F05F4 (club_recevant_id), INDEX IDX_A8E088E1DD413D80 (club_exterieur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_foot ADD CONSTRAINT FK_A8E088E1F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_foot ADD CONSTRAINT FK_A8E088E152850D2E FOREIGN KEY (competition_saison_id) REFERENCES competition_saison (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_foot ADD CONSTRAINT FK_A8E088E1CE5F05F4 FOREIGN KEY (club_recevant_id) REFERENCES club (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_foot ADD CONSTRAINT FK_A8E088E1DD413D80 FOREIGN KEY (club_exterieur_id) REFERENCES club (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE match_foot DROP FOREIGN KEY FK_A8E088E1F6203804
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_foot DROP FOREIGN KEY FK_A8E088E152850D2E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_foot DROP FOREIGN KEY FK_A8E088E1CE5F05F4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE match_foot DROP FOREIGN KEY FK_A8E088E1DD413D80
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE match_foot
        SQL);
    }
}
