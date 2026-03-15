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
                header('Location: index.php?action=login&registered=1');
                exit;
            }
        }
    }

    require_once __DIR__ . '/../../templates/pageLogin.php';
}
