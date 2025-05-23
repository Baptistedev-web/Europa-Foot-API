<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Saison;
class SaisonFixtures extends Fixture
{
    public const SAISON_REFERENCE = 'saison';
    public function load(ObjectManager $manager): void
    {
        // Création de la saison 2023-2024
        $saison = new Saison();
        $saison->setLabel('2023-2024');
        $saison->setDebut('2023-08-01');
        $saison->setFin('2024-07-01');
        $manager->persist($saison);
        $this->addReference('saison_2023-2024', $saison);

        // Création de la saison 2024-2025
        $saison2 = new Saison();
        $saison2->setLabel('2024-2025');
        $saison2->setDebut('2024-08-01');
        $saison2->setFin('2025-07-01');
        $manager->persist($saison2);
        $this->addReference('saison_2024-2025', $saison2);

        $manager->flush();
    }
}
