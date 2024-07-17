# Gestion de Bar avec Symfony et API Platform

Ce projet consiste à créer une API de gestion de bar permettant de gérer les commandes, les utilisateurs (patrons, barmans, serveurs) et les boissons. L'API est développée en utilisant Symfony et API Platform, et les tests peuvent être effectués avec Postman.

## Prérequis

- PHP >=8.1
- Composer
- MySQL ou tout autre SGBD compatible avec Doctrine
- Symfony CLI
- Postman (pour les tests)

## Installation

1. **Cloner le projet :**

   ```bash
   git clone https://github.com/Aliibraabbas/my_bar_api
   cd votre-projet

## Installer les dépendances :

 ```bash
   composer install
```
## Configurer la base de données :
Ouvrez le fichier .env et configurez la variable DATABASE_URL avec vos informations de base de données.

 ```bash
   DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

```

## Vous devrez également ajouter ceci dans le fichier .env.local :
    ###> lexik/jwt-authentication-bundle ###
    JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
    JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
    JWT_PASSPHRASE=d33f6835b4b0d14643b0355f5f3ae730bf541b63c3f222b12d749da3873dd41e
    ###< lexik/jwt-authentication-bundle ###

## Créer la base de données :

 ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrat
```

## Générer les clés JWT :
 ```bash
   composer require lexik/jwt-authentication-bundle
   php bin/console lexik:jwt:generate-keypair

```

## Running Project
    1.Démarrer le serveur de développement Symfony : symfony serve

    2.Accéder aux définitions des routes dans votre navigateur web à l'adresse http://localhost:8000/api.

    3.Importer la collection Postman depuis le dépôt pour tester les requêtes.

## Entités

   ### User (Patron, Serveur, Barman)
    username : string, unique 

    password : string 

    roles : array

### Boisson
    name : string

    price : float

    photo : relation OneToOne vers Media

### Commande
    createdAt : datetime 

    orderedDrinks : (relation ManyToMany vers Boisson)

    tableNumber : integer

    server : relation ManyToOne vers User

    barman : relation ManyToOne vers User

    status : string (en cours de préparation, prête, payée)


### Media
   path : string

## Routes et fonctionnalités

### Authentification
`Login : POST /login`
    
    Body:
    {
        "username": "patron",
        "password": "password"
    }

### Gestion des utilisateurs (Patron uniquement)
    Créer un utilisateur : POST /api/users

    Lister les utilisateurs : GET /api/users

    Voir un utilisateur : GET /api/users/{id}

    Mettre à jour un utilisateur : PUT /api/users/{id}

    Supprimer un utilisateur : DELETE /api/users/{id}

### Gestion des boissons (Barman)

    Créer une boisson : POST /api/boissons

    Lister les boissons : GET /api/boissons

    Voir une boisson : GET /api/boissons/{id}

    Mettre à jour une boisson : PUT /api/boissons/{id}

    Supprimer une boisson : DELETE /api/boissons/{id}

### Serveur
    Créer une commande : POST /api/commandes

    Voir les détails d'une commande : GET /api/commandes/{id}

    Mettre à jour une commande : PUT /api/commandes/{id}

    Enregistrer le paiement d'une commande : PATCH /api/commandes/{id}/pay

### Barman
    Lister les commandes en cours : GET /api/commandes?status=en cours de préparation

    Voir les détails d'une commande : GET /api/commandes/{id}

    Attribuer une commande : PATCH /api/commandes/{id}/assign

    Mettre à jour le status d'une commande : PATCH /api/commandes/{id}/status

## Utilisation avec Postman
    1.Créer une collection Postman pour organiser vos requêtes.

    2.Ajouter une requête pour chaque fonctionnalité mentionnée ci-dessus.

    3.Configurer l'authentification en ajoutant le jeton JWT dans les en-têtes des requêtes nécessitant une authentification.



