# Manuel technique - Projet SERIE

## 1. Objectif de l'application

L'application SERIE est une application web PHP permettant de consulter un catalogue de series, leurs saisons, leurs episodes, leurs personnages et les informations de diffusion. Elle inclut une authentification obligatoire, un espace profil utilisateur et une interface d'administration reservee aux comptes admin.

## 2. Infrastructure

Versions minimales recommandees :

- PHP 8.2 avec extensions `pdo`, `pdo_pgsql`, `pgsql`
- Apache 2 via l'image Docker `php:8.2-apache`
- PostgreSQL 13 ou superieur
- Navigateur recent compatible HTML5/CSS3
- Docker et Docker Compose pour l'execution locale

Le fichier `Dockerfile` construit le serveur PHP/Apache et installe les extensions PostgreSQL. Le fichier `docker-compose.yml` expose l'application sur le port `1000`.

## 3. Organisation MVC

Le projet suit une organisation MVC simple :

- `index.php` : point d'entree, demarrage de session, controle d'authentification et routage.
- `src/controllers/` : controleurs de pages. Ils recuperent les donnees via le modele puis chargent le template.
- `src/model.php` : couche d'acces aux donnees, connexion PDO, requetes de lecture, authentification et actions admin.
- `src/classes/` : classes metier utilisees par les vues publiques.
- `templates/` : vues PHP/HTML, layout commun, CSS et pages utilisateur/admin.
- `SQL/` : creation de la base, insertion de donnees et vues SQL.

## 4. Role des controleurs

- `ControllerPageLogin.php` : gere connexion et inscription.
- `ControllerPageSerie.php` : affiche la liste des series.
- `ControllerPageSerieDetail.php` : affiche la fiche d'une serie.
- `ControllerPageSaisonDetail.php` : affiche les episodes d'une saison.
- `ControllerPageEpisode.php` : affiche le detail d'un episode, personnages et equipe.
- `ControllerPageProfil.php` : affiche les informations du compte connecte.
- `ControllerPageAdmin.php` : verifie le role admin et pilote les CRUD.

## 5. Role des classes

- `SERIES` : donnees resumees d'une serie pour le catalogue.
- `SERIESDETAIL` : donnees detaillees d'une serie.
- `EPISODE` : donnees d'un episode.
- `Personne` et classes filles : createur, producteur, scenariste, realisateur, acteur, doubleur, personnage et guest star.
- `CHAINE` : chaine de diffusion.
- `Position` : position/role d'un personnage.
- `User` : representation des donnees utilisateur non bancaires.

## 6. Base de donnees

Les scripts SQL sont organises comme suit :

- `SQL/DBSERIE.sql` : suppression/creation des tables, contraintes, table d'audit et triggers de sauvegarde.
- `SQL/INSERT.sql` : donnees de demonstration.
- `SQL/VUES.sql` : vues utilisees par l'application et droits SQL.

Les donnees utilisateur sont stockees dans `USERS`. Le mot de passe est hache par PHP avec `password_hash`. Le role est stocke dans la colonne `role` avec les valeurs autorisees `user` et `admin`.

Les informations de carte bancaire et le CVV ne sont pas collectes par le formulaire d'inscription et ne sont pas stockes par l'application.

## 7. Securite

Mesures presentes :

- Authentification obligatoire pour les pages applicatives.
- Regeneration de l'identifiant de session apres connexion.
- Mot de passe hache avec empreinte unique.
- Verification de complexite du mot de passe : 12 caracteres minimum, majuscule, minuscule, chiffre et caractere special.
- Requetes SQL preparees pour les parametres utilisateur.
- Echappement HTML avec `htmlspecialchars` dans les templates.
- Separation fonctionnelle `user` / `admin`.
- Routes admin bloquees cote serveur pour les utilisateurs non admin.
- Triggers SQL de sauvegarde avant modification ou suppression.

La protection CSRF n'est pas implementee conformement a la consigne projet donnee.

## 8. Administration

Le premier compte inscrit devient automatiquement `admin` si la table `USERS` est vide. Les comptes suivants sont crees avec le role `user`.

L'admin peut gerer :

- series;
- saisons;
- episodes;
- personnages;
- creation d'un acteur/guest si le nom et le prenom sont renseignes.

Les actions admin sont accessibles via `index.php?action=admin`.

## 9. Installation locale

1. Creer le fichier `src/myParam.inc.php` avec les constantes suivantes :

```php
<?php
define('DB_HOST', 'nom_hote_postgresql');
define('DB_NAME', 'nom_base');
define('DB_USER', 'utilisateur');
define('DB_PASS', 'mot_de_passe');
```

2. Executer les scripts SQL dans cet ordre :

```text
SQL/DBSERIE.sql
SQL/INSERT.sql
SQL/VUES.sql
```

3. Lancer l'application :

```bash
docker compose up --build
```

4. Ouvrir :

```text
http://localhost:1000
```

## 10. Parcours de verification

1. Creer le premier compte : il devient admin.
2. Se connecter et verifier l'acces au catalogue.
3. Ouvrir le profil et verifier les donnees d'inscription.
4. Ouvrir l'admin et tester ajout/modification/suppression d'une serie, saison, episode et personnage.
5. Creer un second compte et verifier que le lien admin n'apparait pas.
6. Tenter `index.php?action=admin` avec le second compte : l'acces doit etre refuse.
