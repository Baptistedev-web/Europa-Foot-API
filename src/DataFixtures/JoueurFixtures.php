<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Joueur;
use App\Entity\Placement;
class JoueurFixtures extends Fixture implements DependentFixtureInterface
{
    public const JOUEUR_REFERENCE = 'joueur';
    public function load(ObjectManager $manager): void
    {
        // Liste des références de placements créées dans PlacementFixtures
        $placementReferences = [
            "placement_gardien",
            "placement_defenseur_central",
            "placement_lateral_droit",
            "placement_lateral_gauche",
            "placement_milieu_defensif",
            "placement_milieu_central",
            "placement_milieu_offensif",
            "placement_ailier_droit",
            "placement_ailier_gauche",
            "placement_attaquant",
            "placement_buteur",
            "placement_millieur_defensif_central",
        ];

        // Création des joueurs avec leur placement
        $joueursData = [
            ['nom' => 'Donnarumma', 'prenom' => 'Gianluigi', 'placement' => 'placement_gardien'],
            ['nom' => 'Hakimi', 'prenom' => 'Achraf', 'placement' => 'placement_lateral_droit'],
            ['nom' => 'Hernandez', 'prenom' => 'Lucas', 'placement' => 'placement_lateral_gauche'],
            ['nom' => 'Zaïre-Emery', 'prenom' => 'Warren', 'placement' => 'placement_milieu_central'],
            ['nom' => 'Ugarte', 'prenom' => 'Manuel', 'placement' => 'placement_milieu_defensif'],
            ['nom' => 'Dembélé', 'prenom' => 'Ousmane', 'placement' => 'placement_ailier_droit'],
            ['nom' => 'Barcola', 'prenom' => 'Bradley', 'placement' => 'placement_ailier_gauche'],
            ['nom' => 'Gonçalo', 'prenom' => 'Ramos', 'placement' => 'placement_attaquant'],
        ];

        $i = 1;

        foreach ($joueursData as $data) {
            $joueur = new Joueur();
            $joueur->setNom($data['nom']);
            $joueur->setPrenom($data['prenom']);
            $joueur->addPlacement($this->getReference($data['placement'], Placement::class));
            $manager->persist($joueur);
            $this->addReference('joueur-'.$i, $joueur);
            $i++;
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            PlacementFixtures::class,
        ];
    }
}
