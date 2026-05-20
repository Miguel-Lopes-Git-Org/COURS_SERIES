<?php $title = "Completer l'inscription"; ?>

<?php ob_start(); ?>

<div class="fixed inset-0 z-[-1] pointer-events-none">
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('https://assets.nflxext.com/ffe/siteui/vlv3/ab180a27-b661-44d7-a6d9-940cb32f2f4a/7fb62e44-31fd-4e1c-b6ae-e1c538dd8cb6/FR-fr-20231009-popsignuptwoweeks-perspective_alpha_website_medium.jpg');"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-zinc-950/80 to-zinc-950/90"></div>
</div>

<div class="min-h-[calc(100vh-4rem)] flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-2xl glass-panel p-8 sm:p-12 mt-4 mb-16">
        <h1 class="text-3xl font-bold text-white mb-3">Completer l'inscription</h1>
        <p class="text-zinc-400 text-sm mb-8">Renseigne tes informations de profil et ta carte pour finaliser ton compte.</p>

        <?php if (!empty($registerDetailsErrors)): ?>
            <div class="mb-6 p-4 rounded-md bg-red-500/10 border border-red-500/20 text-red-500 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    <?php foreach ($registerDetailsErrors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="index.php" method="post" class="space-y-4">
            <input type="hidden" name="action" value="registerDetails">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input class="form-control" type="text" name="firstName" placeholder="Prenom" required value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>">
                <input class="form-control" type="text" name="lastName" placeholder="Nom" required value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>">
            </div>

            <div>
                <input class="form-control" type="tel" name="phoneNumber" placeholder="Telephone" required value="<?= htmlspecialchars($_POST['phoneNumber'] ?? '') ?>">
            </div>

            <div>
                <input class="form-control" type="text" name="streetAddress" placeholder="Adresse complete" required value="<?= htmlspecialchars($_POST['streetAddress'] ?? '') ?>">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input class="form-control" type="text" name="zipCode" placeholder="Code postal" required value="<?= htmlspecialchars($_POST['zipCode'] ?? '') ?>">
                <input class="form-control" type="text" name="city" placeholder="Ville" required value="<?= htmlspecialchars($_POST['city'] ?? '') ?>">
            </div>

            <div>
                <input class="form-control" type="text" name="cardNumber" placeholder="Numero de carte" inputmode="numeric" autocomplete="cc-number" required>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input class="form-control" type="password" name="cardCvv" placeholder="CCV" inputmode="numeric" autocomplete="cc-csc" required minlength="3" maxlength="4">
                <input class="form-control" type="text" name="cardExpiration" placeholder="Expiration MM/AA" autocomplete="cc-exp" required value="<?= htmlspecialchars($_POST['cardExpiration'] ?? '') ?>">
            </div>

            <button class="btn w-full mt-8 py-3.5 text-lg" type="submit">Finaliser l'inscription</button>
        </form>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>
