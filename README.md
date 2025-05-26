** Pour mettre en place l'environnement

docker compose up -d --build

Puis aller sur le conteneur php et installer les bundles :
composer install

Ne pas oubliée de définir la passPhrase JWT avant de réaliser les commandes suivantes :
Supprimez la base de données existante (optionnel si vous souhaitez repartir de zéro) :  
php bin/console doctrine:database:drop --force
Créez une nouvelle base de données :  
php bin/console doctrine:database:create
Exécutez les migrations pour créer les tables :  
php bin/console doctrine:migrations:migrate
Chargez les fixtures :  
php bin/console doctrine:fixtures:load 