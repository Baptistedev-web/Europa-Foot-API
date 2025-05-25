<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\ClubCompetitionSaison;
use App\Entity\Club;
use App\Entity\CompetitionSaison;

class ClubCompetitionSaisonFixtures extends Fixture implements DependentFixtureInterface
{
    public const CLUBCOMPETITIONSAISON_REFERENCE = 'club-competition-saison';
    public function load(ObjectManager $manager): void
    {
        // Liste des références de clubs créées dans ClubFixtures
        $clubReferences = [
            "club-Paris Saint-Germain",
            "club-Olympique de Marseille",
            "club-AS Monaco",
        ];

        // Liste des références de compétitions saisons créées dans CompetitionSaisonFixtures
        $competitionSaisonReferences = [
            "competition-saison-1",
            "competition-saison-2",
        ];

        $i = 1;
        foreach ($clubReferences as $clubRef) {
            foreach ($competitionSaisonReferences as $competitionSaisonRef) {
                $clubCompetitionSaison = new ClubCompetitionSaison();
                $clubCompetitionSaison->setClub($this->getReference($clubRef, Club::class));
                $clubCompetitionSaison->setCompetitionSaison($this->getReference($competitionSaisonRef, CompetitionSaison::class));
                $manager->persist($clubCompetitionSaison);
                $this->addReference('club-competition-saison-'.$i, $clubCompetitionSaison);
                $i++;
            }
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            ClubFixtures::class,
            CompetitionSaisonFixtures::class,
        ];
    }
}
