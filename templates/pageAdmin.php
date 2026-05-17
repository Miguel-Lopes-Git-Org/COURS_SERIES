<?php $title = "Administration"; ?>

<?php ob_start(); ?>

<?php
function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$refs = $adminData['refs'];
$tabs = [
    'series' => 'Series',
    'saisons' => 'Saisons',
    'episodes' => 'Episodes',
    'personnages' => 'Personnages',
];
?>

<div class="px-4 sm:px-8 lg:px-16 py-10 w-full">
    <div class="mb-8">
        <p class="text-sm font-bold uppercase tracking-widest text-red-600 mb-2">Administration</p>
        <h1 class="text-3xl sm:text-4xl font-black text-white">Gestion du site SERIE</h1>
        <p class="text-zinc-400 mt-3">Ces fonctionnalites sont visibles uniquement par les comptes administrateurs.</p>
    </div>

    <?php if (!empty($adminMessages)): ?>
        <div class="mb-6 rounded-lg border border-green-500/30 bg-green-500/10 p-4 text-green-300">
            <?php foreach ($adminMessages as $message): ?>
                <p><?php echo e($message); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($adminErrors)): ?>
        <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 p-4 text-red-300">
            <?php foreach ($adminErrors as $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <nav class="flex flex-wrap gap-3 mb-8">
        <?php foreach ($tabs as $tab => $label): ?>
            <a class="px-4 py-2 rounded-md border <?php echo $adminTab === $tab ? 'bg-red-600 border-red-600 text-white' : 'border-zinc-700 text-zinc-300 hover:bg-zinc-800'; ?>" href="index.php?action=admin&tab=<?php echo e($tab); ?>">
                <?php echo e($label); ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <?php if ($adminTab === 'series'): ?>
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-white mb-4">Ajouter une serie</h2>
            <form method="post" action="index.php" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-5">
                <input type="hidden" name="action" value="adminSerieCreate">
                <input class="form-control" name="titreVF" placeholder="Titre VF" required>
                <input class="form-control" name="titreVO" placeholder="Titre VO">
                <input class="form-control" name="slug" placeholder="slug-serie" required>
                <input class="form-control" type="number" name="nb_saisons" min="1" value="1" placeholder="Nb saisons" required>
                <input class="form-control" type="date" name="date_creation" required>
                <select class="form-control" name="id_pays" required>
                    <option value="">Pays</option>
                    <?php foreach ($refs['pays'] as $pays): ?><option value="<?php echo e($pays['id_pays']); ?>"><?php echo e($pays['nom_pays']); ?></option><?php endforeach; ?>
                </select>
                <select class="form-control" name="id_genre" required>
                    <option value="">Genre</option>
                    <?php foreach ($refs['genres'] as $genre): ?><option value="<?php echo e($genre['id_genre']); ?>"><?php echo e($genre['libelle_genre']); ?></option><?php endforeach; ?>
                </select>
                <select class="form-control" name="id_createur" required>
                    <option value="">Createur</option>
                    <?php foreach ($refs['createurs'] as $createur): ?><option value="<?php echo e($createur['id_createur']); ?>"><?php echo e($createur['nom_complet']); ?></option><?php endforeach; ?>
                </select>
                <input class="form-control" name="image_url_path" placeholder="URL image">
                <input class="form-control" name="banner_path_url" placeholder="URL banniere">
                <input class="form-control" name="video_path_url" placeholder="URL video">
                <input class="form-control" name="musique_generique" placeholder="Musique generique">
                <textarea class="form-control md:col-span-2 xl:col-span-4" name="description" placeholder="Description"></textarea>
                <button class="btn md:col-span-2 xl:col-span-4" type="submit">Ajouter la serie</button>
            </form>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-white mb-4">Series existantes</h2>
            <div class="space-y-4">
                <?php foreach ($adminData['series'] as $serie): ?>
                    <form method="post" action="index.php" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-5">
                        <input type="hidden" name="action" value="adminSerieUpdate">
                        <input type="hidden" name="id_serie" value="<?php echo e($serie['id_serie']); ?>">
                        <input class="form-control" name="titreVF" value="<?php echo e($serie['titrevf']); ?>" required>
                        <input class="form-control" name="titreVO" value="<?php echo e($serie['titrevo']); ?>">
                        <input class="form-control" name="slug" value="<?php echo e($serie['slug']); ?>" required>
                        <input class="form-control" type="number" name="nb_saisons" min="1" value="<?php echo e($serie['nb_saisons']); ?>" required>
                        <input class="form-control" type="date" name="date_creation" value="<?php echo e($serie['date_creation']); ?>" required>
                        <input class="form-control" name="image_url_path" value="<?php echo e($serie['image_url_path']); ?>" placeholder="URL image">
                        <input class="form-control" name="banner_path_url" value="<?php echo e($serie['banner_path_url']); ?>" placeholder="URL banniere">
                        <input class="form-control" name="video_path_url" value="<?php echo e($serie['video_path_url']); ?>" placeholder="URL video">
                        <input class="form-control" name="musique_generique" value="<?php echo e($serie['musique_generique']); ?>" placeholder="Musique">
                        <select class="form-control" name="id_pays" required>
                            <?php foreach ($refs['pays'] as $pays): ?><option value="<?php echo e($pays['id_pays']); ?>" <?php echo $pays['nom_pays'] === $serie['nom_pays'] ? 'selected' : ''; ?>><?php echo e($pays['nom_pays']); ?></option><?php endforeach; ?>
                        </select>
                        <select class="form-control" name="id_genre" required>
                            <?php foreach ($refs['genres'] as $genre): ?><option value="<?php echo e($genre['id_genre']); ?>" <?php echo $genre['libelle_genre'] === $serie['libelle_genre'] ? 'selected' : ''; ?>><?php echo e($genre['libelle_genre']); ?></option><?php endforeach; ?>
                        </select>
                        <select class="form-control" name="id_createur" required>
                            <?php foreach ($refs['createurs'] as $createur): ?><option value="<?php echo e($createur['id_createur']); ?>" <?php echo $createur['nom_complet'] === $serie['createur'] ? 'selected' : ''; ?>><?php echo e($createur['nom_complet']); ?></option><?php endforeach; ?>
                        </select>
                        <textarea class="form-control md:col-span-2 xl:col-span-4" name="description"><?php echo e($serie['description']); ?></textarea>
                        <button class="btn" type="submit">Modifier</button>
                        <button class="btn-secondary border-red-700 text-red-300 hover:bg-red-950" type="submit" name="action" value="adminSerieDelete" onclick="return confirm('Supprimer cette serie et ses dependances ?')">Supprimer</button>
                    </form>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($adminTab === 'saisons'): ?>
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-white mb-4">Ajouter une saison</h2>
            <form method="post" action="index.php" class="grid grid-cols-1 md:grid-cols-5 gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-5">
                <input type="hidden" name="action" value="adminSaisonCreate">
                <select class="form-control" name="id_serie" required><?php foreach ($refs['series'] as $serie): ?><option value="<?php echo e($serie['id_serie']); ?>"><?php echo e($serie['titrevf']); ?></option><?php endforeach; ?></select>
                <input class="form-control" type="number" name="id_saison" min="1" value="1" required>
                <input class="form-control" type="number" name="nb_episodes" min="1" value="1" required>
                <input class="form-control" type="date" name="date_debut_tournage">
                <input class="form-control" type="date" name="date_fin_tournage">
                <button class="btn md:col-span-5" type="submit">Ajouter la saison</button>
            </form>
        </section>

        <section class="space-y-4">
            <?php foreach ($adminData['saisons'] as $saison): ?>
                <form method="post" action="index.php" class="grid grid-cols-1 md:grid-cols-6 gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-5">
                    <input type="hidden" name="id_serie" value="<?php echo e($saison['id_serie']); ?>">
                    <input type="hidden" name="id_saison" value="<?php echo e($saison['id_saison']); ?>">
                    <div class="text-zinc-100 font-semibold md:col-span-2"><?php echo e($saison['titrevf']); ?> - Saison <?php echo e($saison['id_saison']); ?></div>
                    <input class="form-control" type="number" name="nb_episodes" min="1" value="<?php echo e($saison['nb_episodes']); ?>" required>
                    <input class="form-control" type="date" name="date_debut_tournage" value="<?php echo e($saison['date_debut_tournage']); ?>">
                    <input class="form-control" type="date" name="date_fin_tournage" value="<?php echo e($saison['date_fin_tournage']); ?>">
                    <button class="btn" type="submit" name="action" value="adminSaisonUpdate">Modifier</button>
                    <button class="btn-secondary border-red-700 text-red-300 hover:bg-red-950 md:col-start-6" type="submit" name="action" value="adminSaisonDelete" onclick="return confirm('Supprimer cette saison ?')">Supprimer</button>
                </form>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if ($adminTab === 'episodes'): ?>
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-white mb-4">Ajouter un episode</h2>
            <form method="post" action="index.php" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-5">
                <input type="hidden" name="action" value="adminEpisodeCreate">
                <select class="form-control" name="id_serie" required><?php foreach ($refs['series'] as $serie): ?><option value="<?php echo e($serie['id_serie']); ?>"><?php echo e($serie['titrevf']); ?></option><?php endforeach; ?></select>
                <input class="form-control" type="number" name="id_saison" min="1" value="1" required>
                <input class="form-control" type="number" name="id_episode" min="1" value="1" required>
                <input class="form-control" name="titre_fr" placeholder="Titre FR" required>
                <input class="form-control" name="titre_vo" placeholder="Titre VO">
                <input class="form-control" type="date" name="date_diff_original">
                <input class="form-control" name="date_diff_fr" placeholder="Date FR">
                <input class="form-control" type="number" name="duree" min="1" placeholder="Duree">
                <input class="form-control md:col-span-2 xl:col-span-4" name="image_url_path" placeholder="URL image">
                <textarea class="form-control md:col-span-2 xl:col-span-4" name="description" placeholder="Description"></textarea>
                <button class="btn md:col-span-2 xl:col-span-4" type="submit">Ajouter l'episode</button>
            </form>
        </section>

        <section class="space-y-4">
            <?php foreach ($adminData['episodes'] as $episode): ?>
                <form method="post" action="index.php" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-5">
                    <input type="hidden" name="id_serie" value="<?php echo e($episode['id_serie']); ?>">
                    <input type="hidden" name="id_saison" value="<?php echo e($episode['id_saison']); ?>">
                    <input type="hidden" name="id_episode" value="<?php echo e($episode['id_episode']); ?>">
                    <div class="text-zinc-100 font-semibold xl:col-span-4"><?php echo e($episode['titrevf']); ?> - S<?php echo e($episode['id_saison']); ?>E<?php echo e($episode['id_episode']); ?></div>
                    <input class="form-control" name="titre_fr" value="<?php echo e($episode['titre_fr']); ?>" required>
                    <input class="form-control" name="titre_vo" value="<?php echo e($episode['titre_vo']); ?>">
                    <input class="form-control" type="date" name="date_diff_original" value="<?php echo e($episode['date_diff_original']); ?>">
                    <input class="form-control" name="date_diff_fr" value="<?php echo e($episode['date_diff_fr']); ?>">
                    <input class="form-control" type="number" name="duree" min="1" value="<?php echo e($episode['duree']); ?>">
                    <input class="form-control md:col-span-2 xl:col-span-3" name="image_url_path" value="<?php echo e($episode['image_url_path']); ?>">
                    <textarea class="form-control md:col-span-2 xl:col-span-4" name="description"><?php echo e($episode['description']); ?></textarea>
                    <button class="btn" type="submit" name="action" value="adminEpisodeUpdate">Modifier</button>
                    <button class="btn-secondary border-red-700 text-red-300 hover:bg-red-950" type="submit" name="action" value="adminEpisodeDelete" onclick="return confirm('Supprimer cet episode ?')">Supprimer</button>
                </form>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if ($adminTab === 'personnages'): ?>
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-white mb-4">Ajouter un personnage</h2>
            <form method="post" action="index.php" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-5">
                <input type="hidden" name="action" value="adminPersonnageCreate">
                <input class="form-control" name="prenom" placeholder="Prenom personnage" required>
                <input class="form-control" name="nom" placeholder="Nom personnage" required>
                <input class="form-control" name="image_url_path" placeholder="URL image personnage">
                <select class="form-control" name="id_position">
                    <option value="">Position</option>
                    <?php foreach ($refs['positions'] as $position): ?><option value="<?php echo e($position['id_position']); ?>"><?php echo e($position['lib_position']); ?></option><?php endforeach; ?>
                </select>
                <input class="form-control" name="acteur_prenom" placeholder="Prenom acteur/guest">
                <input class="form-control" name="acteur_nom" placeholder="Nom acteur/guest">
                <input class="form-control md:col-span-2" name="acteur_image_url_path" placeholder="URL image acteur">
                <select class="form-control" name="casting_id_serie">
                    <option value="">Serie pour casting</option>
                    <?php foreach ($refs['series'] as $serie): ?><option value="<?php echo e($serie['id_serie']); ?>"><?php echo e($serie['titrevf']); ?></option><?php endforeach; ?>
                </select>
                <input class="form-control" type="number" name="casting_id_saison" min="1" placeholder="Saison casting">
                <input class="form-control" type="number" name="casting_id_episode" min="1" placeholder="Episode casting">
                <select class="form-control" name="id_doubleur">
                    <option value="">Doubleur</option>
                    <?php foreach ($refs['doubleurs'] as $doubleur): ?><option value="<?php echo e($doubleur['id_doubleur']); ?>"><?php echo e($doubleur['nom_complet']); ?></option><?php endforeach; ?>
                </select>
                <label class="flex items-center gap-3 text-sm text-zinc-300 md:col-span-2 xl:col-span-4">
                    <input type="checkbox" name="is_guest_star" value="1" class="h-4 w-4">
                    Guest star pour ce casting
                </label>
                <textarea class="form-control md:col-span-2 xl:col-span-4" name="desc_perso" placeholder="Description du personnage"></textarea>
                <button class="btn md:col-span-2 xl:col-span-4" type="submit">Ajouter le personnage</button>
            </form>
        </section>

        <section class="space-y-4">
            <?php foreach ($adminData['personnages'] as $personnage): ?>
                <form method="post" action="index.php" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 bg-zinc-900 border border-zinc-800 rounded-lg p-5">
                    <input type="hidden" name="id_personnage" value="<?php echo e($personnage['id_personnage']); ?>">
                    <input class="form-control" name="prenom" value="<?php echo e($personnage['prenom']); ?>" required>
                    <input class="form-control" name="nom" value="<?php echo e($personnage['nom']); ?>" required>
                    <input class="form-control" name="image_url_path" value="<?php echo e($personnage['image_url_path']); ?>">
                    <select class="form-control" name="id_position">
                        <option value="">Position actuelle: <?php echo e($personnage['positions']); ?></option>
                        <?php foreach ($refs['positions'] as $position): ?><option value="<?php echo e($position['id_position']); ?>"><?php echo e($position['lib_position']); ?></option><?php endforeach; ?>
                    </select>
                    <input class="form-control" name="acteur_prenom" placeholder="Prenom nouvel acteur">
                    <input class="form-control" name="acteur_nom" placeholder="Nom nouvel acteur">
                    <input class="form-control md:col-span-2" name="acteur_image_url_path" placeholder="URL image acteur">
                    <select class="form-control" name="casting_id_serie">
                        <option value="">Serie pour casting</option>
                        <?php foreach ($refs['series'] as $serie): ?><option value="<?php echo e($serie['id_serie']); ?>"><?php echo e($serie['titrevf']); ?></option><?php endforeach; ?>
                    </select>
                    <input class="form-control" type="number" name="casting_id_saison" min="1" placeholder="Saison casting">
                    <input class="form-control" type="number" name="casting_id_episode" min="1" placeholder="Episode casting">
                    <select class="form-control" name="id_doubleur">
                        <option value="">Doubleur</option>
                        <?php foreach ($refs['doubleurs'] as $doubleur): ?><option value="<?php echo e($doubleur['id_doubleur']); ?>"><?php echo e($doubleur['nom_complet']); ?></option><?php endforeach; ?>
                    </select>
                    <label class="flex items-center gap-3 text-sm text-zinc-300 md:col-span-2 xl:col-span-4">
                        <input type="checkbox" name="is_guest_star" value="1" class="h-4 w-4">
                        Guest star pour ce casting
                    </label>
                    <textarea class="form-control md:col-span-2 xl:col-span-4" name="desc_perso"><?php echo e($personnage['desc_perso']); ?></textarea>
                    <button class="btn" type="submit" name="action" value="adminPersonnageUpdate">Modifier</button>
                    <button class="btn-secondary border-red-700 text-red-300 hover:bg-red-950" type="submit" name="action" value="adminPersonnageDelete" onclick="return confirm('Supprimer ce personnage ?')">Supprimer</button>
                </form>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>
