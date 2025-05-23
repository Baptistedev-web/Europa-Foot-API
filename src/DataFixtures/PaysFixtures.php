<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Pays;

class PaysFixtures extends Fixture
{
    public const PAYS_REFERENCE = 'pays';
    public function load(ObjectManager $manager): void
    {
        // Tableau des pays européens et leur référence
        $paysList = [
            ['France', 'pays_France'],
            ['Allemagne', 'pays_Allemagne'],
            ['Espagne', 'pays_Espagne'],
            ['Italie', 'pays_Italie'],
            ['Angleterre', 'pays_Angleterre'],
            ['Monaco', 'pays_Monaco'],
            ['Belgique', 'pays_Belgique'],
            ['Suisse', 'pays_Suisse'],
            ['Portugal', 'pays_Portugal'],
            ['Pays-Bas', 'pays_Pays-Bas'],
            ['Danemark', 'pays_Danemark'],
            ['Suède', 'pays_Suede'],
            ['Norvège', 'pays_Norvege'],
            ['Finlande', 'pays_Finlande'],
            ['Ukraine', 'pays_Ukraine'],
            ['Pologne', 'pays_Pologne'],
            ['République Tchèque', 'pays_Republique_Tcheque'],
            ['Slovénie', 'pays_Slovenie'],
            ['Slovaquie', 'pays_Slovaquie'],
            ['Hongrie', 'pays_Hongrie'],
            ['Autriche', 'pays_Autriche'],
            ['Grèce', 'pays_Grece'],
            ['Croatie', 'pays_Croatie'],
            ['Serbie', 'pays_Serbie'],
            ['Bulgarie', 'pays_Bulgarie'],
            ['Roumanie', 'pays_Roumanie'],
            ['Albanie', 'pays_Albanie'],
            ['Monténégro', 'pays_Montenegro'],
            ['Kosovo', 'pays_Kosovo'],
            ['Andorre', 'pays_Andorre'],
            ['Biélorussie', 'pays_Bielorussie'],
            ['Bosnie-Herzégovine', 'pays_Bosnie_Herzegovine'],
            ['Chypre', 'pays_Chypre'],
            ['Estonie', 'pays_Estonie'],
            ['Irlande', 'pays_Irlande'],
            ['Islande', 'pays_Islande'],
            ['Lettonie', 'pays_Lettonie'],
            ['Liechtenstein', 'pays_Liechtenstein'],
            ['Lituanie', 'pays_Lituanie'],
            ['Luxembourg', 'pays_Luxembourg'],
            ['Macédoine du Nord', 'pays_Macedoine_du_Nord'],
            ['Malte', 'pays_Malte'],
            ['Moldavie', 'pays_Moldavie'],
            ['Saint-Marin', 'pays_Saint_Marin'],
            ['Vatican', 'pays_Vatican'],
            ['Écosse', 'pays_Ecosse'],
            ['Pays de Galles', 'pays_Pays_de_Galles'],
            ['Irlande du Nord', 'pays_Irlande_du_Nord'],
            ['Turquie', 'pays_Turquie'],
            ['Russie', 'pays_Russie'],
        ];

        foreach ($paysList as [$nom, $reference]) {
            $pays = new Pays();
            $pays->setNom($nom);
            $manager->persist($pays);
            $this->addReference($reference, $pays);
        }

        $manager->flush();
    }
}
