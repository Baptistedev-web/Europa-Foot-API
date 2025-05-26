<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Placement;

class PlacementFixtures extends Fixture
{
    public const PLACEMENT_REFERENCE = 'placement';
    public function load(ObjectManager $manager): void
    {
        // Création de placements
        $placement1 = new Placement();
        $placement1->setNom('Gardien');
        $placement1->setCode('GD');
        $manager->persist($placement1);
        $this->addReference("placement-gardien", $placement1);

        $placement2 = new Placement();
        $placement2->setNom('Défenseur central');
        $placement2->setCode('DC');
        $manager->persist($placement2);
        $this->addReference("placement-defenseur-central", $placement2);

        $placement3 = new Placement();
        $placement3->setNom('Latéral droit');
        $placement3->setCode('LD');
        $manager->persist($placement3);
        $this->addReference("placement_lateral_droit", $placement3);

        $placement4 = new Placement();
        $placement4->setNom('Latéral gauche');
        $placement4->setCode('LG');
        $manager->persist($placement4);
        $this->addReference("placement_lateral_gauche", $placement4);

        $placement5 = new Placement();
        $placement5->setNom('Milieu défensif');
        $placement5->setCode('MD');
        $manager->persist($placement5);
        $this->addReference("placement_milieu_defensif", $placement5);

        $placement6 = new Placement();
        $placement6->setNom('Milieu central');
        $placement6->setCode('MC');
        $manager->persist($placement6);
        $this->addReference("placement_milieu_central", $placement6);

        $placement7 = new Placement();
        $placement7->setNom('Milieu offensif');
        $placement7->setCode('MO');
        $manager->persist($placement7);
        $this->addReference("placement_milieu_offensif", $placement7);

        $placement8 = new Placement();
        $placement8->setNom('Ailier droit');
        $placement8->setCode('AD');
        $manager->persist($placement8);
        $this->addReference("placement_ailier_droit", $placement8);

        $placement9 = new Placement();
        $placement9->setNom('Ailier gauche');
        $placement9->setCode('AG');
        $manager->persist($placement9);
        $this->addReference("placement_ailier_gauche", $placement9);

        $placement10 = new Placement();
        $placement10->setNom('Attaquant');
        $placement10->setCode('AT');
        $manager->persist($placement10);
        $this->addReference("placement_attaquant", $placement10);

        $placement11 = new Placement();
        $placement11->setNom('Buteur');
        $placement11->setCode('BU');
        $manager->persist($placement11);
        $this->addReference("placement_buteur", $placement11);

        $placement12 = new Placement();
        $placement12->setNom('Milieu defensif central');
        $placement12->setCode('MDC');
        $manager->persist($placement12);
        $this->addReference("placement_millieur_defensif_central", $placement12);




        $manager->flush();
    }
}
