# blind-test-ceri

Ce README vous détaillera l'ensemble des commandes et procédure à suivre lors du développement sous symfony.

## Etapes à suivre lors du clonage du repo sur une nouvelle machine :

```sh
composer install
yarn install
yarn install -- force
composer dump-env dev
```
## Fichier .env

Le fichier .env contient un ensemble de vriables d'environnements dans notre application. Dans un soucis de sécurité ils vous est 
demandé de créer un fichier .env.dev
C'est dans ce dernier que vous écrirais les variables d'environnements propre à votre machine.

A chaques modification de ce fichier il est nécessaire de rentrer la fonction

```sh
composer dump-env dev
```

## Ajouter des librairies JS

Il suffit d'utilliser la commande yarn add suivi du nom du paquet

```js
yarn add bootstrap
```

## Ajouter des bundle php / Symfony

Il suffit d'utilliser la commande composer requiere suivi du nom du paquet

```sh
composer requiere symfony/ux-react
```

## Modification structurelle obligatoire

Afin de pouvoir uploader des fichiers il vous faudra créer les dossiers ```uploads/avatars/``` et ```uploads/musiques/``` à la racine du dossier ```public/``` soit: ```public/uploads/avatars``` et ```public/uploads/musiques``` 

## Lancer le serveur de développement

Afin de lancer le serveur de développement il vous faudra deux terminaux dont le répertoire courant est celui du projet.
Il vous suffira ensuite de saisir les commandes suivantes:

```sh
symfony server:start
yarn watch
```

### *** ATTENTION ***

En cas de modification du fichier webpack.config.js, il est obligatoire de stopper puis relancer la commande ***yarn watch***

## Liste non exhaustive des commandes utiles

Création d'un controller et de son template: 
```sh
php bin/console make:controller
```

Création d'une entité et de son repository:
```sh
php bin/console make:entity
```

Modification de la base de données suite à une modification des entités:
```sh
php bin/console make:migration
php bin/console migration:migrate
```

Modification de la base de données sans création de migration:
```sh
php bin/console d:s:u --force
```

## Configuraiton de php

***Afin de foncitonner votre serveur php doit impérativement avoir une configuration valide***

Pour ce faire, chercher le répertoire d'installation de php, choisissez une version supérieur ou égale à 8.1

Ouvrez le fichier ```php.ini``` puis cherchez POST_MAX_FILESIZE et UPLOAD_MAX_FILESIZE.

Changer les valeurs pour qu'elles soient suopérieurs ou égales à 10M

## Utilisation du projet

Pour utiliser ce projet il vous faudra vous créer un compte depuis la page de login.

Une fois le compte créé il vous faudra depuis la base de données ajouter ```ROLE_ADMIN``` à la colone roles de la table utilisateurs

Une fois sur la page d'acceuil cliquez sur le bouton Ajouter des thèmes puis ajouter les différents thèmes voulu pour vos musiques

Retouner à l'acceuil puis allez sur Importer des musiques.

Ajouter des musiques, les données minimum requises sont 1 thème, 1 titre, une date de parution antérieur à la date du jour et un fichier mp3.

Une fois le nombre voulu de musiques importées retournez à la page d'acceuil puis cliquez sur "Nouvelle partie"

Choisissez le ou les thèmes de la parties, sa difficulté les tags pour ajoter des musique spécifiques et le nombre de musiques souhaité.

Pour rappel : 
- Facile = 20 secondes
- Moyen (default) = 15 secondes
- Defficile = 10 secondes
