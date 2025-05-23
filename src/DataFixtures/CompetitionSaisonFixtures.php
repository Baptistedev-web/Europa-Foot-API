<?php

namespace App\DataFixtures;

use App\DataFixtures\CompetitionFixtures;
use App\DataFixtures\SaisonFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\CompetitionSaison;
use App\Entity\Competition;
use App\Entity\Saison;

class CompetitionSaisonFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMPETITIONSAISON_REFERENCE = 'competition-saison';

    public function load(ObjectManager $manager): void
    {
        // Liste des références de compétitions créées dans CompetitionFixtures
        $competitionReferences = [
            "competition-Ligue 1",
            "competition-Ligue 2",
            "competition-Coupe de France",
            "competition-SuperCoupe France",
            "competition-SERIA A",
            "competition-SERIE B",
            "competition-Coupe d'Italie",
            "competition-SuperCoupe Italie",
            "competition-Premier League",
            "competition-Championship",
            "competition-FA Cup",
            "competition-SuperCoupe Angleterre",
            "competition-Bundesliga",
            "competition-2.Bundesliga",
            "competition-DFB-Pokal",
            "competition-SuperCoupe Allemagne",
            "competition-La Liga",
            "competition-La Liga 2",
            "competition-Coupe du Roi",
            "competition-SuperCoupe Espagne",
            "competition-UEFA Champions League",
            "competition-UEFA Europa League",
            "competition-UEFA Europa Conference League",
            "competition-SuperCoupe de l'UEFA",
        ];

        // Références des saisons
        $saisonReferences = [
            "saison_2023-2024",
            "saison_2024-2025",
        ];

        $i = 1;

        foreach ($competitionReferences as $competitionRef) {
            foreach ($saisonReferences as $saisonRef) {
                $competitionSaison = new CompetitionSaison();
                $competitionSaison->setCompetition($this->getReference($competitionRef, Competition::class));
                $competitionSaison->setSaison($this->getReference($saisonRef, Saison::class));
                $manager->persist($competitionSaison);
                $this->addReference('competition-saison-'.$i, $competitionSaison);
                $i++;
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CompetitionFixtures::class,
            SaisonFixtures::class,
        ];
    }
}
