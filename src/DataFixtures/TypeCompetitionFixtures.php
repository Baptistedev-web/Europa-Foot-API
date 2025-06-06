<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\TypeCompetition;

class TypeCompetitionFixtures extends Fixture
{
    public const TYPECOMPETITION_REFERENCE = 'type-competition';
    public function load(ObjectManager $manager): void
    {
        // Création de quelques types de compétition
        $type1 = new TypeCompetition();
        $type1->setLibelle('Championnat National');
        $manager->persist($type1);
        $this->addReference('type-competition_Championnat National', $type1);

        $type2 = new TypeCompetition();
        $type2->setLibelle('Coupe National');
        $manager->persist($type2);
        $this->addReference('type-competition_Coupe Nationale', $type2);

        $type3 = new TypeCompetition();
        $type3->setLibelle('SuperCoupe National');
        $manager->persist($type3);
        $this->addReference('type-competition_SuperCoupe Nationale', $type3);

        $type4 = new TypeCompetition();
        $type4->setLibelle('Ligue des Champions');
        $manager->persist($type4);
        $this->addReference('type-competition_Ligue des Champions', $type4);

        $type5 = new TypeCompetition();
        $type5->setLibelle('Ligue Europa');
        $manager->persist($type5);
        $this->addReference('type-competition_Ligue Europa', $type5);

        $type6 = new TypeCompetition();
        $type6->setLibelle('Ligue Europa Conférence');
        $manager->persist($type6);
        $this->addReference('type-competition_Ligue Europa Conférence', $type6);

        $type7 = new TypeCompetition();
        $type7->setLibelle("SuperCoupe d'Europe");
        $manager->persist($type7);
        $this->addReference("type-competition_SuperCoupe d'Europe", $type7);

        $manager->flush();
    }
}
