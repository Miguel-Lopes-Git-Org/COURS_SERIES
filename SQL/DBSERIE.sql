-- ============================================================
-- SUPPRESSION DES TABLES
-- ============================================================

DROP TABLE IF EXISTS ATTACHER CASCADE;
DROP TABLE IF EXISTS DIFFUSER CASCADE;
DROP TABLE IF EXISTS SCENARISER CASCADE;
DROP TABLE IF EXISTS REALISER CASCADE;
DROP TABLE IF EXISTS PRODUIRE CASCADE;
DROP TABLE IF EXISTS CASTING CASCADE;
DROP TABLE IF EXISTS CHAINE CASCADE;
DROP TABLE IF EXISTS EPISODE CASCADE;
DROP TABLE IF EXISTS SAISON CASCADE;
DROP TABLE IF EXISTS SERIE CASCADE;
DROP TABLE IF EXISTS POSITION CASCADE;
DROP TABLE IF EXISTS GENRE CASCADE;
DROP TABLE IF EXISTS PERSONNAGE CASCADE;
DROP TABLE IF EXISTS USERS CASCADE;
DROP TABLE IF EXISTS PAYS CASCADE;
DROP TABLE IF EXISTS DOUBLEUR CASCADE;
DROP TABLE IF EXISTS ACTEUR CASCADE;
DROP TABLE IF EXISTS REALISATEUR CASCADE;
DROP TABLE IF EXISTS SCENARISTE CASCADE;
DROP TABLE IF EXISTS CREATEUR CASCADE;
DROP TABLE IF EXISTS PRODUCTEUR CASCADE;
DROP TABLE IF EXISTS PERSONNE CASCADE;

-- ============================================================
-- CRÉATION DES TABLES
-- ============================================================

CREATE TABLE PERSONNE(
   id_personne VARCHAR(50),
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   image_url_path VARCHAR(500),
   PRIMARY KEY(id_personne)
);

CREATE TABLE PRODUCTEUR(
   id_producteur VARCHAR(50),
   PRIMARY KEY(id_producteur),
   FOREIGN KEY(id_producteur) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE CREATEUR(
   id_createur VARCHAR(50),
   PRIMARY KEY(id_createur),
   FOREIGN KEY(id_createur) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE SCENARISTE(
   id_scenariste VARCHAR(50),
   PRIMARY KEY(id_scenariste),
   FOREIGN KEY(id_scenariste) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE REALISATEUR(
   id_realisateur VARCHAR(50),
   PRIMARY KEY(id_realisateur),
   FOREIGN KEY(id_realisateur) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE ACTEUR(
   id_acteur VARCHAR(50),
   PRIMARY KEY(id_acteur),
   FOREIGN KEY(id_acteur) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE DOUBLEUR(
   id_doubleur VARCHAR(50),
   PRIMARY KEY(id_doubleur),
   FOREIGN KEY(id_doubleur) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE PAYS(
   id_pays VARCHAR(32),
   nom_pays VARCHAR(50) NOT NULL,
   code_iso VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_pays)
);

CREATE TABLE USERS(
   id_user VARCHAR(50),
   email VARCHAR(100) NOT NULL UNIQUE,
   password VARCHAR(300) NOT NULL,
   firstName VARCHAR(50),
   lastName VARCHAR(50),
   streetAddress VARCHAR(100),
   zipCode VARCHAR(50),
   city VARCHAR(50),
   creditCardNumber VARCHAR(16),
   creditCardExpirationDate DATE,
   creditCardCVV VARCHAR(4),
   phoneNumber VARCHAR(10),
   PRIMARY KEY(id_user)
);

CREATE TABLE PERSONNAGE(
   id_personnage VARCHAR(50),
   desc_perso VARCHAR(2000),
   PRIMARY KEY(id_personnage),
   FOREIGN KEY(id_personnage) REFERENCES PERSONNE(id_personne)
);

CREATE TABLE GENRE(
   id_genre VARCHAR(32),
   libelle_genre VARCHAR(50) NOT NULL,
   code_genre INT NOT NULL,
   PRIMARY KEY(id_genre)
);

CREATE TABLE POSITION(
   id_position VARCHAR(32),
   lib_position VARCHAR(200) NOT NULL,
   PRIMARY KEY(id_position)
);

CREATE TABLE SERIE(
   id_serie SERIAL,
   titreVF VARCHAR(100) NOT NULL,
   nb_saisons INT CHECK (nb_saisons > 0),
   titreVO VARCHAR(100),
   description VARCHAR(2000),
   date_creation DATE NOT NULL,
   image_url_path VARCHAR(500),
   video_path_url VARCHAR(500),
   banner_path_url VARCHAR(500),
   musique_generique VARCHAR(200),
   slug VARCHAR(100) NOT NULL UNIQUE,
   id_pays VARCHAR(32) NOT NULL,
   id_createur VARCHAR(50) NOT NULL,
   id_genre VARCHAR(32) NOT NULL,
   PRIMARY KEY(id_serie),
   FOREIGN KEY(id_pays) REFERENCES PAYS(id_pays),
   FOREIGN KEY(id_createur) REFERENCES CREATEUR(id_createur),
   FOREIGN KEY(id_genre) REFERENCES GENRE(id_genre),
   CHECK (EXTRACT(YEAR FROM date_creation) > 0 AND EXTRACT(YEAR FROM date_creation) < EXTRACT(YEAR FROM CURRENT_DATE))
);

CREATE TABLE SAISON(
   id_serie INT,
   id_saison INT CHECK (id_saison > 0),
   nb_episodes INT,
   date_debut_tournage DATE,
   date_fin_tournage DATE,
   PRIMARY KEY(id_serie, id_saison),
   FOREIGN KEY(id_serie) REFERENCES SERIE(id_serie),
   CHECK (nb_episodes > 0),
   CHECK (date_debut_tournage < date_fin_tournage)
);

CREATE TABLE EPISODE(
   id_serie INT,
   id_saison INT,
   id_episode INT,
   titre_vo VARCHAR(100),
   date_diff_original DATE,
   date_diff_fr VARCHAR(50),
   titre_fr VARCHAR(100) NOT NULL,
   image_url_path VARCHAR(500),
   duree INT,
   description VARCHAR(2000),
   PRIMARY KEY(id_serie, id_saison, id_episode),
   FOREIGN KEY(id_serie, id_saison) REFERENCES SAISON(id_serie, id_saison)
);

CREATE TABLE CHAINE(
   id_chaine VARCHAR(50),
   nom_chaine VARCHAR(50) NOT NULL,
   numero_chaine INT,
   id_pays VARCHAR(32) NOT NULL,
   PRIMARY KEY(id_chaine),
   FOREIGN KEY(id_pays) REFERENCES PAYS(id_pays)
);

CREATE TABLE CASTING(
   id_serie INT,
   id_saison INT,
   id_episode INT,
   id_personnage VARCHAR(50),
   is_guest_star BOOLEAN,
   id_doubleur VARCHAR(50) NOT NULL,
   id_acteur VARCHAR(50),
   PRIMARY KEY(id_serie, id_saison, id_episode, id_personnage),
   FOREIGN KEY(id_serie, id_saison, id_episode) REFERENCES EPISODE(id_serie, id_saison, id_episode),
   FOREIGN KEY(id_personnage) REFERENCES PERSONNAGE(id_personnage),
   FOREIGN KEY(id_doubleur) REFERENCES DOUBLEUR(id_doubleur),
   FOREIGN KEY(id_acteur) REFERENCES ACTEUR(id_acteur)
);

CREATE TABLE PRODUIRE(
   id_serie INT,
   id_saison INT,
   id_producteur VARCHAR(50),
   PRIMARY KEY(id_serie, id_saison, id_producteur),
   FOREIGN KEY(id_serie, id_saison) REFERENCES SAISON(id_serie, id_saison),
   FOREIGN KEY(id_producteur) REFERENCES PRODUCTEUR(id_producteur)
);

CREATE TABLE REALISER(
   id_realisateur VARCHAR(50),
   id_serie INT,
   id_saison INT,
   id_episode INT,
   PRIMARY KEY(id_realisateur, id_serie, id_saison, id_episode),
   FOREIGN KEY(id_realisateur) REFERENCES REALISATEUR(id_realisateur),
   FOREIGN KEY(id_serie, id_saison, id_episode) REFERENCES EPISODE(id_serie, id_saison, id_episode)
);

CREATE TABLE SCENARISER(
   id_scenariste VARCHAR(50),
   id_serie INT,
   id_saison INT,
   id_episode INT,
   PRIMARY KEY(id_scenariste, id_serie, id_saison, id_episode),
   FOREIGN KEY(id_scenariste) REFERENCES SCENARISTE(id_scenariste),
   FOREIGN KEY(id_serie, id_saison, id_episode) REFERENCES EPISODE(id_serie, id_saison, id_episode)
);

CREATE TABLE DIFFUSER(
   id_serie INT,
   id_chaine VARCHAR(50),
   PRIMARY KEY(id_serie, id_chaine),
   FOREIGN KEY(id_serie) REFERENCES SERIE(id_serie),
   FOREIGN KEY(id_chaine) REFERENCES CHAINE(id_chaine)
);

CREATE TABLE ATTACHER(
   id_personnage VARCHAR(50),
   id_position VARCHAR(32),
   PRIMARY KEY(id_personnage, id_position),
   FOREIGN KEY(id_personnage) REFERENCES PERSONNAGE(id_personnage),
   FOREIGN KEY(id_position) REFERENCES POSITION(id_position)
);




