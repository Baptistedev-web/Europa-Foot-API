<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\TypeCompetition;
class TypeCompetitionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de quelques types de compétition
        $type1 = new TypeCompetition();
        $type1->setLibelle('Championnat National');
        $manager->persist($type1);

        $type2 = new TypeCompetition();
        $type2->setLibelle('Coupe Nationale');
        $manager->persist($type2);

        $type3 = new TypeCompetition();
        $type3->setLibelle('SuperCoupe Nationale');
        $manager->persist($type3);

        $type4 = new TypeCompetition();
        $type4->setLibelle('Ligue des Champions');
        $manager->persist($type4);

        $type5 = new TypeCompetition();
        $type5->setLibelle('Ligue Europa');
        $manager->persist($type5);

        $type6 = new TypeCompetition();
        $type6->setLibelle('Ligue Europa Conférence');
        $manager->persist($type6);

        $manager->flush();
    }
}
