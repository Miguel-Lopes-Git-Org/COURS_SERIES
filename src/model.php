<?php

// =======================================================================
//
// Connexion à la base de données
//
// =======================================================================

function bddConexion()
{
    $paramFile = __DIR__ . '/myParam.inc.php';

    if (!file_exists($paramFile)) {
        die('Erreur de configuration du serveur. Fichier de paramètres manquant.');
    }

    require_once $paramFile;

    $host   = DB_HOST;
    $dbname = DB_NAME;
    $user   = DB_USER;
    $pass   = DB_PASS;

    try {
        $dsn = "pgsql:host=$host;dbname=$dbname";
        $bdd = new PDO($dsn, $user, $pass);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (Exception $e) {
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
    $userCount = (int)$bdd->query('SELECT COUNT(*) FROM USERS')->fetchColumn();
    $role = $userCount === 0 ? 'admin' : 'user';

    $stmt = $bdd->prepare(
        'INSERT INTO createUser (id_user, email, password, role)
         VALUES (:id_user, :email, :password, :role)'
    );

    $stmt->execute([
        ':id_user'       => $id_user,
        ':email'         => $data['email'],
        ':password'      => $hashed,
        ':role'          => $role,
    ]);

    return [];
}

function completeUserRegistration(string $email, array $data): array
{
    $errors = [];

    $requiredFields = [
        'firstName' => 'Le prenom est obligatoire.',
        'lastName' => 'Le nom est obligatoire.',
        'phoneNumber' => 'Le telephone est obligatoire.',
        'streetAddress' => 'L adresse complete est obligatoire.',
        'zipCode' => 'Le code postal est obligatoire.',
        'city' => 'La ville est obligatoire.',
        'cardNumber' => 'Le numero de carte est obligatoire.',
        'cardCvv' => 'Le CCV est obligatoire.',
        'cardExpiration' => 'La date d expiration est obligatoire.',
    ];

    foreach ($requiredFields as $field => $message) {
        if (trim((string)($data[$field] ?? '')) === '') {
            $errors[] = $message;
        }
    }

    $phoneNumber = preg_replace('/\s+/', '', (string)($data['phoneNumber'] ?? ''));
    if ($phoneNumber !== '' && !preg_match('/^[0-9+.-]{6,20}$/', $phoneNumber)) {
        $errors[] = 'Le telephone est invalide.';
    }

    $zipCode = trim((string)($data['zipCode'] ?? ''));
    if ($zipCode !== '' && !preg_match('/^[0-9A-Za-z -]{3,12}$/', $zipCode)) {
        $errors[] = 'Le code postal est invalide.';
    }

    $cardNumber = preg_replace('/\D+/', '', (string)($data['cardNumber'] ?? ''));
    if ($cardNumber !== '' && !preg_match('/^\d{13,19}$/', $cardNumber)) {
        $errors[] = 'Le numero de carte est invalide.';
    }

    $cardCvv = preg_replace('/\D+/', '', (string)($data['cardCvv'] ?? ''));
    if ($cardCvv !== '' && !preg_match('/^\d{3,4}$/', $cardCvv)) {
        $errors[] = 'Le CCV est invalide.';
    }

    $cardExpiration = trim((string)($data['cardExpiration'] ?? ''));
    if ($cardExpiration !== '' && !preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2}|[0-9]{4})$/', $cardExpiration)) {
        $errors[] = 'La date d expiration doit etre au format MM/AA ou MM/AAAA.';
    }

    if (!empty($errors)) {
        return $errors;
    }

    $encryptedCardNumber = encryptSensitiveData($cardNumber);
    $encryptedExpiration = encryptSensitiveData($cardExpiration);

    if ($encryptedCardNumber === null || $encryptedExpiration === null) {
        return ['Impossible de chiffrer les donnees bancaires. Verifiez la configuration ENCRYPTION_KEY.'];
    }

    $bdd = bddConexion();
    $stmt = $bdd->prepare(
        'UPDATE createUser
         SET firstName = :firstName,
             lastName = :lastName,
             streetAddress = :streetAddress,
             zipCode = :zipCode,
             city = :city,
             phoneNumber = :phoneNumber,
             cardNumberEncrypted = :cardNumberEncrypted,
             cardExpirationEncrypted = :cardExpirationEncrypted
         WHERE email = :email'
    );

    $stmt->execute([
        ':firstName' => trim((string)$data['firstName']),
        ':lastName' => trim((string)$data['lastName']),
        ':streetAddress' => trim((string)$data['streetAddress']),
        ':zipCode' => $zipCode,
        ':city' => trim((string)$data['city']),
        ':phoneNumber' => $phoneNumber,
        ':cardNumberEncrypted' => $encryptedCardNumber,
        ':cardExpirationEncrypted' => $encryptedExpiration,
        ':email' => $email,
    ]);

    $_SESSION['firstName'] = trim((string)$data['firstName']);
    $_SESSION['lastName'] = trim((string)$data['lastName']);

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
    $_SESSION['firstName'] = $user['firstname'] ?? null;
    $_SESSION['lastName']  = $user['lastname']  ?? null;
    $_SESSION['role']      = $user['role'] ?? 'user';

    return [];
}

function getCurrentUserInformations(string $email): ?array
{
    $bdd = bddConexion();
    $stmt = $bdd->prepare('SELECT * FROM getUserInformations WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return null;
    }

    $cardNumber = decryptSensitiveData($user['cardnumberencrypted'] ?? null);
    $user['maskedcardnumber'] = maskCardNumber($cardNumber);

    return $user;
}

function startUserSession(array $user): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    session_regenerate_id(true);

    $_SESSION['email']     = $user['email'];
    $_SESSION['firstName'] = $user['firstname'] ?? null;
    $_SESSION['lastName']  = $user['lastname']  ?? null;
    $_SESSION['role']      = $user['role'] ?? 'user';
}

function encryptSensitiveData(?string $plainText): ?string
{
    if ($plainText === null || $plainText === '') {
        return null;
    }

    $key = getEncryptionKey();
    if ($key === null || !function_exists('openssl_encrypt')) {
        return null;
    }

    $cipher = 'AES-256-CBC';
    $ivLength = openssl_cipher_iv_length($cipher);
    if ($ivLength === false) {
        return null;
    }

    $iv = random_bytes($ivLength);
    $encrypted = openssl_encrypt($plainText, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    if ($encrypted === false) {
        return null;
    }

    return base64_encode($iv . $encrypted);
}

function decryptSensitiveData(?string $encryptedText): ?string
{
    if ($encryptedText === null || $encryptedText === '') {
        return null;
    }

    $key = getEncryptionKey();
    if ($key === null || !function_exists('openssl_decrypt')) {
        return null;
    }

    $cipher = 'AES-256-CBC';
    $ivLength = openssl_cipher_iv_length($cipher);
    if ($ivLength === false) {
        return null;
    }

    $raw = base64_decode($encryptedText, true);
    if ($raw === false || strlen($raw) <= $ivLength) {
        return null;
    }

    $iv = substr($raw, 0, $ivLength);
    $cipherText = substr($raw, $ivLength);
    $plainText = openssl_decrypt($cipherText, $cipher, $key, OPENSSL_RAW_DATA, $iv);

    return $plainText === false ? null : $plainText;
}

function maskCardNumber(?string $cardNumber): string
{
    $digits = preg_replace('/\D+/', '', (string)$cardNumber);
    if ($digits === '') {
        return 'Non renseigne';
    }

    $lastDigits = substr($digits, -4);
    return str_repeat('*', max(strlen($digits) - 4, 0)) . $lastDigits;
}

function getEncryptionKey(): ?string
{
    $paramFile = __DIR__ . '/myParam.inc.php';
    if (!defined('ENCRYPTION_KEY') && file_exists($paramFile)) {
        require_once $paramFile;
    }

    if (defined('ENCRYPTION_KEY') && ENCRYPTION_KEY !== '') {
        return hash('sha256', ENCRYPTION_KEY, true);
    }

    return null;
}

function getAdminDashboardData(): array
{
    $bdd = bddConexion();

    return [
        'series' => $bdd->query(
            "SELECT se.id_serie, se.titrevf, se.titrevo, se.slug, se.nb_saisons, se.date_creation,
                    se.image_url_path, se.video_path_url, se.banner_path_url, se.description,
                    se.musique_generique, p.nom_pays, ge.libelle_genre,
                    pe.prenom || ' ' || pe.nom AS createur
             FROM SERIE se
             JOIN PAYS p ON se.id_pays = p.id_pays
             JOIN GENRE ge ON se.id_genre = ge.id_genre
             JOIN CREATEUR cr ON se.id_createur = cr.id_createur
             JOIN PERSONNE pe ON cr.id_createur = pe.id_personne
             ORDER BY se.id_serie"
        )->fetchAll(PDO::FETCH_ASSOC),
        'saisons' => $bdd->query(
            'SELECT sa.id_serie, sa.id_saison, sa.nb_episodes, sa.date_debut_tournage, sa.date_fin_tournage,
                    se.titrevf
             FROM SAISON sa
             JOIN SERIE se ON sa.id_serie = se.id_serie
             ORDER BY se.titrevf, sa.id_saison'
        )->fetchAll(PDO::FETCH_ASSOC),
        'episodes' => $bdd->query(
            'SELECT ep.id_serie, ep.id_saison, ep.id_episode, ep.titre_fr, ep.titre_vo,
                    ep.date_diff_original, ep.date_diff_fr, ep.image_url_path, ep.duree, ep.description,
                    se.titrevf
             FROM EPISODE ep
             JOIN SERIE se ON ep.id_serie = se.id_serie
             ORDER BY se.titrevf, ep.id_saison, ep.id_episode'
        )->fetchAll(PDO::FETCH_ASSOC),
        'personnages' => $bdd->query(
            "SELECT perso.id_personnage, pe.nom, pe.prenom, pe.image_url_path, perso.desc_perso,
                    STRING_AGG(DISTINCT pos.lib_position, ', ') AS positions
             FROM PERSONNAGE perso
             JOIN PERSONNE pe ON perso.id_personnage = pe.id_personne
             LEFT JOIN ATTACHER att ON perso.id_personnage = att.id_personnage
             LEFT JOIN POSITION pos ON att.id_position = pos.id_position
             GROUP BY perso.id_personnage, pe.nom, pe.prenom, pe.image_url_path, perso.desc_perso
             ORDER BY pe.nom, pe.prenom"
        )->fetchAll(PDO::FETCH_ASSOC),
        'refs' => [
            'series' => $bdd->query('SELECT id_serie, titrevf FROM SERIE ORDER BY titrevf')->fetchAll(PDO::FETCH_ASSOC),
            'pays' => $bdd->query('SELECT id_pays, nom_pays FROM PAYS ORDER BY nom_pays')->fetchAll(PDO::FETCH_ASSOC),
            'genres' => $bdd->query('SELECT id_genre, libelle_genre FROM GENRE ORDER BY libelle_genre')->fetchAll(PDO::FETCH_ASSOC),
            'createurs' => $bdd->query(
                "SELECT cr.id_createur, pe.prenom || ' ' || pe.nom AS nom_complet
                 FROM CREATEUR cr
                 JOIN PERSONNE pe ON cr.id_createur = pe.id_personne
                 ORDER BY pe.nom, pe.prenom"
            )->fetchAll(PDO::FETCH_ASSOC),
            'positions' => $bdd->query('SELECT id_position, lib_position FROM POSITION ORDER BY lib_position')->fetchAll(PDO::FETCH_ASSOC),
            'doubleurs' => $bdd->query(
                "SELECT dbl.id_doubleur, pe.prenom || ' ' || pe.nom AS nom_complet
                 FROM DOUBLEUR dbl
                 JOIN PERSONNE pe ON dbl.id_doubleur = pe.id_personne
                 ORDER BY pe.nom, pe.prenom"
            )->fetchAll(PDO::FETCH_ASSOC),
        ],
    ];
}

function handleAdminPost(string $action, array $data): array
{
    $tabByAction = [
        'adminSerieCreate' => 'series',
        'adminSerieUpdate' => 'series',
        'adminSerieDelete' => 'series',
        'adminSaisonCreate' => 'saisons',
        'adminSaisonUpdate' => 'saisons',
        'adminSaisonDelete' => 'saisons',
        'adminEpisodeCreate' => 'episodes',
        'adminEpisodeUpdate' => 'episodes',
        'adminEpisodeDelete' => 'episodes',
        'adminPersonnageCreate' => 'personnages',
        'adminPersonnageUpdate' => 'personnages',
        'adminPersonnageDelete' => 'personnages',
    ];

    try {
        switch ($action) {
            case 'adminSerieCreate':
                adminCreateSerie($data);
                break;
            case 'adminSerieUpdate':
                adminUpdateSerie($data);
                break;
            case 'adminSerieDelete':
                adminDeleteSerie((int)($data['id_serie'] ?? 0));
                break;
            case 'adminSaisonCreate':
                adminCreateSaison($data);
                break;
            case 'adminSaisonUpdate':
                adminUpdateSaison($data);
                break;
            case 'adminSaisonDelete':
                adminDeleteSaison((int)($data['id_serie'] ?? 0), (int)($data['id_saison'] ?? 0));
                break;
            case 'adminEpisodeCreate':
                adminCreateEpisode($data);
                break;
            case 'adminEpisodeUpdate':
                adminUpdateEpisode($data);
                break;
            case 'adminEpisodeDelete':
                adminDeleteEpisode((int)($data['id_serie'] ?? 0), (int)($data['id_saison'] ?? 0), (int)($data['id_episode'] ?? 0));
                break;
            case 'adminPersonnageCreate':
                adminCreatePersonnage($data);
                break;
            case 'adminPersonnageUpdate':
                adminUpdatePersonnage($data);
                break;
            case 'adminPersonnageDelete':
                adminDeletePersonnage((string)($data['id_personnage'] ?? ''));
                break;
            default:
                return ['messages' => [], 'errors' => ['Action admin inconnue.'], 'tab' => $data['tab'] ?? 'series'];
        }

        return ['messages' => ['Operation admin effectuee.'], 'errors' => [], 'tab' => $tabByAction[$action] ?? 'series'];
    } catch (Throwable $e) {
        return ['messages' => [], 'errors' => ['Erreur admin : ' . $e->getMessage()], 'tab' => $tabByAction[$action] ?? ($data['tab'] ?? 'series')];
    }
}

function adminCreateSerie(array $data): void
{
    $bdd = bddConexion();
    $stmt = $bdd->prepare(
        'INSERT INTO SERIE (titreVF, titreVO, nb_saisons, description, date_creation, image_url_path,
                            video_path_url, banner_path_url, musique_generique, slug, id_pays, id_createur, id_genre)
         VALUES (:titreVF, :titreVO, :nb_saisons, :description, :date_creation, :image_url_path,
                 :video_path_url, :banner_path_url, :musique_generique, :slug, :id_pays, :id_createur, :id_genre)'
    );
    $stmt->execute(adminSerieParams($data));
}

function adminUpdateSerie(array $data): void
{
    $params = adminSerieParams($data);
    $params[':id_serie'] = (int)$data['id_serie'];

    $bdd = bddConexion();
    $stmt = $bdd->prepare(
        'UPDATE SERIE
         SET titreVF = :titreVF, titreVO = :titreVO, nb_saisons = :nb_saisons, description = :description,
             date_creation = :date_creation, image_url_path = :image_url_path, video_path_url = :video_path_url,
             banner_path_url = :banner_path_url, musique_generique = :musique_generique, slug = :slug,
             id_pays = :id_pays, id_createur = :id_createur, id_genre = :id_genre
         WHERE id_serie = :id_serie'
    );
    $stmt->execute($params);
}

function adminSerieParams(array $data): array
{
    return [
        ':titreVF' => trim($data['titreVF'] ?? ''),
        ':titreVO' => nullIfEmpty($data['titreVO'] ?? null),
        ':nb_saisons' => (int)($data['nb_saisons'] ?? 1),
        ':description' => nullIfEmpty($data['description'] ?? null),
        ':date_creation' => $data['date_creation'] ?? date('Y-m-d'),
        ':image_url_path' => nullIfEmpty($data['image_url_path'] ?? null),
        ':video_path_url' => nullIfEmpty($data['video_path_url'] ?? null),
        ':banner_path_url' => nullIfEmpty($data['banner_path_url'] ?? null),
        ':musique_generique' => nullIfEmpty($data['musique_generique'] ?? null),
        ':slug' => trim($data['slug'] ?? ''),
        ':id_pays' => $data['id_pays'] ?? '',
        ':id_createur' => $data['id_createur'] ?? '',
        ':id_genre' => $data['id_genre'] ?? '',
    ];
}

function adminDeleteSerie(int $idSerie): void
{
    $bdd = bddConexion();
    $bdd->beginTransaction();
    try {
        $bdd->prepare('DELETE FROM CASTING WHERE id_serie = :id')->execute([':id' => $idSerie]);
        $bdd->prepare('DELETE FROM REALISER WHERE id_serie = :id')->execute([':id' => $idSerie]);
        $bdd->prepare('DELETE FROM SCENARISER WHERE id_serie = :id')->execute([':id' => $idSerie]);
        $bdd->prepare('DELETE FROM PRODUIRE WHERE id_serie = :id')->execute([':id' => $idSerie]);
        $bdd->prepare('DELETE FROM EPISODE WHERE id_serie = :id')->execute([':id' => $idSerie]);
        $bdd->prepare('DELETE FROM SAISON WHERE id_serie = :id')->execute([':id' => $idSerie]);
        $bdd->prepare('DELETE FROM DIFFUSER WHERE id_serie = :id')->execute([':id' => $idSerie]);
        $bdd->prepare('DELETE FROM SERIE WHERE id_serie = :id')->execute([':id' => $idSerie]);
        $bdd->commit();
    } catch (Throwable $e) {
        $bdd->rollBack();
        throw $e;
    }
}

function adminCreateSaison(array $data): void
{
    $bdd = bddConexion();
    $stmt = $bdd->prepare(
        'INSERT INTO SAISON (id_serie, id_saison, nb_episodes, date_debut_tournage, date_fin_tournage)
         VALUES (:id_serie, :id_saison, :nb_episodes, :date_debut_tournage, :date_fin_tournage)'
    );
    $stmt->execute(adminSaisonParams($data));
}

function adminUpdateSaison(array $data): void
{
    $bdd = bddConexion();
    $stmt = $bdd->prepare(
        'UPDATE SAISON
         SET nb_episodes = :nb_episodes, date_debut_tournage = :date_debut_tournage, date_fin_tournage = :date_fin_tournage
         WHERE id_serie = :id_serie AND id_saison = :id_saison'
    );
    $stmt->execute(adminSaisonParams($data));
}

function adminSaisonParams(array $data): array
{
    return [
        ':id_serie' => (int)($data['id_serie'] ?? 0),
        ':id_saison' => (int)($data['id_saison'] ?? 1),
        ':nb_episodes' => (int)($data['nb_episodes'] ?? 1),
        ':date_debut_tournage' => nullIfEmpty($data['date_debut_tournage'] ?? null),
        ':date_fin_tournage' => nullIfEmpty($data['date_fin_tournage'] ?? null),
    ];
}

function adminDeleteSaison(int $idSerie, int $idSaison): void
{
    $bdd = bddConexion();
    $bdd->beginTransaction();
    try {
        $params = [':id_serie' => $idSerie, ':id_saison' => $idSaison];
        $bdd->prepare('DELETE FROM CASTING WHERE id_serie = :id_serie AND id_saison = :id_saison')->execute($params);
        $bdd->prepare('DELETE FROM REALISER WHERE id_serie = :id_serie AND id_saison = :id_saison')->execute($params);
        $bdd->prepare('DELETE FROM SCENARISER WHERE id_serie = :id_serie AND id_saison = :id_saison')->execute($params);
        $bdd->prepare('DELETE FROM PRODUIRE WHERE id_serie = :id_serie AND id_saison = :id_saison')->execute($params);
        $bdd->prepare('DELETE FROM EPISODE WHERE id_serie = :id_serie AND id_saison = :id_saison')->execute($params);
        $bdd->prepare('DELETE FROM SAISON WHERE id_serie = :id_serie AND id_saison = :id_saison')->execute($params);
        $bdd->commit();
    } catch (Throwable $e) {
        $bdd->rollBack();
        throw $e;
    }
}

function adminCreateEpisode(array $data): void
{
    $bdd = bddConexion();
    $stmt = $bdd->prepare(
        'INSERT INTO EPISODE (id_serie, id_saison, id_episode, titre_vo, date_diff_original, date_diff_fr,
                              titre_fr, image_url_path, duree, description)
         VALUES (:id_serie, :id_saison, :id_episode, :titre_vo, :date_diff_original, :date_diff_fr,
                 :titre_fr, :image_url_path, :duree, :description)'
    );
    $stmt->execute(adminEpisodeParams($data));
}

function adminUpdateEpisode(array $data): void
{
    $bdd = bddConexion();
    $stmt = $bdd->prepare(
        'UPDATE EPISODE
         SET titre_vo = :titre_vo, date_diff_original = :date_diff_original, date_diff_fr = :date_diff_fr,
             titre_fr = :titre_fr, image_url_path = :image_url_path, duree = :duree, description = :description
         WHERE id_serie = :id_serie AND id_saison = :id_saison AND id_episode = :id_episode'
    );
    $stmt->execute(adminEpisodeParams($data));
}

function adminEpisodeParams(array $data): array
{
    return [
        ':id_serie' => (int)($data['id_serie'] ?? 0),
        ':id_saison' => (int)($data['id_saison'] ?? 1),
        ':id_episode' => (int)($data['id_episode'] ?? 1),
        ':titre_vo' => nullIfEmpty($data['titre_vo'] ?? null),
        ':date_diff_original' => nullIfEmpty($data['date_diff_original'] ?? null),
        ':date_diff_fr' => nullIfEmpty($data['date_diff_fr'] ?? null),
        ':titre_fr' => trim($data['titre_fr'] ?? ''),
        ':image_url_path' => nullIfEmpty($data['image_url_path'] ?? null),
        ':duree' => nullIfEmpty($data['duree'] ?? null),
        ':description' => nullIfEmpty($data['description'] ?? null),
    ];
}

function adminDeleteEpisode(int $idSerie, int $idSaison, int $idEpisode): void
{
    $bdd = bddConexion();
    $params = [':id_serie' => $idSerie, ':id_saison' => $idSaison, ':id_episode' => $idEpisode];
    $bdd->beginTransaction();
    try {
        $bdd->prepare('DELETE FROM CASTING WHERE id_serie = :id_serie AND id_saison = :id_saison AND id_episode = :id_episode')->execute($params);
        $bdd->prepare('DELETE FROM REALISER WHERE id_serie = :id_serie AND id_saison = :id_saison AND id_episode = :id_episode')->execute($params);
        $bdd->prepare('DELETE FROM SCENARISER WHERE id_serie = :id_serie AND id_saison = :id_saison AND id_episode = :id_episode')->execute($params);
        $bdd->prepare('DELETE FROM EPISODE WHERE id_serie = :id_serie AND id_saison = :id_saison AND id_episode = :id_episode')->execute($params);
        $bdd->commit();
    } catch (Throwable $e) {
        $bdd->rollBack();
        throw $e;
    }
}

function adminCreatePersonnage(array $data): void
{
    $bdd = bddConexion();
    $idPersonnage = uniqid('perso_', true);
    $bdd->beginTransaction();
    try {
        $bdd->prepare('INSERT INTO PERSONNE (id_personne, nom, prenom, image_url_path) VALUES (:id, :nom, :prenom, :image)')
            ->execute([
                ':id' => $idPersonnage,
                ':nom' => trim($data['nom'] ?? ''),
                ':prenom' => trim($data['prenom'] ?? ''),
                ':image' => nullIfEmpty($data['image_url_path'] ?? null),
            ]);
        $bdd->prepare('INSERT INTO PERSONNAGE (id_personnage, desc_perso) VALUES (:id, :description)')
            ->execute([':id' => $idPersonnage, ':description' => nullIfEmpty($data['desc_perso'] ?? null)]);

        if (!empty($data['id_position'])) {
            $bdd->prepare('INSERT INTO ATTACHER (id_personnage, id_position) VALUES (:id, :position)')
                ->execute([':id' => $idPersonnage, ':position' => $data['id_position']]);
        }

        $idActor = adminFindOrCreateActor($bdd, $data);
        adminAttachCastingIfRequested($bdd, $idPersonnage, $idActor, $data);
        $bdd->commit();
    } catch (Throwable $e) {
        $bdd->rollBack();
        throw $e;
    }
}

function adminUpdatePersonnage(array $data): void
{
    $bdd = bddConexion();
    $bdd->beginTransaction();
    try {
        $bdd->prepare('UPDATE PERSONNE SET nom = :nom, prenom = :prenom, image_url_path = :image WHERE id_personne = :id')
            ->execute([
                ':id' => $data['id_personnage'],
                ':nom' => trim($data['nom'] ?? ''),
                ':prenom' => trim($data['prenom'] ?? ''),
                ':image' => nullIfEmpty($data['image_url_path'] ?? null),
            ]);
        $bdd->prepare('UPDATE PERSONNAGE SET desc_perso = :description WHERE id_personnage = :id')
            ->execute([':id' => $data['id_personnage'], ':description' => nullIfEmpty($data['desc_perso'] ?? null)]);
        $bdd->prepare('DELETE FROM ATTACHER WHERE id_personnage = :id')->execute([':id' => $data['id_personnage']]);
        if (!empty($data['id_position'])) {
            $bdd->prepare('INSERT INTO ATTACHER (id_personnage, id_position) VALUES (:id, :position)')
                ->execute([':id' => $data['id_personnage'], ':position' => $data['id_position']]);
        }
        $idActor = adminFindOrCreateActor($bdd, $data);
        adminAttachCastingIfRequested($bdd, $data['id_personnage'], $idActor, $data);
        $bdd->commit();
    } catch (Throwable $e) {
        $bdd->rollBack();
        throw $e;
    }
}

function adminDeletePersonnage(string $idPersonnage): void
{
    $bdd = bddConexion();
    $bdd->beginTransaction();
    try {
        $bdd->prepare('DELETE FROM CASTING WHERE id_personnage = :id')->execute([':id' => $idPersonnage]);
        $bdd->prepare('DELETE FROM ATTACHER WHERE id_personnage = :id')->execute([':id' => $idPersonnage]);
        $bdd->prepare('DELETE FROM PERSONNAGE WHERE id_personnage = :id')->execute([':id' => $idPersonnage]);
        $bdd->prepare('DELETE FROM PERSONNE WHERE id_personne = :id')->execute([':id' => $idPersonnage]);
        $bdd->commit();
    } catch (Throwable $e) {
        $bdd->rollBack();
        throw $e;
    }
}

function adminFindOrCreateActor(PDO $bdd, array $data): ?string
{
    $actorNom = trim($data['acteur_nom'] ?? '');
    $actorPrenom = trim($data['acteur_prenom'] ?? '');

    if ($actorNom === '' || $actorPrenom === '') {
        return null;
    }

    $stmt = $bdd->prepare(
        'SELECT act.id_acteur
         FROM ACTEUR act
         JOIN PERSONNE pe ON act.id_acteur = pe.id_personne
         WHERE LOWER(pe.nom) = LOWER(:nom) AND LOWER(pe.prenom) = LOWER(:prenom)
         LIMIT 1'
    );
    $stmt->execute([':nom' => $actorNom, ':prenom' => $actorPrenom]);
    $existing = $stmt->fetchColumn();
    if ($existing) {
        return (string)$existing;
    }

    $idActor = uniqid('act_', true);
    $bdd->prepare('INSERT INTO PERSONNE (id_personne, nom, prenom, image_url_path) VALUES (:id, :nom, :prenom, :image)')
        ->execute([
            ':id' => $idActor,
            ':nom' => $actorNom,
            ':prenom' => $actorPrenom,
            ':image' => nullIfEmpty($data['acteur_image_url_path'] ?? null),
        ]);
    $bdd->prepare('INSERT INTO ACTEUR (id_acteur) VALUES (:id)')->execute([':id' => $idActor]);

    return $idActor;
}

function adminAttachCastingIfRequested(PDO $bdd, string $idPersonnage, ?string $idActor, array $data): void
{
    $idSerie = (int)($data['casting_id_serie'] ?? 0);
    $idSaison = (int)($data['casting_id_saison'] ?? 0);
    $idEpisode = (int)($data['casting_id_episode'] ?? 0);
    $idDoubleur = $data['id_doubleur'] ?? '';

    if ($idSerie <= 0 || $idSaison <= 0 || $idEpisode <= 0 || $idActor === null || $idDoubleur === '') {
        return;
    }

    $stmt = $bdd->prepare(
        'INSERT INTO CASTING (id_serie, id_saison, id_episode, id_personnage, is_guest_star, id_doubleur, id_acteur)
         VALUES (:id_serie, :id_saison, :id_episode, :id_personnage, :is_guest_star, :id_doubleur, :id_acteur)
         ON CONFLICT (id_serie, id_saison, id_episode, id_personnage)
         DO UPDATE SET is_guest_star = EXCLUDED.is_guest_star,
                       id_doubleur = EXCLUDED.id_doubleur,
                       id_acteur = EXCLUDED.id_acteur'
    );
    $stmt->execute([
        ':id_serie' => $idSerie,
        ':id_saison' => $idSaison,
        ':id_episode' => $idEpisode,
        ':id_personnage' => $idPersonnage,
        ':is_guest_star' => isset($data['is_guest_star']) ? 'true' : 'false',
        ':id_doubleur' => $idDoubleur,
        ':id_acteur' => $idActor,
    ]);
}

function nullIfEmpty(?string $value): ?string
{
    if ($value === null) {
        return null;
    }

    $trimmed = trim($value);
    return $trimmed === '' ? null : $trimmed;
}
