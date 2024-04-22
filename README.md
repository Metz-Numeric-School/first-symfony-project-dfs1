# Projet Symfony DFS Groupe 1

## Récupération du projet et lancement

```bash
git clone https://github.com/Metz-Numeric-School/first-symfony-project-dfs1
cd first-symfony-project-dfs1
composer install
symfony console doctrine:migration:migrate --no-interaction
```

## IMPORTANT

N'oubliez de créer votre fichier d'environnement local avant de lancer les installations

```.env
# .env.local
DATABASE_URL="mysql:{dbuser}:{dbpassword}@localhost:{mysqlport(3306|8889)}/{dbname}?serverVersion={serverVersion}&charset=utf8mb4"
```
