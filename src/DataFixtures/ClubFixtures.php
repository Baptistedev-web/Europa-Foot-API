<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Club;
use App\Entity\Pays;
use App\DataFixtures\PaysFixtures;

class ClubFixtures extends Fixture implements DependentFixtureInterface
{
    public const CLUB_REFERENCE = 'club';

    public function load(ObjectManager $manager): void
    {
        // Monaco membre de la Ligue 1 mais Pays Monaco
        $monaco = new Club();
        $monaco->setNom("AS Monaco");
        $monaco->setStade("Stade Louis II");
        $monaco->setPays($this->getReference("pays_Monaco", Pays::class));
        $manager->persist($monaco);
        $this->addReference('club-AS Monaco', $monaco);

        // --- France : Ligue 1 & Ligue 2 (2023-2024 et 2024-2025) ---
        $clubsFrance = [
            ["Paris Saint-Germain", "Parc des Princes"],
            ["Olympique de Marseille", "Stade Vélodrome"],
            ["Stade Rennais", "Roazhon Park"],
            ["OGC Nice", "Allianz Riviera"],
            ["RC Lens", "Stade Bollaert-Delelis"],
            ["LOSC Lille", "Stade Pierre-Mauroy"],
            ["Olympique Lyonnais", "Groupama Stadium"],
            ["FC Nantes", "Stade de la Beaujoire"],
            ["Montpellier HSC", "Stade de la Mosson"],
            ["RC Strasbourg", "Stade de la Meinau"],
            ["Stade de Reims", "Stade Auguste-Delaune"],
            ["Toulouse FC", "Stadium de Toulouse"],
            ["FC Lorient", "Stade du Moustoir"],
            ["Stade Brestois", "Stade Francis-Le Blé"],
            ["Clermont Foot", "Stade Gabriel Montpied"],
            ["Le Havre AC", "Stade Océane"],
            ["FC Metz", "Stade Saint-Symphorien"],
            ["Stade Malherbe Caen", "Stade Michel d'Ornano"],
            ["Grenoble Foot 38", "Stade des Alpes"],
            ["AJ Auxerre", "Stade de l'Abbé-Deschamps"],
            ["Angers SCO", "Stade Raymond-Kopa"],
            ["AS Saint-Étienne", "Stade Geoffroy-Guichard"],
            ["Amiens SC", "Stade de la Licorne"],
            ["SC Bastia", "Stade Armand-Cesari"],
            ["EA Guingamp", "Stade du Roudourou"],
            ["USL Dunkerque", "Stade Marcel-Tribut"],
            ["Paris FC", "Stade Sébastien Charléty"],
            ["Pau FC", "Nouste Camp"],
            ["US Quevilly-Rouen", "Stade Robert-Diochon"],
            ["Rodez AF", "Stade Paul-Lignon"],
            ["Valenciennes FC", "Stade du Hainaut"],
            ["FC Annecy", "Parc des Sports"],
            ["Bordeaux", "Matmut Atlantique"],
            ["Concarneau", "Stade Guy Piriou"],
            ["Laval", "Stade Francis Le Basser"],
            ["Nîmes Olympique", "Stade des Costières"],
            ["Niort", "Stade René-Gaillard"],
            ["Sochaux", "Stade Auguste-Bonal"],
            ["Troyes AC", "Stade de l'Aube"],
            ["Dijon FCO", "Stade Gaston-Gérard"],
            ["Châteauroux", "Stade Gaston Petit"],
        ];

        foreach ($clubsFrance as $data) {
            $club = new Club();
            $club->setNom($data[0]);
            $club->setStade($data[1]);
            $club->setPays($this->getReference("pays_France", Pays::class));
            $manager->persist($club);
            $this->addReference('club-' . $data[0], $club);
        }

        // ---Allemagne : Bundesliga & 2. Bundesliga (2023-2024 et 2024-2025) ---
        $clubsAllemagne = [
            ["Bayern Munich", "Allianz Arena"],
            ["Borussia Dortmund", "Signal Iduna Park"],
            ["RB Leipzig", "Red Bull Arena"],
            ["Bayer Leverkusen", "BayArena"],
            ["VfL Wolfsburg", "Volkswagen Arena"],
            ["Eintracht Francfort", "Deutsche Bank Park"],
            ["Borussia Mönchengladbach", "Borussia-Park"],
            ["SC Freiburg", "Europa-Park Stadion"],
            ["VfB Stuttgart", "Mercedes-Benz Arena"],
            ["1. FC Union Berlin", "Stadion An der Alten Försterei"],
            ["Werder Brême", "Wohninvest Weserstadion"],
            ["FSV Mayence", "Opel Arena"],
            ["FC Augsbourg", "WWK Arena"],
            ["TSG Hoffenheim", "PreZero Arena"],
            ["VfL Bochum", "Vonovia Ruhrstadion"],
            ["1. FC Heidenheim", "Voith-Arena"],
            ["Darmstadt 98", "Merck-Stadion am Böllenfalltor"],
            ["1. FC Köln", "RheinEnergieStadion"],
            ["Hambourg SV", "Volksparkstadion"],
            ["Hannover 96", "HDI-Arena"],
            ["Hertha Berlin", "Olympiastadion Berlin"],
            ["Fortuna Düsseldorf", "Merkur Spiel-Arena"],
            ["FC St. Pauli", "Millerntor-Stadion"],
            ["1. FC Nuremberg", "Max-Morlock-Stadion"],
            ["Karlsruher SC", "BBBank Wildpark"],
            ["SC Paderborn", "Benteler-Arena"],
            ["Holstein Kiel", "Holstein-Stadion"],
            ["Greuther Fürth", "Sportpark Ronhof Thomas Sommer"],
            ["1. FC Kaiserslautern", "Fritz-Walter-Stadion"],
            ["Hansa Rostock", "Ostseestadion"],
            ["SV Elversberg", "Ursapharm-Arena"],
            ["Eintracht Braunschweig", "Eintracht-Stadion"],
            ["1. FC Magdebourg", "MDCC-Arena"],
            ["SV Wehen Wiesbaden", "BRITA-Arena"],
            ["VfL Osnabrück", "Bremer Brücke"],
            ["FC Schalke 04", "Veltins-Arena"],
        ];
        foreach ($clubsAllemagne as $data) {
            $club = new Club();
            $club->setNom($data[0]);
            $club->setStade($data[1]);
            $club->setPays($this->getReference("pays_Allemagne", Pays::class));
            $manager->persist($club);
            $this->addReference('club-' . $data[0], $club);
        }

        // ---Italie : Serie A & Serie B (2023-2024 et 2024-2025) ---
        $clubsItalie = [
            ["Inter Milan", "San Siro"],
            ["AC Milan", "San Siro"],
            ["Juventus", "Allianz Stadium"],
            ["AS Rome", "Stadio Olimpico"],
            ["Naples", "Stadio Diego Armando Maradona"],
            ["Atalanta", "Gewiss Stadium"],
            ["Lazio Rome", "Stadio Olimpico"],
            ["Fiorentina", "Stadio Artemio Franchi"],
            ["Bologne", "Stadio Renato Dall'Ara"],
            ["Torino", "Stadio Olimpico Grande Torino"],
            ["Genoa", "Stadio Luigi Ferraris"],
            ["Cagliari", "Unipol Domus"],
            ["Sassuolo", "Mapei Stadium"],
            ["Udinese", "Dacia Arena"],
            ["Empoli", "Stadio Carlo Castellani"],
            ["Lecce", "Stadio Via del Mare"],
            ["Frosinone", "Stadio Benito Stirpe"],
            ["Hellas Vérone", "Stadio Marcantonio Bentegodi"],
            ["Parme", "Stadio Ennio Tardini"],
            ["Cremonese", "Stadio Giovanni Zini"],
            ["Catanzaro", "Stadio Nicola Ceravolo"],
            ["Palermo", "Stadio Renzo Barbera"],
            ["Venezia", "Stadio Pierluigi Penzo"],
            ["Sampdoria", "Stadio Luigi Ferraris"],
            ["Bari", "Stadio San Nicola"],
            ["Brescia", "Stadio Mario Rigamonti"],
            ["Cosenza", "Stadio San Vito-Gigi Marulla"],
            ["Modène", "Stadio Alberto Braglia"],
            ["Pisa", "Arena Garibaldi"],
            ["Reggiana", "Mapei Stadium"],
            ["Spezia", "Stadio Alberto Picco"],
            ["Sudtirol", "Stadio Druso"],
            ["Ternana", "Stadio Libero Liberati"],
            ["Ascoli", "Stadio Cino e Lillo Del Duca"],
            ["Como", "Stadio Giuseppe Sinigaglia"],
            ["Lecco", "Stadio Rigamonti-Ceppi"],
        ];
        foreach ($clubsItalie as $data) {
            $club = new Club();
            $club->setNom($data[0]);
            $club->setStade($data[1]);
            $club->setPays($this->getReference("pays_Italie", Pays::class));
            $manager->persist($club);
            $this->addReference('club-' . $data[0], $club);
        }

        // --- ESPAGNE : La Liga & La Liga 2 (2023-2024 et 2024-2025) ---
        $clubsEspagne = [
            ["Real Madrid", "Santiago Bernabéu"],
            ["FC Barcelone", "Estadi Olímpic Lluís Companys"],
            ["Atlético de Madrid", "Cívitas Metropolitano"],
            ["Girona FC", "Estadi Montilivi"],
            ["Athletic Bilbao", "San Mamés"],
            ["Real Sociedad", "Reale Arena"],
            ["Real Betis", "Estadio Benito Villamarín"],
            ["Valence CF", "Mestalla"],
            ["Villarreal CF", "Estadio de la Cerámica"],
            ["Osasuna", "El Sadar"],
            ["Getafe CF", "Coliseum Alfonso Pérez"],
            ["UD Las Palmas", "Estadio Gran Canaria"],
            ["Deportivo Alavés", "Mendizorrotza"],
            ["Rayo Vallecano", "Estadio de Vallecas"],
            ["Séville FC", "Ramón Sánchez-Pizjuán"],
            ["Celta Vigo", "Abanca-Balaídos"],
            ["RCD Majorque", "Visit Mallorca Estadi"],
            ["Cádiz CF", "Nuevo Mirandilla"],
            ["Granada CF", "Nuevo Los Cármenes"],
            ["UD Almería", "Power Horse Stadium"],
            ["Espanyol Barcelone", "RCDE Stadium"],
            ["Real Valladolid", "Estadio José Zorrilla"],
            ["Eibar", "Ipurua"],
            ["Elche CF", "Martínez Valero"],
            ["Levante UD", "Ciutat de València"],
            ["Real Oviedo", "Carlos Tartiere"],
            ["Racing Santander", "El Sardinero"],
            ["Real Zaragoza", "La Romareda"],
            ["Burgos CF", "El Plantío"],
            ["CD Tenerife", "Heliodoro Rodríguez López"],
            ["FC Cartagena", "Cartagonova"],
            ["SD Huesca", "El Alcoraz"],
            ["Albacete Balompié", "Carlos Belmonte"],
            ["CD Mirandés", "Anduva"],
            ["Villarreal B", "Mini Estadi"],
            ["AD Alcorcón", "Santo Domingo"],
            ["SD Amorebieta", "Urritxe"],
            ["FC Andorra", "Estadi Nacional"],
            ["Eldense", "Nuevo Pepico Amat"],
            ["Sporting Gijón", "El Molinón"],
            ["Leganés", "Butarque"],
            ["Racing Ferrol", "A Malata"],
        ];
        foreach ($clubsEspagne as $data) {
            $club = new Club();
            $club->setNom($data[0]);
            $club->setStade($data[1]);
            $club->setPays($this->getReference("pays_Espagne", Pays::class));
            $manager->persist($club);
            $this->addReference('club-' . $data[0], $club);
        }

        // --- ANGLETERRE : Premier League & Championship (2023-2024 et 2024-2025) ---
        $clubsAngleterre = [
            // Premier League 2023-2024
            ["Arsenal", "Emirates Stadium"],
            ["Aston Villa", "Villa Park"],
            ["Bournemouth", "Vitality Stadium"],
            ["Brentford", "Gtech Community Stadium"],
            ["Brighton & Hove Albion", "Amex Stadium"],
            ["Burnley", "Turf Moor"],
            ["Chelsea", "Stamford Bridge"],
            ["Crystal Palace", "Selhurst Park"],
            ["Everton", "Goodison Park"],
            ["Fulham", "Craven Cottage"],
            ["Liverpool", "Anfield"],
            ["Luton Town", "Kenilworth Road"],
            ["Manchester City", "Etihad Stadium"],
            ["Manchester United", "Old Trafford"],
            ["Newcastle United", "St James' Park"],
            ["Nottingham Forest", "City Ground"],
            ["Sheffield United", "Bramall Lane"],
            ["Tottenham Hotspur", "Tottenham Hotspur Stadium"],
            ["West Ham United", "London Stadium"],
            ["Wolverhampton Wanderers", "Molineux Stadium"],
            ["Birmingham City", "St Andrew's"],
            ["Blackburn Rovers", "Ewood Park"],
            ["Bristol City", "Ashton Gate"],
            ["Cardiff City", "Cardiff City Stadium"],
            ["Coventry City", "Coventry Building Society Arena"],
            ["Huddersfield Town", "John Smith's Stadium"],
            ["Hull City", "MKM Stadium"],
            ["Ipswich Town", "Portman Road"],
            ["Leeds United", "Elland Road"],
            ["Leicester City", "King Power Stadium"],
            ["Middlesbrough", "Riverside Stadium"],
            ["Millwall", "The Den"],
            ["Norwich City", "Carrow Road"],
            ["Plymouth Argyle", "Home Park"],
            ["Preston North End", "Deepdale"],
            ["Queens Park Rangers", "Loftus Road"],
            ["Rotherham United", "New York Stadium"],
            ["Southampton", "St Mary's Stadium"],
            ["Stoke City", "bet365 Stadium"],
            ["Sunderland", "Stadium of Light"],
            ["Swansea City", "Swansea.com Stadium"],
            ["Watford", "Vicarage Road"],
            ["West Bromwich Albion", "The Hawthorns"],
            ["Sheffield Wednesday", "Hillsborough"],
        ];
        foreach ($clubsAngleterre as $data) {
            $club = new Club();
            $club->setNom($data[0]);
            $club->setStade($data[1]);
            $club->setPays($this->getReference("pays_Angleterre", Pays::class));
            $manager->persist($club);
            $this->addReference('club-' . $data[0], $club);
        }

        // --- Clubs européens hors FR/DE/EN/IT/ES ayant participé aux coupes européennes ---
        $clubsEuropeensHors5 = [
            // Portugal
            ["FC Porto", "Estádio do Dragão", "Portugal"],
            ["Benfica Lisbonne", "Estádio da Luz", "Portugal"],
            ["Sporting CP", "Estádio José Alvalade", "Portugal"],
            ["Sporting Braga", "Estádio Municipal de Braga", "Portugal"],
            // Pays-Bas
            ["Ajax Amsterdam", "Johan Cruyff Arena", "Pays-Bas"],
            ["PSV Eindhoven", "Philips Stadion", "Pays-Bas"],
            ["Feyenoord Rotterdam", "De Kuip", "Pays-Bas"],
            ["AZ Alkmaar", "AFAS Stadion", "Pays-Bas"],
            // Belgique
            ["Club Bruges", "Jan Breydelstadion", "Belgique"],
            ["Royal Antwerp FC", "Bosuilstadion", "Belgique"],
            ["RSC Anderlecht", "Lotto Park", "Belgique"],
            ["KRC Genk", "Cegeka Arena", "Belgique"],
            // Écosse
            ["Celtic Glasgow", "Celtic Park", "Ecosse"],
            ["Rangers FC", "Ibrox Stadium", "Ecosse"],
            // Turquie
            ["Galatasaray", "Türk Telekom Stadium", "Turquie"],
            ["Fenerbahçe", "Ülker Stadyumu", "Turquie"],
            ["Beşiktaş", "Vodafone Park", "Turquie"],
            // Grèce
            ["Olympiakos", "Stade Georgios Karaiskakis", "Grece"],
            ["AEK Athènes", "Stade OACA Spyros Louis", "Grece"],
            ["PAOK Salonique", "Stade Toumba", "Grece"],
            // Russie
            ["Zenit Saint-Pétersbourg", "Gazprom Arena", "Russie"],
            ["CSKA Moscou", "VEB Arena", "Russie"],
            ["Spartak Moscou", "Otkrytie Arena", "Russie"],
            // Ukraine
            ["Dynamo Kiev", "Stade olympique de Kiev", "Ukraine"],
            ["Chakhtar Donetsk", "Stade Oblasny SportKomplex Metalist", "Ukraine"],
            // Autriche
            ["RB Salzbourg", "Red Bull Arena", "Autriche"],
            ["Rapid Vienne", "Allianz Stadion", "Autriche"],
            // Suisse
            ["FC Bâle", "Stade de Genève", "Suisse"],
        ];

        foreach ($clubsEuropeensHors5 as $data) {
            $club = new Club();
            $club->setNom($data[0]);
            $club->setStade($data[1]);
            $club->setPays($this->getReference("pays_" . $data[2], Pays::class));
            $manager->persist($club);
            $this->addReference('club-' . $data[0], $club);
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            PaysFixtures::class,
        ];
    }
}
