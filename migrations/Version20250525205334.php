<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250525205334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, pays_id INT NOT NULL, nom VARCHAR(50) NOT NULL, stade VARCHAR(50) NOT NULL, INDEX IDX_B8EE3872A6E44244 (pays_id), UNIQUE INDEX club_unique (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE club_competition_saison (id INT AUTO_INCREMENT NOT NULL, competition_saison_id INT NOT NULL, club_id INT NOT NULL, INDEX IDX_3120EC5052850D2E (competition_saison_id), INDEX IDX_3120EC5061190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, type_competition_id INT NOT NULL, nom VARCHAR(30) NOT NULL, INDEX IDX_B50A2CB1A6E44244 (pays_id), INDEX IDX_B50A2CB12DFAFA86 (type_competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE competition_saison (id INT AUTO_INCREMENT NOT NULL, saison_id INT NOT NULL, competition_id INT NOT NULL, INDEX IDX_AF931555F965414C (saison_id), INDEX IDX_AF9315557B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE match_foot (id INT AUTO_INCREMENT NOT NULL, statut_id INT NOT NULL, competition_saison_id INT NOT NULL, club_recevant_id INT NOT NULL, club_exterieur_id INT NOT NULL, score_equipe_recevant INT NOT NULL, score_equipe_exterieur INT NOT NULL, stade VARCHAR(50) DEFAULT NULL, INDEX IDX_A8E088E1F6203804 (statut_id), INDEX IDX_A8E088E152850D2E (competition_saison_id), INDEX IDX_A8E088E1CE5F05F4 (club_recevant_id), INDEX IDX_A8E088E1DD413D80 (club_exterieur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, UNIQUE INDEX nom_unique (nom), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE saison (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(9) NOT NULL, debut VARCHAR(10) NOT NULL, fin VARCHAR(10) NOT NULL, UNIQUE INDEX saison_unique (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, UNIQUE INDEX libelle_unique (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE type_competition (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) NOT NULL, UNIQUE INDEX type_competition_unique (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE club ADD CONSTRAINT FK_B8EE3872A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE club_competition_saison ADD CONSTRAINT FK_3120EC5052850D2E FOREIGN KEY (competition_saison_id) REFERENCES competition_saison (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE club_competition_saison ADD CONSTRAINT FK_3120EC5061190A32 FOREIGN KEY (club_id) REFERENCES club (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB12DFAFA86 FOREIGN KEY (type_competition_id) REFERENCES type_competition (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition_saison ADD CONSTRAINT FK_AF931555F965414C FOREIGN KEY (saison_id) REFERENCES saison (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition_saison ADD CONSTRAINT FK_AF9315557B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)
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
            ALTER TABLE club DROP FOREIGN KEY FK_B8EE3872A6E44244
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE club_competition_saison DROP FOREIGN KEY FK_3120EC5052850D2E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE club_competition_saison DROP FOREIGN KEY FK_3120EC5061190A32
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1A6E44244
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB12DFAFA86
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition_saison DROP FOREIGN KEY FK_AF931555F965414C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE competition_saison DROP FOREIGN KEY FK_AF9315557B39D312
        SQL);
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
            DROP TABLE club
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE club_competition_saison
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE competition
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE competition_saison
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE match_foot
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pays
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE saison
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE statut
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE type_competition
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
