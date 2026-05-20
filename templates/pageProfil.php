<?php $title = "Mon profil"; ?>

<?php ob_start(); ?>

<?php
$fields = [
    'email' => 'Adresse e-mail',
    'firstname' => 'Prenom',
    'lastname' => 'Nom',
    'phonenumber' => 'Telephone',
    'streetaddress' => 'Adresse',
    'zipcode' => 'Code postal',
    'city' => 'Ville',
    'maskedcardnumber' => 'Carte bancaire',
    'role' => 'Role',
];
?>

<div class="px-4 sm:px-8 lg:px-16 py-10 w-full max-w-5xl mx-auto">
    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-widest text-red-600 mb-2">Compte utilisateur</p>
        <h1 class="text-3xl sm:text-4xl font-black text-white">Mon profil</h1>
        <p class="text-zinc-400 mt-3">Informations renseignees lors de l'inscription.</p>
    </div>

    <?php if (!empty($currentUser)): ?>
        <div class="bg-zinc-900 border border-zinc-800 rounded-lg overflow-hidden">
            <?php foreach ($fields as $key => $label): ?>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 px-5 py-4 border-b border-zinc-800 last:border-b-0">
                    <div class="text-sm font-semibold text-zinc-500 uppercase tracking-wide"><?php echo htmlspecialchars($label); ?></div>
                    <div class="sm:col-span-2 text-zinc-100">
                        <?php echo htmlspecialchars((string)($currentUser[$key] ?? 'Non renseigne')); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-8">
            <p class="text-zinc-400">Impossible de charger les informations du profil.</p>
        </div>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>
