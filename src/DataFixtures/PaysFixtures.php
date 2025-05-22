<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Pays;
class PaysFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de quelques pays
        $pays1 = new Pays();
        $pays1->setNom('France');
        $manager->persist($pays1);

        $pays2 = new Pays();
        $pays2->setNom('Allemagne');
        $manager->persist($pays2);

        $pays3 = new Pays();
        $pays3->setNom('Espagne');
        $manager->persist($pays3);

        $pays4 = new Pays();
        $pays4->setNom('Italie');
        $manager->persist($pays4);

        $pays5 = new Pays();
        $pays5->setNom('Angleterre');
        $manager->persist($pays5);

        $pays6 = new Pays();
        $pays6->setNom('Monaco');
        $manager->persist($pays6);

        $manager->flush();
    }
}
