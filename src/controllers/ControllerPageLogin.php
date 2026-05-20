<?php
require_once __DIR__ . '/../model.php';

function controllerPageLogin(): void
{
    $loginErrors    = [];
    $registerErrors = [];
    $authMode = $_GET['action'] ?? $_POST['action'] ?? 'login';
    if (!in_array($authMode, ['login', 'register'], true)) {
        $authMode = 'login';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'login') {
            $authMode = 'login';
            $loginErrors = loginUser(
                trim($_POST['email']    ?? ''),
                trim($_POST['password'] ?? '')
            );

            if (empty($loginErrors)) {
                // Redirection après connexion
                header('Location: ?action=serie');
                exit;
            }
        } elseif ($action === 'register') {
            $authMode = 'register';
            $registerErrors = registerUser($_POST);

            if (empty($registerErrors)) {
                // Redirection après inscription
                $user = getCurrentUserInformations(trim($_POST['email'] ?? ''));
                if ($user !== null) {
                    startUserSession($user);
                }

                header('Location: index.php?action=registerDetails');
                exit;
            }
        }
    }

    require_once __DIR__ . '/../../templates/pageLogin.php';
}

function controllerPageRegisterDetails(): void
{
    if (!isset($_SESSION['email'])) {
        header('Location: ?action=login');
        exit;
    }

    $registerDetailsErrors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'registerDetails') {
            $registerDetailsErrors = completeUserRegistration($_SESSION['email'], $_POST);

            if (empty($registerDetailsErrors)) {
                header('Location: index.php?action=serie');
                exit;
            }
        }
    }

    require_once __DIR__ . '/../../templates/pageRegisterDetails.php';
}
