<?php $title = "Connexion / Créer un compte" ?>

<?php ob_start(); ?>

<!-- Background Image with Overlay -->
<div class="fixed inset-0 z-[-1] pointer-events-none">
    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('https://assets.nflxext.com/ffe/siteui/vlv3/ab180a27-b661-44d7-a6d9-940cb32f2f4a/7fb62e44-31fd-4e1c-b6ae-e1c538dd8cb6/FR-fr-20231009-popsignuptwoweeks-perspective_alpha_website_medium.jpg');"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-zinc-950/80 to-zinc-950/90"></div>
</div>

<div class="min-h-[calc(100vh-4rem)] flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-md glass-panel p-8 sm:p-12 mt-4 mb-16">
        
        <h1 class="text-3xl font-bold text-white mb-6">
            <?php echo ($authMode === 'register') ? 'Créer un compte' : 'Me connecter'; ?>
        </h1>

        <?php if ($authMode === 'register'): ?>
            <p class="text-zinc-400 text-sm mb-8">
                Prêt à regarder ? Commence par créer ton compte exclusif.
            </p>

            <?php if (!empty($registerErrors)): ?>
                <div class="mb-6 p-4 rounded-md bg-red-500/10 border border-red-500/20 text-red-500 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        <?php foreach ($registerErrors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="index.php" method="post" class="space-y-4">
                <input type="hidden" name="action" value="register">

                <div>
                    <input class="form-control" type="email" name="email" placeholder="Adresse e-mail" required>
                </div>

                <div>
                    <input class="form-control" type="password" name="password" placeholder="Mot de passe" required minlength="12" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{12,}" title="Au moins 12 caractères, 1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial">
                </div>

                <div>
                    <input class="form-control" type="password" name="password_confirm" placeholder="Confirmer le mot de passe" required minlength="12">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <input class="form-control" type="text" name="firstName" placeholder="Prénom" required>
                    <input class="form-control" type="text" name="lastName" placeholder="Nom" required>
                </div>

                <div>
                    <input class="form-control" type="tel" name="phoneNumber" placeholder="Téléphone">
                </div>

                <div>
                    <input class="form-control" type="text" name="streetAddress" placeholder="Adresse complète">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <input class="form-control" type="text" name="zipCode" placeholder="Code postal">
                    <input class="form-control" type="text" name="city" placeholder="Ville">
                </div>

                <button class="btn w-full mt-8 py-3.5 text-lg" type="submit">Créer le compte</button>
            </form>

            <div class="mt-8 text-zinc-400 text-sm">
                Tu as déjà un compte ? 
                <a class="text-white hover:underline transition-all" href="index.php?action=login">Inscris-toi dès maintenant.</a>
            </div>

        <?php else: ?>

            <?php if (!empty($loginErrors)): ?>
                <div class="mb-6 p-4 rounded-md bg-red-500/10 border border-red-500/20 text-red-500 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        <?php foreach ($loginErrors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="index.php" method="post" class="space-y-6">
                <input type="hidden" name="action" value="login">

                <div>
                    <input class="form-control py-3.5" type="email" name="email" placeholder="Adresse e-mail" required>
                </div>

                <div>
                    <input class="form-control py-3.5" type="password" name="password" placeholder="Mot de passe" required>
                </div>

                <button class="btn w-full py-3.5 text-lg" type="submit">S'identifier</button>
            </form>

            <div class="mt-12 text-zinc-400">
                Première visite sur Series ? 
                <a class="text-white hover:underline transition-all" href="index.php?action=register">S'inscrire maintenant.</a>
            </div>

        <?php endif; ?>
    </div>

</div>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>
