<?php $title = "Acces refuse"; ?>

<?php ob_start(); ?>

<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-10 max-w-lg text-center">
        <h1 class="text-2xl font-bold text-white mb-3">Acces refuse</h1>
        <p class="text-zinc-400 mb-6">Cette page est reservee aux administrateurs.</p>
        <a class="btn-secondary" href="index.php?action=serie">Retour aux series</a>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>
