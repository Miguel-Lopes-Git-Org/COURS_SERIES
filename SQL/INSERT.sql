-- ============================================================
-- INSERTIONS DE DONNÉES : SÉRIE DR. HOUSE (House M.D.)
-- ============================================================

-- PAYS
INSERT INTO PAYS (id_pays, nom_pays, code_iso) VALUES
('US', 'États-Unis', 'USA'),
('FR', 'France',     'FRA');

-- GENRE
INSERT INTO GENRE (id_genre, libelle_genre, code_genre) VALUES
('G01', 'Drame médical', 1);

-- POSITION
INSERT INTO POSITION (id_position, lib_position) VALUES
('POS01', 'Personnage principal'),
('POS02', 'Personnage secondaire'),
('POS03', 'Guest star');

-- PERSONNE (personnes réelles : créateur, acteurs, doubleurs, producteurs, réalisateurs, scénaristes)
INSERT INTO PERSONNE (id_personne, nom, prenom, image_url_path) VALUES
('P_SHORE',     'Shore',      'David',       'https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/David_Shore_by_Gage_Skidmore.jpg/330px-David_Shore_by_Gage_Skidmore.jpg'),
('P_LAURIE',    'Laurie',     'Hugh',        'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Hugh_Laurie%2C_from_a_bit_of_Fry_%26_Laurie%2C_http---en.wikipedia.org-wiki-Hugh_laurie_%289450843901%29_%28cropped%29.jpg/330px-Hugh_Laurie%2C_from_a_bit_of_Fry_%26_Laurie%2C_http---en.wikipedia.org-wiki-Hugh_laurie_%289450843901%29_%28cropped%29.jpg'),
('P_EPPS',      'Epps',       'Omar',        'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2b/Omar_Epps.jpg/330px-Omar_Epps.jpg'),
('P_EDELSTEIN', 'Edelstein',  'Lisa',        'https://upload.wikimedia.org/wikipedia/commons/5/5a/Lisa_Edelstein_2021.png'),
('P_LEONARD',   'Leonard',    'Robert Sean', 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/47/Robert_Sean_Leonard.jpg/330px-Robert_Sean_Leonard.jpg'),
('P_MORRISON',  'Morrison',   'Jennifer',    'https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Jennifer_Morrison_SDCC_2014.jpg/330px-Jennifer_Morrison_SDCC_2014.jpg'),
('P_SPENCER',   'Spencer',    'Jesse',       'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Jesse_Spencer_2009.jpg/330px-Jesse_Spencer_2009.jpg'),
('P_ATTANASIO', 'Attanasio',  'Paul',        'https://upload.wikimedia.org/wikipedia/commons/thumb/4/42/Paul_Attanasio.jpg/330px-Paul_Attanasio.jpg'),
('P_JACOBS',    'Jacobs',     'Katie',       'https://upload.wikimedia.org/wikipedia/commons/a/a6/Katie_Jacobs_cropped.jpg'),
('P_YAITANES',  'Yaitanes',   'Greg',        NULL),
('P_LERNER',    'Lerner',     'Deran',       'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Deran_Sarafian_by_Gage_Skidmore.jpg/330px-Deran_Sarafian_by_Gage_Skidmore.jpg'),
('P_BLAKE',     'Blake',      'Bryan',       'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Brian_Singer_%22International_Competition_Jury%22_at_Opening_Ceremony_of_the_28th_Tokyo_International_Film_Festival_%2822427114066%29_%28cropped%29%282%29.jpg/330px-Brian_Singer_%22International_Competition_Jury%22_at_Opening_Ceremony_of_the_28th_Tokyo_International_Film_Festival_%2822427114066%29_%28cropped%29%282%29.jpg'),
('P_CHOEL',     'Choël',      'Bruno',       'https://upload.wikimedia.org/wikipedia/commons/thumb/3/33/Choel_Bruno_-_novembre_2016.jpg/120px-Choel_Bruno_-_novembre_2016.jpg'),
('P_THOMAS',    'Thomas',     'Laurent',     NULL),
('P_DELSOL',    'Delsol',     'Barbara',     NULL),
('P_DESROSES',  'Desroses',   'Thierry',     'https://upload.wikimedia.org/wikipedia/commons/thumb/3/39/Thierry_Desroses_lors_du_Gamefest_de_Strasbourg_en_2025.jpg/330px-Thierry_Desroses_lors_du_Gamefest_de_Strasbourg_en_2025.jpg'),
('P_CHETAIL',   'Chétail',    'Adeline',     'https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/Adeline-Chetail-Japan-Geek-Festival-LaRochelle-septembre-2021.jpg/330px-Adeline-Chetail-Japan-Geek-Festival-LaRochelle-septembre-2021.jpg'),
('P_TOMASSIAN', 'Tomassian',  'Alexis',      NULL);

-- PERSONNE (personnages fictifs de la série)
INSERT INTO PERSONNE (id_personne, nom, prenom, image_url_path) VALUES
('C_HOUSE',    'House',    'Gregory', 'https://upload.wikimedia.org/wikipedia/en/0/0b/HouseGregoryHouse.png'),
('C_FOREMAN',  'Foreman',  'Eric',    'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2b/Omar_Epps.jpg/330px-Omar_Epps.jpg'),
('C_CUDDY',    'Cuddy',    'Lisa',    'https://upload.wikimedia.org/wikipedia/en/5/5d/Lisacuddypromoseason6.jpg'),
('C_WILSON',   'Wilson',   'James',   'https://upload.wikimedia.org/wikipedia/en/8/80/Jameswilsonpromoseason6.jpg'),
('C_CAMERON',  'Cameron',  'Allison', 'https://upload.wikimedia.org/wikipedia/en/b/b7/Allisoncameronpromoseason6.jpg'),
('C_CHASE',    'Chase',    'Robert',  'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Jesse_Spencer_2009.jpg/330px-Jesse_Spencer_2009.jpg');

-- CREATEUR
INSERT INTO CREATEUR (id_createur) VALUES
('P_SHORE');

-- PRODUCTEUR
INSERT INTO PRODUCTEUR (id_producteur) VALUES
('P_ATTANASIO'),
('P_JACOBS');

-- REALISATEUR
INSERT INTO REALISATEUR (id_realisateur) VALUES
('P_YAITANES');

-- SCENARISTE
INSERT INTO SCENARISTE (id_scenariste) VALUES
('P_SHORE'),
('P_LERNER'),
('P_BLAKE');

-- ACTEUR
INSERT INTO ACTEUR (id_acteur) VALUES
('P_LAURIE'),
('P_EPPS'),
('P_EDELSTEIN'),
('P_LEONARD'),
('P_MORRISON'),
('P_SPENCER');

-- DOUBLEUR (doubleurs français)
INSERT INTO DOUBLEUR (id_doubleur) VALUES
('P_CHOEL'),
('P_THOMAS'),
('P_DELSOL'),
('P_DESROSES'),
('P_CHETAIL'),
('P_TOMASSIAN');

-- PERSONNAGE
INSERT INTO PERSONNAGE (id_personnage, desc_perso) VALUES
('C_HOUSE',   'Médecin diagnosticien surdoué et cynique'),
('C_FOREMAN', 'Neurologue, fellow de House'),
('C_CUDDY',   'Directrice du Princeton-Plainsboro Teaching Hospital'),
('C_WILSON',  'Oncologue, meilleur ami de House'),
('C_CAMERON', 'Immunologue, fellow de House'),
('C_CHASE',   'Intensiviste, fellow de House');

-- CHAINE
INSERT INTO CHAINE (id_chaine, nom_chaine, numero_chaine, id_pays) VALUES
('TF1',   'TF1',      1,  'FR'),
('F2',    'France 2', 2,  'FR'),
('TF6',   'TF6',      6,  'FR'),
('FOX01', 'Fox',      30, 'US');

-- SERIE
-- id_serie est SERIAL, on peut omettre la colonne ou fournir la valeur explicitement
INSERT INTO SERIE (id_serie, nb_saisons, titreVF, description, date_creation, image_url_path, video_path_url, banner_path_url, id_pays, id_createur, id_genre, musique_generique, slug) VALUES
(1, 8, 'Dr. House',
 'Un médecin diagnosticien de génie mais asocial résout des cas médicaux complexes avec son équipe au Princeton-Plainsboro Teaching Hospital.',
 '2004-11-16', 'https://images.justwatch.com/poster/322141167/s718/saison-8.jpg', 'https://www.youtube.com/watch?v=sFG79agEkyw', 'https://wallpaperaccess.com/full/1895672.jpg', 'US', 'P_SHORE', 'G01', 'Teardrop - Massive Attack', 'dr-house');
-- Resynchroniser la séquence après insertion explicite
SELECT setval(pg_get_serial_sequence('SERIE', 'id_serie'), MAX(id_serie)) FROM SERIE;

-- DIFFUSER
INSERT INTO DIFFUSER (id_serie, id_chaine) VALUES
(1, 'FOX01'),
(1, 'TF1'),
(1, 'TF6'),
(1, 'F2');

-- SAISON
INSERT INTO SAISON (id_serie, id_saison, nb_episodes) VALUES
(1, 1, 22),
(1, 2, 24),
(1, 3, 25),
(1, 4, 16),
(1, 5, 24),
(1, 6, 22),
(1, 7, 23),
(1, 8, 22);

-- EPISODE (Saison 1)
INSERT INTO EPISODE (id_serie, id_saison, id_episode, titre_vo, date_diff_original, date_diff_fr, titre_fr, image_url_path, duree, description) VALUES
(1, 1,  1,  'Pilot',              '2004-11-16', '01/09/2005', 'Pilote',              'https://static.tvmaze.com/uploads/images/original_untouched/601/1504952.jpg', 47, 'House prend en charge une institutrice avec des symptomes neurologiques inexpliques et impose sa methode brutale pour poser le diagnostic.'),
(1, 1,  2,  'Paternity',          '2004-11-23', '08/09/2005', 'Paternité',           'https://static.tvmaze.com/uploads/images/original_untouched/601/1504953.jpg', 43, 'Un adolescent sportif tombe gravement malade. L equipe explore les causes genetiques et infectieuses pendant que House ecarte les fausses pistes.'),
(1, 1,  3,  'Occam''s Razor',     '2004-11-30', '15/09/2005', 'Le rasoir d''Occam',  'https://static.tvmaze.com/uploads/images/original_untouched/601/1504954.jpg', 44, 'Un etudiant presente des symptomes multiples apparemment incompatibles. House applique le rasoir d Occam pour simplifier un cas trompeur.'),
(1, 1,  4,  'Maternity',          '2004-12-07', '22/09/2005', 'Maternité',           'https://static.tvmaze.com/uploads/images/original_untouched/601/1504955.jpg', 46, 'Une epidemie touche des nouveau nes. House et son equipe doivent identifier l origine du mal avant qu il ne se propage dans tout le service.'),
(1, 1,  5,  'Damned If You Do',   '2004-12-14', '29/09/2005', 'Dieu et la médecine', 'https://static.tvmaze.com/uploads/images/original_untouched/601/1504956.jpg', 42, 'Une religieuse est hospitalisee avec des hallucinations. House confronte ses croyances a la realite medicale pour trouver la cause du trouble.'),
(1, 1, 22,  'The Honeymoon',      '2005-05-24', '10/01/2006', 'Lune de miel',        'https://static.tvmaze.com/uploads/images/original_untouched/601/1504976.jpg', 45, 'House accepte de traiter le mari de son ex compagne, ce qui ravive des tensions personnelles pendant une enquete diagnostique delicate.');

-- EPISODE (Saison 2)
INSERT INTO EPISODE (id_serie, id_saison, id_episode, titre_vo, date_diff_original, date_diff_fr, titre_fr, image_url_path, duree, description) VALUES
(1, 2,  1,  'Acceptance',         '2005-09-13', '01/03/2006', 'Acceptation',   'https://static.tvmaze.com/uploads/images/original_untouched/57/144537.jpg', 44, 'House reprend le travail apres sa convalescence et traite une patiente qui perd progressivement ses fonctions motrices.'),
(1, 2,  2,  'Autopsy',            '2005-09-20', '08/03/2006', 'Autopsie',      'https://static.tvmaze.com/uploads/images/original_untouched/57/144538.jpg', 41, 'Une adolescente atteinte d un cancer presente un nouveau symptome mysterieux. L equipe doit gerer urgence medicale et dilemme humain.'),
(1, 2,  3,  'Humpty Dumpty',      '2005-09-27', '15/03/2006', 'Humpty Dumpty', 'https://static.tvmaze.com/uploads/images/original_untouched/57/144540.jpg', 43, 'Le mari de Cuddy est victime d un accident domestique. House enquete sur des complications inattendues qui menacent sa survie.'),
(1, 2, 24,  'No Reason',    	  '2006-05-23', '01/11/2006', 'Sans raison',   'https://static.tvmaze.com/uploads/images/original_untouched/57/144563.jpg', 48, 'Apres avoir ete victime d une agression, House traverse une experience troublee entre realite et hallucinations pendant un cas critique.');

-- EPISODE (Saison 3)
INSERT INTO EPISODE (id_serie, id_saison, id_episode, titre_vo, date_diff_original, date_diff_fr, titre_fr, image_url_path, duree, description) VALUES
(1, 3,  1,  'Meaning',            '2006-09-05', '10/01/2007', 'Le sens des choses', 'https://static.tvmaze.com/uploads/images/original_untouched/57/144583.jpg', 45, 'House retourne a son service avec une equipe fragilisee. Le cas d un patient tetraplegique met a l epreuve ses convictions.'),
(1, 3,  2,  'Cane and Able',      '2006-09-12', '17/01/2007', 'Canne et capacité',  'https://static.tvmaze.com/uploads/images/original_untouched/57/144585.jpg', 42, 'Un enfant presente des comportements violents et des symptomes atypiques. House soupconne une pathologie rare derriere le tableau psychiatrique.'),
(1, 3, 25,  'Human Error',        '2007-05-29', '01/11/2007', 'Erreur humaine',     'https://static.tvmaze.com/uploads/images/original_untouched/57/144607.jpg', 46, 'Un couple cubain arrive en urgence pour un accouchement a risque. Le diagnostic final entraine des consequences majeures pour l equipe.');

-- EPISODE (Saisons 4 à 8 — premier épisode de chaque saison)
INSERT INTO EPISODE (id_serie, id_saison, id_episode, titre_vo, date_diff_original, date_diff_fr, titre_fr, image_url_path, duree, description) VALUES
(1, 4, 1, 'Alone',                    '2007-09-25', '01/01/2008', 'Seul',                       'https://static.tvmaze.com/uploads/images/original_untouched/57/144611.jpg', 43, 'Sans equipe fixe, House lance une selection impitoyable de candidats tout en traitant une femme victime d un effondrement pulmonaire.'),
(1, 5, 1, 'Dying Changes Everything', '2008-09-16', '01/01/2009', 'Tout change face à la mort', 'https://static.tvmaze.com/uploads/images/original_untouched/57/144630.jpg', 44, 'House revient apres le drame de la saison precedente. Un cas complexe de deces brutal bouleverse encore davantage son equilibre personnel.'),
(1, 6, 1, 'Broken',                   '2009-09-21', '01/01/2010', 'Brisé',                      'https://static.tvmaze.com/uploads/images/original_untouched/57/144656.jpg', 88, 'House est hospitalise en psychiatrie pour desactivite de sa dependance. Il doit affronter ses demons avant de pouvoir reprendre la medecine.'),
(1, 7, 1, 'Now What?',                '2010-09-20', '01/01/2011', 'Et maintenant ?',            'https://static.tvmaze.com/uploads/images/original_untouched/57/144677.jpg', 46, 'House et Cuddy tentent de construire une relation stable tandis qu un nouveau patient met leur duo sous pression immediate.'),
(1, 8, 1, 'Twenty Vicodin',           '2011-10-03', '01/01/2012', 'Vingt Vicodin',              'https://static.tvmaze.com/uploads/images/original_untouched/601/1504922.jpg', 41, 'Sorti de prison, House revient au Princeton Plainsboro avec une equipe remaniee et reprend les diagnostics sur un cas a haut risque.');

-- CASTING (Saison 1, épisodes sélectionnés)
INSERT INTO CASTING (id_serie, id_saison, id_episode, id_personnage, is_guest_star, id_doubleur, id_acteur) VALUES
(1, 1,  1, 'C_HOUSE',   FALSE, 'P_CHOEL',     'P_LAURIE'),
(1, 1,  1, 'C_FOREMAN', FALSE, 'P_DESROSES',  'P_EPPS'),
(1, 1,  1, 'C_CUDDY',   FALSE, 'P_DELSOL',    'P_EDELSTEIN'),
(1, 1,  1, 'C_WILSON',  FALSE, 'P_THOMAS',    'P_LEONARD'),
(1, 1,  1, 'C_CAMERON', FALSE, 'P_CHETAIL',   'P_MORRISON'),
(1, 1,  1, 'C_CHASE',   FALSE, 'P_TOMASSIAN', 'P_SPENCER'),
(1, 1,  2, 'C_HOUSE',   FALSE, 'P_CHOEL',     'P_LAURIE'),
(1, 1,  2, 'C_FOREMAN', FALSE, 'P_DESROSES',  'P_EPPS'),
(1, 1,  2, 'C_CUDDY',   FALSE, 'P_DELSOL',    'P_EDELSTEIN'),
(1, 1,  2, 'C_WILSON',  FALSE, 'P_THOMAS',    'P_LEONARD'),
(1, 1,  2, 'C_CAMERON', FALSE, 'P_CHETAIL',   'P_MORRISON'),
(1, 1,  2, 'C_CHASE',   FALSE, 'P_TOMASSIAN', 'P_SPENCER'),
(1, 1, 22, 'C_HOUSE',   FALSE, 'P_CHOEL',     'P_LAURIE'),
(1, 1, 22, 'C_WILSON',  FALSE, 'P_THOMAS',    'P_LEONARD'),
(1, 2,  1, 'C_HOUSE',   FALSE, 'P_CHOEL',     'P_LAURIE'),
(1, 2,  1, 'C_FOREMAN', FALSE, 'P_DESROSES',  'P_EPPS'),
(1, 2,  1, 'C_CUDDY',   FALSE, 'P_DELSOL',    'P_EDELSTEIN'),
(1, 2,  1, 'C_WILSON',  FALSE, 'P_THOMAS',    'P_LEONARD'),
(1, 2,  1, 'C_CAMERON', FALSE, 'P_CHETAIL',   'P_MORRISON'),
(1, 2,  1, 'C_CHASE',   FALSE, 'P_TOMASSIAN', 'P_SPENCER');

-- PRODUIRE
INSERT INTO PRODUIRE (id_serie, id_saison, id_producteur) VALUES
(1, 1, 'P_ATTANASIO'),
(1, 1, 'P_JACOBS'),
(1, 2, 'P_ATTANASIO'),
(1, 2, 'P_JACOBS'),
(1, 3, 'P_ATTANASIO'),
(1, 3, 'P_JACOBS'),
(1, 4, 'P_ATTANASIO'),
(1, 4, 'P_JACOBS'),
(1, 5, 'P_ATTANASIO'),
(1, 5, 'P_JACOBS'),
(1, 6, 'P_ATTANASIO'),
(1, 6, 'P_JACOBS'),
(1, 7, 'P_ATTANASIO'),
(1, 7, 'P_JACOBS'),
(1, 8, 'P_ATTANASIO'),
(1, 8, 'P_JACOBS');

-- REALISER
INSERT INTO REALISER (id_realisateur, id_serie, id_saison, id_episode) VALUES
('P_YAITANES', 1, 1,  1),
('P_YAITANES', 1, 1, 22),
('P_YAITANES', 1, 2, 24),
('P_YAITANES', 1, 3, 25);

-- SCENARISER
INSERT INTO SCENARISER (id_scenariste, id_serie, id_saison, id_episode) VALUES
('P_SHORE',  1, 1,  1),
('P_SHORE',  1, 1, 22),
('P_LERNER', 1, 1,  2),
('P_LERNER', 1, 1,  3),
('P_BLAKE',  1, 1,  4),
('P_BLAKE',  1, 1,  5),
('P_SHORE',  1, 2, 24),
('P_LERNER', 1, 2,  1);

-- ATTACHER
INSERT INTO ATTACHER (id_personnage, id_position) VALUES
('C_HOUSE',   'POS01'),
('C_FOREMAN', 'POS01'),
('C_CUDDY',   'POS01'),
('C_WILSON',  'POS01'),
('C_CAMERON', 'POS02'),
('C_CHASE',   'POS02');