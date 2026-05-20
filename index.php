<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once("src/controllers/ControllerPageLogin.php");
require_once("src/controllers/ControllerPageSerie.php");
require_once("src/controllers/ControllerPageSerieDetail.php");
require_once("src/controllers/ControllerPageSaisonDetail.php");
require_once("src/controllers/ControllerPageEpisode.php");
require_once("src/controllers/ControllerPageProfil.php");
require_once("src/controllers/ControllerPageAdmin.php");

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'logout') {
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
    header('Location: ?action=login');
    exit;
}

// Pages accessibles sans être connecté
$publicActions = ['login', 'register'];

if (!isset($_SESSION['email']) && !in_array($action, $publicActions)) {
    // echo "Vous devez être connecté pour accéder à cette page.";
    controllerPageLogin();
    exit;
}

// Routage basé sur le paramètre 'action' dans l'URL
if ($action) {
    switch ($action) {
        case 'login':
            controllerPageLogin();
            break;
        case 'register':
            controllerPageLogin();
            break;
        case 'registerDetails':
            controllerPageRegisterDetails();
            break;
        case 'serie':
            controllerPageSerie();
            break;
        case 'serieDetail':
            controllerPageSerieDetail();
            break;
        case 'saisonDetail':
            controllerPageSaisonDetail();
            break;
        case 'episodeDetail':
            controllerPageEpisodeDetail();
            break;
        case 'profil':
            controllerPageProfil();
            break;
        case 'admin':
        case 'adminSerieCreate':
        case 'adminSerieUpdate':
        case 'adminSerieDelete':
        case 'adminSaisonCreate':
        case 'adminSaisonUpdate':
        case 'adminSaisonDelete':
        case 'adminEpisodeCreate':
        case 'adminEpisodeUpdate':
        case 'adminEpisodeDelete':
        case 'adminPersonnageCreate':
        case 'adminPersonnageUpdate':
        case 'adminPersonnageDelete':
            controllerPageAdmin();
            break;
        default:
            controllerPageLogin();
            break;
    }
} else {
    if (isset($_SESSION['email'])) {
        controllerPageSerie();
    } else {
        controllerPageLogin();
    }
}
