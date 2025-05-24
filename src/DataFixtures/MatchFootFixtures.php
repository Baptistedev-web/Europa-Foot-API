<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\MatchFoot;
use App\Entity\CompetitionSaison;
use App\Entity\Club;
use App\Entity\Statut;

class MatchFootFixtures extends Fixture implements DependentFixtureInterface
{
    public const MATCH_REFERENCE = 'match-foot';
    public function load(ObjectManager $manager): void
    {
        // Liste des références de compétitions saisons créées dans CompetitionSaisonFixtures
        $competitionSaisonReferences = [
            "competition-saison-2",
            "competition-saison-42",
        ];

        // Liste des références de clubs créées dans ClubFixtures
        $clubReferences = [
            "club-Paris Saint-Germain",
            "club-AS Monaco",
            "club-Inter Milan",
        ];

        // Liste des références de statuts créées dans StatutFixtures
        $statutReferences = [
            "statut_programmee",
            "statut_terminee",
        ];

        $match = new MatchFoot();
        $match->setCompetitionSaison($this->getReference($competitionSaisonReferences[0], CompetitionSaison::class));
        $match->setClubRecevant($this->getReference($clubReferences[0], Club::class));
        $match->setClubExterieur($this->getReference($clubReferences[1], Club::class));
        $match->setStatut($this->getReference($statutReferences[1], Statut::class));
        $match->setScoreEquipeRecevant(4);
        $match->setScoreEquipeExterieur(1);
        $match->setStade("Parc des Princes");
        $manager->persist($match);

        $match2 = new MatchFoot();
        $match2->setCompetitionSaison($this->getReference($competitionSaisonReferences[1], CompetitionSaison::class));
        $match2->setClubRecevant($this->getReference($clubReferences[0], Club::class));
        $match2->setClubExterieur($this->getReference($clubReferences[2], Club::class));
        $match2->setStatut($this->getReference($statutReferences[0], Statut::class));
        $match2->setScoreEquipeRecevant(0);
        $match2->setScoreEquipeExterieur(0);
        $match2->setStade("Allianz Arena");
        $manager->persist($match2);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CompetitionSaisonFixtures::class,
            ClubFixtures::class,
            StatutFixtures::class,
        ];
    }
}
