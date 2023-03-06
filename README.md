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

Afin de pouvoir uploader des fichiers il vous faudra créer les dossiers ```uploads/avatars/``` à la racine du dossier ```public/``` soit: ```public/uploads/avatars``` 

## Lancer le serveur de développement

Afin de lancer le serveur de développement il vous faudra deux terminaux dont le répertoire courant est celui du projet.
Il vous suffira ensuite de saisir les commandes suivantes:

```sh
symfony server:start
yarn watch
```

### *** ATTENTION ***

En cas de modification du fichier webpack.config.js, il est obligatoire de stopper puis relancer la commande ** yarn watch **

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
