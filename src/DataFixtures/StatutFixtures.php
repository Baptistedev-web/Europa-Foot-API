<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Statut;
class StatutFixtures extends Fixture
{
    public const STATUT_REFERENCE = 'statut';
    public function load(ObjectManager $manager): void
    {
        $statuts = [
            ['Programmée','statut_programmee'],
            ['En cours','statut_en_cours'],
            ['Terminée','statut_terminee'],
            ['Reportée','statut_reportee'],
            ['Annulée','statut_annulee'],
            ['Suspendue','statut_suspendue'],
            ['Interrompu','statut_interrompu'],
            ['Abandonnée','statut_abandonnee'],
            ['Retardée','statut_retardee'],
        ];
        foreach ($statuts as [$libelle, $reference]) {
            $statut = new Statut();
            $statut->setLibelle($libelle);
            $manager->persist($statut);
            $this->addReference($reference, $statut);
        }

        $manager->flush();
    }
}
