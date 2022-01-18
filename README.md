# CMS CLICK & CREATE 

Projet annuel permettant de créer un CMS from scratch sur le thème du click & collect.

Pour éviter de configurer votre serveur distant pour un test et que vous voulez simplement voir le résultat, il suffit de vous rendre sur http://www.mlkchess.fr:8080

Informations compte admin:
admin-test@gmail.com
Test1234

## Les fonctionnalités

Click & Create est CMS vous permettant de créer votre propre site d'e-commerce avec les produits de votre choix. 

### Pré-requis 

Pour pouvoir commencer avec notre projet, il vous faudra :

- Docker
- MySQL
- PHP
- Apache

### Installation 

Pour pouvoir installer notre projet, téléchargez le repository avec la commande git clone.

```
$ git clone https://github.com/mlk-chess/PA-CMS.git
```

Pour partager les données avec le conteneur mysql, il vous suffit de créer un dossier db_data :

```
$ cd PA-CMS && mkdir db_data && mkdir www/images/products
```

Puis tapez la commande suivante afin de créer les différents conteneurs :

```
$ docker compose up -d
```

## Démarrage du projet 

Pour lancer le projet, il faut tout simplement taper la commande :

```
$ docker compose up -d
```
et se diriger vers <nom_domain>:8080 sur votre navigateur.

Vous tomberez alors sur l'installeur du CMS pour initialiser toutes les données et les charger directement dans le fichier .env.
Il faudra changer l'adresse de la base de données en ```database```.

N'oubliez pas de créer la base de données avant ! (normalement, elle se crée automatiquement avec docker-compose)

<img width="700" alt="install" src="https://user-images.githubusercontent.com/32839831/127748501-7940c7b5-21e7-478f-88f0-ea1a06b00ea0.png">

Insérez ensuite les informations de votre magasin.

<img width="700" alt="magasin" src="https://user-images.githubusercontent.com/32839831/127748621-2ca0ad24-7e63-4361-b368-a5145bea9ed2.png">

Pour terminer l'installation, insérez les informations de l'administrateur.

<img width="700" alt="admin" src="https://user-images.githubusercontent.com/32839831/127748653-f0acdaf3-4cc9-4df9-a824-29aa8fef9da9.png">

Vous tomberez ensuite sur la page d'accueil !

<img width="900" alt="accueil" src="https://user-images.githubusercontent.com/32839831/127748709-fb102c97-da18-45a8-8078-3028334d55bd.png">

## Technologies

- PHP
- JAVASCRIPT / JQUERY
- HTML / CSS / SCSS
- DOCKER
