<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Competition;
use App\Entity\Pays;
use App\Entity\TypeCompetition;
use App\DataFixtures\PaysFixtures;
use App\DataFixtures\TypeCompetitionFixtures;

class CompetitionFixtures extends Fixture implements DependentFixtureInterface
{
    public const COMPETITION_REFERENCE = 'competition';
    public function load(ObjectManager $manager): void
    {
        // France
        $competition1 = new Competition();
        $competition1->setNom('Ligue 1');
        $competition1->setPays($this->getReference('pays_France', Pays::class));
        $competition1->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition1);
        $this->addReference("competition-Ligue 1", $competition1);

        $competition2 = new Competition();
        $competition2->setNom('Ligue 2');
        $competition2->setPays($this->getReference('pays_France', Pays::class));
        $competition2->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition2);
        $this->addReference("competition-Ligue 2", $competition2);

        $competitionCoupeFrance = new Competition();
        $competitionCoupeFrance->setNom('Coupe de France');
        $competitionCoupeFrance->setPays($this->getReference('pays_France', Pays::class));
        $competitionCoupeFrance->setTypeCompetition($this->getReference('type-competition_Coupe Nationale', TypeCompetition::class));
        $manager->persist($competitionCoupeFrance);
        $this->addReference("competition-Coupe de France", $competitionCoupeFrance);

        $competition6 = new Competition();
        $competition6->setNom('SuperCoupe France');
        $competition6->setPays($this->getReference('pays_France', Pays::class));
        $competition6->setTypeCompetition($this->getReference('type-competition_SuperCoupe Nationale', TypeCompetition::class));
        $manager->persist($competition6);
        $this->addReference("competition-SuperCoupe France", $competition6);

        // Italie
        $competition8 = new Competition();
        $competition8->setNom('SERIA A');
        $competition8->setPays($this->getReference('pays_Italie', Pays::class));
        $competition8->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition8);
        $this->addReference("competition-SERIA A", $competition8);

        $competition9 = new Competition();
        $competition9->setNom('SERIE B');
        $competition9->setPays($this->getReference('pays_Italie', Pays::class));
        $competition9->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition9);
        $this->addReference("competition-SERIE B", $competition9);

        $competitionCoupeItalie = new Competition();
        $competitionCoupeItalie->setNom('Coupe d\'Italie');
        $competitionCoupeItalie->setPays($this->getReference('pays_Italie', Pays::class));
        $competitionCoupeItalie->setTypeCompetition($this->getReference('type-competition_Coupe Nationale', TypeCompetition::class));
        $manager->persist($competitionCoupeItalie);
        $this->addReference("competition-Coupe d'Italie", $competitionCoupeItalie);

        $competition10 = new Competition();
        $competition10->setNom('SuperCoupe Italie');
        $competition10->setPays($this->getReference('pays_Italie', Pays::class));
        $competition10->setTypeCompetition($this->getReference('type-competition_SuperCoupe Nationale', TypeCompetition::class));
        $manager->persist($competition10);
        $this->addReference("competition-SuperCoupe Italie", $competition10);

        // Angleterre
        $competition11 = new Competition();
        $competition11->setNom('Premier League');
        $competition11->setPays($this->getReference('pays_Angleterre', Pays::class));
        $competition11->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition11);
        $this->addReference("competition-Premier League", $competition11);

        $competition12 = new Competition();
        $competition12->setNom('Championship');
        $competition12->setPays($this->getReference('pays_Angleterre', Pays::class));
        $competition12->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition12);
        $this->addReference("competition-Championship", $competition12);

        $competitionCoupeAngleterre = new Competition();
        $competitionCoupeAngleterre->setNom('FA Cup');
        $competitionCoupeAngleterre->setPays($this->getReference('pays_Angleterre', Pays::class));
        $competitionCoupeAngleterre->setTypeCompetition($this->getReference('type-competition_Coupe Nationale', TypeCompetition::class));
        $manager->persist($competitionCoupeAngleterre);
        $this->addReference("competition-FA Cup", $competitionCoupeAngleterre);

        $competition13 = new Competition();
        $competition13->setNom('SuperCoupe Angleterre');
        $competition13->setPays($this->getReference('pays_Angleterre', Pays::class));
        $competition13->setTypeCompetition($this->getReference('type-competition_SuperCoupe Nationale', TypeCompetition::class));
        $manager->persist($competition13);
        $this->addReference("competition-SuperCoupe Angleterre", $competition13);

        // Allemagne
        $competition14 = new Competition();
        $competition14->setNom('Bundesliga');
        $competition14->setPays($this->getReference('pays_Allemagne', Pays::class));
        $competition14->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition14);
        $this->addReference("competition-Bundesliga", $competition14);

        $competition15 = new Competition();
        $competition15->setNom('2.Bundesliga');
        $competition15->setPays($this->getReference('pays_Allemagne', Pays::class));
        $competition15->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition15);
        $this->addReference("competition-2.Bundesliga", $competition15);

        $competitionCoupeAllemagne = new Competition();
        $competitionCoupeAllemagne->setNom('DFB-Pokal');
        $competitionCoupeAllemagne->setPays($this->getReference('pays_Allemagne', Pays::class));
        $competitionCoupeAllemagne->setTypeCompetition($this->getReference('type-competition_Coupe Nationale', TypeCompetition::class));
        $manager->persist($competitionCoupeAllemagne);
        $this->addReference("competition-DFB-Pokal", $competitionCoupeAllemagne);

        $competition16 = new Competition();
        $competition16->setNom('SuperCoupe Allemagne');
        $competition16->setPays($this->getReference('pays_Allemagne', Pays::class));
        $competition16->setTypeCompetition($this->getReference('type-competition_SuperCoupe Nationale', TypeCompetition::class));
        $manager->persist($competition16);
        $this->addReference("competition-SuperCoupe Allemagne", $competition16);

        // Espagne
        $competition17 = new Competition();
        $competition17->setNom('La Liga');
        $competition17->setPays($this->getReference('pays_Espagne', Pays::class));
        $competition17->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition17);
        $this->addReference("competition-La Liga", $competition17);

        $competition18 = new Competition();
        $competition18->setNom('La Liga 2');
        $competition18->setPays($this->getReference('pays_Espagne', Pays::class));
        $competition18->setTypeCompetition($this->getReference('type-competition_Championnat National', TypeCompetition::class));
        $manager->persist($competition18);
        $this->addReference("competition-La Liga 2", $competition18);

        $competitionCoupeEspagne = new Competition();
        $competitionCoupeEspagne->setNom('Coupe du Roi');
        $competitionCoupeEspagne->setPays($this->getReference('pays_Espagne', Pays::class));
        $competitionCoupeEspagne->setTypeCompetition($this->getReference('type-competition_Coupe Nationale', TypeCompetition::class));
        $manager->persist($competitionCoupeEspagne);
        $this->addReference("competition-Coupe du Roi", $competitionCoupeEspagne);

        $competition19 = new Competition();
        $competition19->setNom('SuperCoupe Espagne');
        $competition19->setPays($this->getReference('pays_Espagne', Pays::class));
        $competition19->setTypeCompetition($this->getReference('type-competition_SuperCoupe Nationale', TypeCompetition::class));
        $manager->persist($competition19);
        $this->addReference("competition-SuperCoupe Espagne", $competition19);

        // Compétitions européennes (pas de pays)
        $competition3 = new Competition();
        $competition3->setNom('UEFA Champions League');
        $competition3->setPays(null);
        $competition3->setTypeCompetition($this->getReference('type-competition_Ligue des Champions', TypeCompetition::class));
        $manager->persist($competition3);
        $this->addReference("competition-UEFA Champions League", $competition3);

        $competition4 = new Competition();
        $competition4->setNom('UEFA Europa League');
        $competition4->setPays(null);
        $competition4->setTypeCompetition($this->getReference('type-competition_Ligue Europa', TypeCompetition::class));
        $manager->persist($competition4);
        $this->addReference("competition-UEFA Europa League", $competition4);

        $competition5 = new Competition();
        $competition5->setNom("UEFA Europa Conference League");
        $competition5->setPays(null);
        $competition5->setTypeCompetition($this->getReference('type-competition_Ligue Europa Conférence', TypeCompetition::class));
        $manager->persist($competition5);
        $this->addReference("competition-UEFA Europa Conference League", $competition5);

        $competition7 = new Competition();
        $competition7->setNom("SuperCoupe de l'UEFA");
        $competition7->setPays(null);
        $competition7->setTypeCompetition($this->getReference("type-competition_SuperCoupe d'Europe", TypeCompetition::class));
        $manager->persist($competition7);
        $this->addReference("competition-SuperCoupe de l'UEFA", $competition7);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            PaysFixtures::class,
            TypeCompetitionFixtures::class,
        ];
    }
}
