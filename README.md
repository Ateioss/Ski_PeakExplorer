# Ski_PeakExplorer
A synfony based website about winter sports

## Initialisation

Pour initialisé

faire un ``` composer install``` pour installé tout les composants nécessaire au projet

faire un ``` npm install ``` pour installé SASS

Copié le .env pour créé un .env.local et dans ce dernier remplacé ``` # DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4" ```
par le nom de votre base de donné


Faire un ``` php bin/console doctrine:database:create ``` pour créé la database

Faire un ``` php bin/console make:migration ``` pour initialisé une migration puis la migré avec la commande suivant

``` php bin/console doctrine:migrations:migrate``` ou ```php bin/console d:m:m ``` 

Ensuite pour importé les données pré-créer utiliser la commande suite 

``` php bin/console doctrine:fixtures:load```  ou  ``` php bin/console d:f:l```

Puis pour lancer le projet utilisé la commande suite 

``` symfony serve ```

Merci d'avoir visiter notre projet 
