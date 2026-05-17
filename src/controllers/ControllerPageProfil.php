<?php
require_once __DIR__ . '/../model.php';

function controllerPageProfil(): void
{
    global $currentUser;

    if (!isset($_SESSION['email'])) {
        header('Location: ?action=login');
        exit;
    }

    $currentUser = getCurrentUserInformations($_SESSION['email']);

    require_once __DIR__ . '/../../templates/pageProfil.php';
}
