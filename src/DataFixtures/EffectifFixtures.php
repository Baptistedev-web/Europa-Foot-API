<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Effectif;
use App\Entity\ClubCompetitionSaison;
use App\Entity\Joueur;


class EffectifFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Liste des références de joueurs créées dans JoueurFixtures
        $joueurReferences = [
            'joueur-1', // Gianluigi Donnarumma
            'joueur-2', // Achraf Hakimi
            'joueur-3', // Lucas Hernandez
            'joueur-4', // Warren Zaïre-Emery
            'joueur-5', // Manuel Ugarte
            'joueur-6', // Ousmane Dembélé
            'joueur-7', // Bradley Barcola
            'joueur-8', // Gonçalo Ramos
        ];

        // Liste des références de clubs et saisons créées dans ClubCompetitionSaisonFixtures
        $clubCompetitionSaisonReferences = [
            'club-competition-saison-2', // Paris Saint-Germain 2024/2025
        ];

        foreach ($clubCompetitionSaisonReferences as $clubCompetitionSaisonRef) {
            foreach ($joueurReferences as $joueurRef) {
                $effectif = new Effectif();
                $effectif->setNumero(rand(1, 99)); // Numéro de maillot aléatoire entre 1 et 99
                $effectif->setClubSaison($this->getReference($clubCompetitionSaisonRef, ClubCompetitionSaison::class));
                $effectif->setJoueur($this->getReference($joueurRef, Joueur::class));
                $manager->persist($effectif);
            }
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            JoueurFixtures::class,
            ClubCompetitionSaisonFixtures::class,
        ];
    }
}
