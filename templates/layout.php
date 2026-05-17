<!DOCTYPE html>
<html lang="fr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script src="templates/tailwind.js?v=<?= time() ?>"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="templates/style.css">
</head>

<body class="bg-zinc-950 text-zinc-100 min-h-screen flex flex-col pt-16 selection:bg-red-600 selection:text-white">
    <?php $currentAction = $_GET['action'] ?? $_POST['action'] ?? ''; ?>
    <?php $isConnected = isset($_SESSION['email']); ?>
    <?php $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; ?>

    <nav class="fixed top-0 left-0 right-0 z-50 bg-zinc-950/80 backdrop-blur-md border-b border-zinc-800 transition-all duration-300">
        <div class="w-full px-4 sm:px-8 lg:px-12 flex items-center justify-between h-16">
            <!-- Brand -->
            <a class="text-3xl font-bold text-red-600 tracking-tighter hover:scale-105 transition-transform" href="<?= $isConnected ? 'index.php?action=serie' : 'index.php?action=login' ?>">
                SERIES
            </a>

            <!-- Navigation Links -->
            <ul class="flex items-center space-x-6 text-sm font-medium">
                <?php if ($isConnected): ?>
                    <li><a class="text-zinc-300 hover:text-white transition-colors <?= $currentAction === 'serie' ? 'text-white font-semibold' : '' ?>" href="?action=serie">Séries</a></li>
                    <li><a class="text-zinc-300 hover:text-white transition-colors <?= $currentAction === 'profil' ? 'text-white font-semibold' : '' ?>" href="?action=profil">Profil</a></li>
                    <?php if ($isAdmin): ?>
                        <li><a class="text-zinc-300 hover:text-white transition-colors <?= str_starts_with($currentAction, 'admin') ? 'text-white font-semibold' : '' ?>" href="?action=admin">Admin</a></li>
                    <?php endif; ?>
                    <li><a class="text-zinc-400 hover:text-white transition-colors" href="?action=logout">Déconnexion</a></li>
                <?php else: ?>
                    <li><a class="text-zinc-300 hover:text-white transition-colors <?= $currentAction === 'login' ? 'text-white font-semibold' : '' ?>" href="?action=login">Connexion</a></li>
                    <li><a class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors <?= $currentAction === 'register' ? 'bg-red-700' : '' ?>" href="?action=register">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main class="flex-grow w-full flex flex-col relative">
        <?= $content ?? '' ?>
    </main>

    <footer class="mt-auto py-8 text-center text-sm text-zinc-500 border-t border-zinc-900 bg-zinc-950">
        <div class="w-full px-4">
            <p>&copy; <?= date('Y') ?> Series. Tous droits réservés.</p>
        </div>
    </footer>
</body>

</html>
