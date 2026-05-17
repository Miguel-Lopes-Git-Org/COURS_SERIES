<?php
require_once __DIR__ . '/../model.php';

function requireAdminAccess(): void
{
    if (!isset($_SESSION['email']) || ($_SESSION['role'] ?? 'user') !== 'admin') {
        http_response_code(403);
        require_once __DIR__ . '/../../templates/pageForbidden.php';
        exit;
    }
}

function controllerPageAdmin(): void
{
    global $adminData, $adminMessages, $adminErrors, $adminTab;

    requireAdminAccess();

    $adminMessages = [];
    $adminErrors = [];
    $action = $_GET['action'] ?? $_POST['action'] ?? 'admin';
    $adminTab = $_GET['tab'] ?? $_POST['tab'] ?? 'series';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = handleAdminPost($action, $_POST);
        $adminMessages = $result['messages'];
        $adminErrors = $result['errors'];
        $adminTab = $result['tab'] ?? $adminTab;
    }

    $adminData = getAdminDashboardData();

    require_once __DIR__ . '/../../templates/pageAdmin.php';
}
