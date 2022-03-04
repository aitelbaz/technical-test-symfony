Projet Test technique Symfony api

## Environneemnt de développement

### Pré-requis

* PHP 8.0.13
* Composer 2.1.14
* Symfony CLI
* Docker
* Docker-compose

Vous pouvez vérifier les pré-requis (sauf Docker et Docker-compose) avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirements
```

### Démarrer le container Docker 
```bash
cd docker
docker-compose up -d
cd ..
```

### Installer VENDOR && SSL JWT et créer les tables dans la base de donnée 


```
composer install
php bin/console lexie:jwt:generate-keypair
php bin/console doctrine:migrations:migrate
```


### Acceder au documentation API
http://localhost/api/docs

### Info sur authentification
Le projet utilise JWT Token et pour accéder au different route vous devez passer par Autorization : Bearer Token 
