-- ============================================================
-- Vue Annexe 0 : Informations sur les utilisateurs
-- ============================================================

CREATE VIEW createUser AS
SELECT id_user, email, password, firstName, lastName,
       streetAddress, zipCode, city, phoneNumber, role
FROM USERS;

CREATE VIEW getUserInformations AS
SELECT firstName, lastName, email, password, streetAddress, zipCode, city, phoneNumber, role FROM USERS;

-- ============================================================
-- Vue Annexe 1 : Liste les détails d'une série
-- ============================================================

CREATE VIEW getAllSeries AS
SELECT
    se.titreVF,
    se.image_url_path,
    se.video_path_url,
    se.banner_path_url,
    se.musique_generique,
    se.slug,
    ge.libelle_genre,
    p.nom_pays AS pays_origine
FROM SERIE se
JOIN GENRE ge ON se.id_genre = ge.id_genre
JOIN PAYS p   ON se.id_pays  = p.id_pays;
    

CREATE VIEW getSerieDetails AS
SELECT
    se.titreVF,
    se.titreVO,
    se.slug,
    se.image_url_path,
    se.video_path_url,
    se.banner_path_url,
    se.description,
    se.musique_generique,
    se.date_creation,
    EXTRACT(YEAR FROM se.date_creation) AS annee_creation,
    se.nb_saisons,
    AVG(ep.duree) AS moyenne_duree_episodes,
    ge.libelle_genre,
    p.nom_pays AS pays_origine
FROM SERIE se
JOIN GENRE ge ON se.id_genre = ge.id_genre
JOIN PAYS p   ON se.id_pays  = p.id_pays
LEFT JOIN EPISODE ep ON se.id_serie = ep.id_serie
GROUP BY
    se.titreVF,
    se.titreVO,
    se.slug,
    se.image_url_path,
    se.video_path_url,
    se.banner_path_url,
    se.description,
    se.musique_generique,
    se.date_creation,
    se.nb_saisons,
    ge.libelle_genre,
    p.nom_pays;

-- Vue Annexe 1a : Créateur d'une série
CREATE VIEW getSerieCreateur AS
SELECT
    c.nom,
    c.prenom,
    se.slug
FROM SERIE se
JOIN CREATEUR cr ON se.id_createur = cr.id_createur
JOIN PERSONNE c  ON cr.id_createur = c.id_personne;

-- Vue Annexe 1b : Chaînes de diffusion d'une série
CREATE VIEW getSerieChaines AS
SELECT
    ch.nom_chaine,
    ch.numero_chaine,
    se.slug,
    pays_chaine.nom_pays AS pays,
    pays_chaine.code_iso AS code_iso
FROM SERIE se
JOIN DIFFUSER d       ON se.id_serie  = d.id_serie
JOIN CHAINE ch        ON d.id_chaine  = ch.id_chaine
JOIN PAYS pays_chaine ON ch.id_pays   = pays_chaine.id_pays;

-- ============================================================
-- Vue Annexe 2 : Liste des chaînes de télévision
-- ============================================================

CREATE VIEW getChaines AS
SELECT
    ch.nom_chaine,
    ch.numero_chaine,
    p.nom_pays AS pays
FROM CHAINE ch
JOIN PAYS p ON ch.id_pays = p.id_pays;

-- ============================================================
-- Vue Annexe 3 : Fiche d'une saison
-- ============================================================

CREATE VIEW getSaisonDetails AS
SELECT
    se.titreVF AS titre_serie,
    se.slug,
    se.image_url_path,
    se.banner_path_url,
    sa.id_saison,
    se.nb_saisons,
    sa.nb_episodes,
    sa.date_debut_tournage,
    ep.image_url_path AS episode_image_url_path,
    sa.date_fin_tournage,
    ep.id_episode,
    ep.titre_vo,
    ep.titre_fr,
    ep.date_diff_original AS date_diffusion_usa,
    ep.date_diff_fr       AS date_diffusion_fr,
    ep.description        AS resume
FROM SAISON sa
JOIN SERIE se   ON sa.id_serie = se.id_serie
JOIN EPISODE ep ON sa.id_serie = ep.id_serie AND sa.id_saison = ep.id_saison;

-- Vue Annexe 3a : Producteurs d'une saison
CREATE VIEW getSaisonProducteurs AS
SELECT
    sa.id_saison,
    p_prod.nom,
    p_prod.prenom,
    se.slug
FROM SAISON sa
JOIN SERIE se ON sa.id_serie = se.id_serie
LEFT JOIN PRODUIRE pr     ON sa.id_serie       = pr.id_serie AND sa.id_saison = pr.id_saison
LEFT JOIN PRODUCTEUR prod ON pr.id_producteur  = prod.id_producteur
LEFT JOIN PERSONNE p_prod ON prod.id_producteur = p_prod.id_personne;

-- ============================================================
-- Vue Annexe 4 : Fiche d'un épisode
-- ============================================================

CREATE VIEW getEpisodeDetails AS
SELECT
    se.titreVF AS titre_serie,
    se.slug,
    se.banner_path_url,
    se.nb_saisons,
    sa.id_saison,
    ep.id_episode,
    ep.titre_vo,
    ep.titre_fr,
    ep.image_url_path,
    ep.date_diff_original AS date_diffusion_usa,
    ep.date_diff_fr       AS date_diffusion_fr,
    ep.description        AS resume
FROM EPISODE ep
JOIN SAISON sa ON ep.id_serie = sa.id_serie AND ep.id_saison = sa.id_saison
JOIN SERIE se  ON ep.id_serie = se.id_serie;

-- Vue Annexe 4a : Scénaristes d'un épisode
CREATE VIEW getEpisodeScenaristes AS
SELECT
    p_sc.nom,
    p_sc.image_url_path,
    p_sc.prenom,
    se.slug,
    ep.id_saison,
    ep.id_episode
FROM SCENARISER sc
JOIN SCENARISTE scen ON sc.id_scenariste   = scen.id_scenariste
JOIN PERSONNE p_sc   ON scen.id_scenariste = p_sc.id_personne
JOIN EPISODE ep      ON sc.id_serie = ep.id_serie AND sc.id_saison = ep.id_saison AND sc.id_episode = ep.id_episode
JOIN SERIE se        ON ep.id_serie = se.id_serie;

-- Vue Annexe 4b : Réalisateurs d'un épisode
CREATE VIEW getEpisodeRealisateurs AS
SELECT
    p_re.nom,
    p_re.prenom,
    p_re.image_url_path,
    se.slug,
    ep.id_saison,
    ep.id_episode
FROM REALISER re
JOIN REALISATEUR real ON re.id_realisateur   = real.id_realisateur
JOIN PERSONNE p_re    ON real.id_realisateur = p_re.id_personne
JOIN EPISODE ep       ON re.id_serie = ep.id_serie AND re.id_saison = ep.id_saison AND re.id_episode = ep.id_episode
JOIN SERIE se         ON ep.id_serie = se.id_serie;

-- Vue Annexe 4c : Guest stars d'un épisode
CREATE VIEW getEpisodeGuestStars AS
SELECT
    p_act.nom          AS acteur_nom,
    p_act.prenom       AS acteur_prenom,
    perso_p.nom        AS personnage_nom,
    perso_p.prenom     AS personnage_prenom,
    perso_p.image_url_path,
    COALESCE(pos.lib_position, 'Guest Star') AS guest_position,
    se.slug,
    ep.id_saison,
    ep.id_episode
    
FROM CASTING ca
JOIN ACTEUR act       ON ca.id_acteur      = act.id_acteur
JOIN PERSONNE p_act   ON act.id_acteur     = p_act.id_personne
JOIN PERSONNAGE perso ON ca.id_personnage  = perso.id_personnage
JOIN PERSONNE perso_p ON perso.id_personnage = perso_p.id_personne
JOIN EPISODE ep       ON ca.id_serie = ep.id_serie AND ca.id_saison = ep.id_saison AND ca.id_episode = ep.id_episode
JOIN SERIE se         ON ep.id_serie = se.id_serie
LEFT JOIN ATTACHER att ON perso.id_personnage = att.id_personnage
LEFT JOIN POSITION pos ON att.id_position = pos.id_position
WHERE ca.is_guest_star = TRUE;

-- ============================================================
-- Vue Annexe 5 : Fiche d'un personnage
-- ============================================================

CREATE VIEW getPersonnageDetails AS
SELECT
    perso_p.nom,
    perso_p.prenom,
    perso_p.image_url_path,
    perso.desc_perso AS description,
    pos.lib_position AS position,
    se.nb_saisons,
    sa.id_saison,
    ep.id_episode,
    p_act.prenom AS acteur_prenom,
    p_act.nom AS acteur_nom,
    p_dbl.prenom AS doubleur_prenom,
    p_dbl.nom AS doubleur_nom,
    se.slug
FROM PERSONNAGE perso
JOIN PERSONNE perso_p ON perso.id_personnage = perso_p.id_personne
LEFT JOIN ATTACHER att ON perso.id_personnage = att.id_personnage
LEFT JOIN POSITION pos ON att.id_position = pos.id_position
LEFT JOIN CASTING ca ON perso.id_personnage = ca.id_personnage
LEFT JOIN SAISON sa ON ca.id_serie = sa.id_serie AND ca.id_saison = sa.id_saison
LEFT JOIN EPISODE ep ON ca.id_serie = ep.id_serie AND ca.id_saison = ep.id_saison AND ca.id_episode = ep.id_episode
LEFT JOIN ACTEUR act ON ca.id_acteur = act.id_acteur
LEFT JOIN PERSONNE p_act ON act.id_acteur = p_act.id_personne
LEFT JOIN DOUBLEUR dbl ON ca.id_doubleur = dbl.id_doubleur
LEFT JOIN PERSONNE p_dbl ON dbl.id_doubleur = p_dbl.id_personne
LEFT JOIN SERIE se ON ca.id_serie = se.id_serie;

-- ============================================================
-- DROITS SQL : UTILISATEUR ET ADMINISTRATEUR
-- ============================================================

DO $$
BEGIN
   IF NOT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'serie_user') THEN
      CREATE ROLE serie_user NOLOGIN;
   END IF;

   IF NOT EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'serie_admin') THEN
      CREATE ROLE serie_admin NOLOGIN;
   END IF;
END;
$$;

DO $$
BEGIN
   EXECUTE FORMAT('GRANT CONNECT ON DATABASE %I TO serie_user, serie_admin', CURRENT_DATABASE());
END;
$$;

GRANT USAGE ON SCHEMA public TO serie_user, serie_admin;

GRANT SELECT, INSERT ON createUser TO serie_user, serie_admin;
GRANT SELECT ON getUserInformations TO serie_user, serie_admin;
GRANT SELECT ON getAllSeries, getSerieDetails, getSerieCreateur, getSerieChaines, getChaines,
                 getSaisonDetails, getSaisonProducteurs, getEpisodeDetails,
                 getEpisodeScenaristes, getEpisodeRealisateurs, getEpisodeGuestStars,
                 getPersonnageDetails
TO serie_user, serie_admin;

GRANT SELECT, INSERT, UPDATE, DELETE ON USERS, PERSONNE, PRODUCTEUR, CREATEUR, SCENARISTE,
    REALISATEUR, ACTEUR, DOUBLEUR, PAYS, PERSONNAGE, GENRE, POSITION, SERIE, SAISON,
    EPISODE, CHAINE, CASTING, PRODUIRE, REALISER, SCENARISER, DIFFUSER, ATTACHER
TO serie_admin;

GRANT SELECT ON AUDIT_SAUVEGARDE TO serie_admin;
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public TO serie_admin;
