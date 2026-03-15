<?php

// =======================================================================
//
// Connexion à la base de données
//
// =======================================================================

function bddConexion()
{
    $env = [];
    $envPath = __DIR__ . '/../.env';
    
    if (file_exists($envPath)) {
        $parsed = parse_ini_file($envPath);
        if ($parsed !== false) {
            $env = $parsed;
            error_log("[DEBUG] .env file keys found: " . implode(", ", array_keys($env)));
        }
    }

    // Fonction helper pour récupérer une valeur nettoyée
    $getVal = function($key, $default) use ($env) {
        $val = getenv($key) ?: ($env[$key] ?? '');
        $val = trim($val, " \t\n\r\0\x0B\""); // Enlever espaces et guillemets superflus
        return ($val !== '') ? $val : $default;
    };

    $host   = $getVal('HOST', '127.0.0.1');
    $dbname = $getVal('DBNAME', 'test');
    $user   = $getVal('USER', 'root');
    $pass   = $getVal('PASS', '');

    error_log("[DEBUG] Final Database Config: host=$host, dbname=$dbname, user=$user");

    try {
        $dsn = "pgsql:host=$host;dbname=$dbname";
        $bdd = new PDO($dsn, $user, $pass);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (Exception $e) {
        error_log("[ERROR] Connection failed: " . $e->getMessage());
        die('Erreur de connexion à la base de données. Veuillez consulter les logs du serveur.');
    }
}

// =======================================================================
//
// Récupération des données pour les séries, saisons, épisodes 
// et personnages
//
// =======================================================================

function getAllSeries()
{
    require_once __DIR__ . '/classes/classSerie.php';
    $bdd = bddConexion();
    $req = $bdd->query('SELECT * FROM getAllSeries');
    $series = $req->fetchAll();
    $serieObjects = [];
    foreach ($series as $serie) {
        $serieObjects[] = new SERIES(
            $serie['titrevf'],
            $serie['image_url_path'],
            $serie['video_path_url'] ?? null,
            $serie['banner_path_url'] ?? null,
            $serie['slug'],
            $serie['libelle_genre'],
            $serie['pays_origine']
        );
    }
    return $serieObjects;
}

function getSerieDetails($slug)
{
    require_once __DIR__ . '/classes/classSerieDetail.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getSerieDetails WHERE slug = :slug');
    $req->execute([':slug' => $slug]);
    $serieDetail = $req->fetch();
    return new SERIESDETAIL(
        $serieDetail['titrevf'],
        $serieDetail['titrevo'],
        $serieDetail['description'],
        $serieDetail['date_creation'],
        $serieDetail['image_url_path'],
        $serieDetail['video_path_url'] ?? null,
        $serieDetail['banner_path_url'] ?? null,
        $serieDetail['musique_generique'],
        $serieDetail['slug'],
        $serieDetail['libelle_genre'],
        $serieDetail['pays_origine'],
        isset($serieDetail['nb_saisons']) ? (string)$serieDetail['nb_saisons'] : null,
        isset($serieDetail['moyenne_duree_episodes']) ? (string)$serieDetail['moyenne_duree_episodes'] : null
    );
}

function getSaisonDetails($slug, $numeroSaison)
{
    require_once __DIR__ . '/classes/classEpisode.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getSaisonDetails WHERE slug = :slug AND id_saison = :id_saison');
    $req->execute([':slug' => $slug, ':id_saison' => $numeroSaison]);
    $rows = $req->fetchAll();

    $episodeObjects = [];

    foreach ($rows as $row) {
        $episodeObjects[] = new EPISODE(
            $row['titre_serie'],
            $row['slug'],
            (int)$row['nb_saisons'],
            (int)$row['id_saison'],
            (int)$row['id_episode'],
            $row['titre_vo'],
            $row['titre_fr'],
            $row['date_diffusion_usa'] ?? null,
            $row['date_diffusion_fr'] ?? null,
            $row['resume'] ?? null,
            $row['episode_image_url_path'] ?? null,
            $row['banner_path_url'] ?? null
        );
    }

    return $episodeObjects;
}

function getEpisodeDetails($slug, $numeroSaison, $numeroEpisode)
{
    require_once __DIR__ . '/classes/classEpisode.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getEpisodeDetails WHERE slug = :slug AND id_saison = :id_saison AND id_episode = :id_episode');
    $req->execute([':slug' => $slug, ':id_saison' => $numeroSaison, ':id_episode' => $numeroEpisode]);
    $rows = $req->fetchAll();

    $episodeObjects = [];
    foreach ($rows as $row) {
        $episodeObjects[] = new EPISODE(
            $row['titre_serie'],
            $row['slug'],
            (int)$row['nb_saisons'],
            (int)$row['id_saison'],
            (int)$row['id_episode'],
            $row['titre_vo'],
            $row['titre_fr'],
            $row['date_diffusion_usa'],
            $row['date_diffusion_fr'],
            $row['resume'] ?? null,
            $row['image_url_path'] ?? null,
            $row['banner_path_url'] ?? null,
            $row['description'] ?? null
        );
    }

    return $episodeObjects;
}

function getPersonnageDetails($slug, $numeroSaison, $numeroEpisode)
{
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getPersonnageDetails WHERE slug = :slug AND id_saison = :id_saison AND id_episode = :id_episode');
    $req->execute([':slug' => $slug, ':id_saison' => $numeroSaison, ':id_episode' => $numeroEpisode]);
    return $req->fetchAll();
}

// =======================================================================
//
// Récupération des données pour les créateurs, chaînes, producteurs,
// scénaristes, réalisateurs et guest stars
//
// =======================================================================

function getSerieCreateur($slug)
{
    require_once __DIR__ . '/classes/classPersonne.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getSerieCreateur WHERE slug = :slug');
    $req->execute([':slug' => $slug]);
    $rows = $req->fetchAll();
    $createurObjects = [];
    foreach ($rows as $row) {
        $createurObjects[] = new Createur(
            $row['nom'],
            $row['prenom']
        );
    }
    return $createurObjects;
}

function getSerieChaines($slug)
{
    require_once __DIR__ . '/classes/classChaine.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getSerieChaines WHERE slug = :slug');
    $req->execute([':slug' => $slug]);
    $rows = $req->fetchAll();
    $chaineObjects = [];
    foreach ($rows as $row) {
        $chaineObjects[] = new CHAINE(
            $row['nom_chaine'],
            (int)$row['numero_chaine'],
            $row['pays'],
            $row['code_iso']
        );
    }
    return $chaineObjects;
}

function getSaisonProducteurs($slug, $numeroSaison)
{
    require_once __DIR__ . '/classes/classPersonne.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getSaisonProducteurs WHERE slug = :slug AND id_saison = :id_saison');
    $req->execute([':slug' => $slug, ':id_saison' => $numeroSaison]);
    $rows = $req->fetchAll();
    $producteurObjects = [];
    foreach ($rows as $row) {
        $producteurObjects[] = new Producteur(
            $row['nom'],
            $row['prenom']
        );
    }
    return $producteurObjects;
}

function getEpisodeScenaristes($slug, $numeroSaison, $numeroEpisode)
{
    require_once __DIR__ . '/classes/classPersonne.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getEpisodeScenaristes WHERE slug = :slug AND id_saison = :id_saison AND id_episode = :id_episode');
    $req->execute([':slug' => $slug, ':id_saison' => $numeroSaison, ':id_episode' => $numeroEpisode]);
    $rows = $req->fetchAll();
    $scenaristeObjects = [];
    foreach ($rows as $row) {
        $scenaristeObjects[] = new Scenariste(
            $row['nom'],
            $row['prenom'],
            $row['image_url_path'] ?? ''
        );
    }
    return $scenaristeObjects;
}

function getEpisodeRealisateurs($slug, $numeroSaison, $numeroEpisode)
{
    require_once __DIR__ . '/classes/classPersonne.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getEpisodeRealisateurs WHERE slug = :slug AND id_saison = :id_saison AND id_episode = :id_episode');
    $req->execute([':slug' => $slug, ':id_saison' => $numeroSaison, ':id_episode' => $numeroEpisode]);
    $rows = $req->fetchAll();
    $realisateurObjects = [];
    foreach ($rows as $row) {
        $realisateurObjects[] = new Realisateur(
            $row['nom'],
            $row['prenom'],
            $row['image_url_path'] ?? ''
        );
    }
    return $realisateurObjects;
}

function getEpisodeGuestStars($slug, $numeroSaison, $numeroEpisode)
{
    require_once __DIR__ . '/classes/classPersonne.php';
    $bdd = bddConexion();
    $req = $bdd->prepare('SELECT * FROM getEpisodeGuestStars WHERE slug = :slug AND id_saison = :id_saison AND id_episode = :id_episode');
    $req->execute([':slug' => $slug, ':id_saison' => $numeroSaison, ':id_episode' => $numeroEpisode]);
    $rows = $req->fetchAll();
    $guestStarObjects = [];
    foreach ($rows as $row) {
        $nom = $row['acteur_nom'] ?? $row['nom'] ?? '';
        $prenom = $row['acteur_prenom'] ?? $row['prenom'] ?? '';
        $position = new Position((string)($row['position'] ?? $row['guest_position'] ?? 'Guest Star'));

        $guestStarObjects[] = new GuestStar(
            $nom,
            $prenom,
            $position,
            $row['image_url_path'] ?? ''
        );
    }
    return $guestStarObjects;
}

// =======================================================================
//
// Requêtes liées à la création d'un compte
//
// =======================================================================


function registerUser(array $data): array
{
    $errors = [];

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Adresse email invalide.";
    }
    if (empty($data['password'])) {
        $errors[] = "Le mot de passe est obligatoire.";
    } else {
        $password = $data['password'];
        if (strlen($password) < 12 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
            $errors[] = "Le mot de passe doit contenir au moins 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial.";
        }
    }
    if (isset($data['password']) && isset($data['password_confirm']) && $data['password'] !== $data['password_confirm']) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    if (!empty($errors)) {
        return $errors;
    }

    $bdd = bddConexion();

    // Vérifie si l'email existe déjà
    $check = $bdd->prepare('SELECT * FROM getUserInformations WHERE email = :email');
    $check->execute([':email' => $data['email']]);
    if ($check->fetch()) {
        return ["Cette adresse email est déjà utilisée."];
    }

    $id_user  = uniqid('u_', true);
    $hashed   = password_hash($data['password'], PASSWORD_BCRYPT);

    // Formatage de la date d'expiration (MM/AA → YYYY-MM-DD)
    $expiryFormatted = null;
    if (!empty($data['creditCardExpirationDate'])) {
        $parts = explode('/', $data['creditCardExpirationDate']);
        if (count($parts) === 2) {
            $month = str_pad(trim($parts[0]), 2, '0', STR_PAD_LEFT);
            $year  = '20' . ltrim(trim($parts[1]), '0');
            $expiryFormatted = $year . '-' . $month . '-01';
        }
    }

    $stmt = $bdd->prepare(
        'INSERT INTO createUser (id_user, email, password, firstName, lastName, streetAddress, zipCode, city, phoneNumber)
         VALUES
            (:id_user, :email, :password, :firstName, :lastName,
             :streetAddress, :zipCode, :city, :phoneNumber)'
    );

    $stmt->execute([
        ':id_user'       => $id_user,
        ':email'         => $data['email'],
        ':password'      => $hashed,
        ':firstName'     => $data['firstName']     ?? null,
        ':lastName'      => $data['lastName']      ?? null,
        ':streetAddress' => $data['streetAddress'] ?? null,
        ':zipCode'       => $data['zipCode']       ?? null,
        ':city'          => $data['city']          ?? null,
        ':phoneNumber'   => $data['phoneNumber']   ?? null,
    ]);

    return [];
}

// =======================================================================
//
// Requêtes liées à la connexion d'un compte
//
// =======================================================================

function loginUser(string $email, string $password): array
{
    if (empty($email) || empty($password)) {
        return ["Email et mot de passe obligatoires."];
    }

    $bdd  = bddConexion();
    $stmt = $bdd->prepare(
        'SELECT * FROM getUserInformations WHERE email = :email'
    );
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        return ["Email ou mot de passe incorrect."];
    }

    // Démarrage de la session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_regenerate_id(true);

    $_SESSION['email']     = $user['email'];
    $_SESSION['firstName'] = $user['firstName'];
    $_SESSION['lastName']  = $user['lastName'];

    return [];
}
