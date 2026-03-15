<?php $title = "Détail de l'épisode" ?>

<?php ob_start(); ?>

<?php if ($episodeDetail): ?>
<div class="px-4 sm:px-8 lg:px-16 max-w-[1920px] mx-auto py-8 lg:py-12">
    
    <!-- Header Section -->
    <div class="mb-10">
        <a class="inline-flex items-center text-zinc-400 hover:text-white mb-6 transition-colors" href="index.php?action=saisonDetail&slug=<?php echo urlencode($fetchSerieDetails->getSlug()); ?>&saison=<?php echo urlencode((string)$selectedSeason); ?>">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour à la saison <?php echo htmlspecialchars((string)$selectedSeason); ?>
        </a>

        <div class="flex flex-col md:flex-row gap-6 md:items-end border-b border-zinc-800 pb-8">
            <div class="flex-grow">
                <div class="text-sm font-bold text-red-600 tracking-widest uppercase mb-2">
                    <?php echo htmlspecialchars($fetchSerieDetails->getTitreVF()); ?> • Saison <?php echo htmlspecialchars((string)$selectedSeason); ?> • Épisode <?php echo htmlspecialchars((string)$selectedEpisode); ?>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-2">
                    <?php echo htmlspecialchars($episodeDetail->getTitreFr()); ?>
                </h1>
                <p class="text-lg text-zinc-500 italic">
                    <?php echo htmlspecialchars($episodeDetail->getTitreVo()); ?>
                </p>
            </div>
            
            <div class="flex flex-col gap-1 text-sm bg-zinc-900 border border-zinc-800 p-4 rounded-lg min-w-48 text-zinc-300 shadow-lg">
                <p><strong>Diff. USA :</strong> <span class="text-zinc-100"><?php echo htmlspecialchars((string)$episodeDetail->getDateDiffusionUsa()); ?></span></p>
                <p><strong>Diff. FR :</strong> <span class="text-zinc-100"><?php echo htmlspecialchars((string)$episodeDetail->getDateDiffusionFr()); ?></span></p>
            </div>
        </div>
    </div>

    <!-- Synopsis -->
    <div class="mb-12 max-w-4xl">
        <h3 class="text-xl font-bold text-white mb-4 flex items-center">
            <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Synopsis
        </h3>
        <p class="text-lg text-zinc-300 leading-relaxed bg-zinc-900/50 p-6 rounded-xl border border-zinc-800/50">
            <?php echo nl2br(htmlspecialchars((string)$episodeDetail->getResume())); ?>
        </p>
    </div>

    <!-- Cast & Crew Grid Layout -->
    <div class="space-y-12">
        
        <!-- Personnages / Acteurs -->
        <section>
            <h3 class="text-2xl font-bold text-white mb-6 border-l-4 border-red-600 pl-3">Acteurs & Personnages</h3>
            <?php if (!empty($episodePersonnages)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    <?php foreach ($episodePersonnages as $personnage): ?>
                        <div class="bg-zinc-900 border border-zinc-800 rounded-lg overflow-hidden hover:bg-zinc-800 transition-colors group">
                            <!-- Image placeholder with icon -->
                            <div class="w-full aspect-square bg-zinc-950 flex items-center justify-center border-b border-zinc-800 relative">
                                <?php if (!empty($personnage['image_url_path'])): ?>
                                    <img src="<?= htmlspecialchars($personnage['image_url_path']) ?>" alt="<?= htmlspecialchars($personnage['nom'] ?? '') ?>" class="absolute inset-0 w-full h-full object-cover">
                                <?php else: ?>
                                    <svg class="w-16 h-16 text-zinc-700 group-hover:text-zinc-500 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                <?php endif; ?>
                            </div>
                            <div class="p-4 text-center">
                                <h4 class="font-bold text-zinc-100 text-sm mb-1 truncate">
                                    <?php echo htmlspecialchars(trim(($personnage['prenom'] ?? '') . ' ' . ($personnage['nom'] ?? ''))); ?>
                                </h4>
                                
                                <div class="text-xs text-zinc-500 space-y-1">
                                    <?php if (!empty($personnage['acteur_prenom']) || !empty($personnage['acteur_nom'])): ?>
                                        <p class="truncate"><span class="italic">Joué par</span> <span class="text-zinc-300"><?php echo htmlspecialchars(trim(($personnage['acteur_prenom'] ?? '') . ' ' . ($personnage['acteur_nom'] ?? ''))); ?></span></p>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($personnage['doubleur_prenom']) || !empty($personnage['doubleur_nom'])): ?>
                                        <p class="truncate"><span class="italic">VF par</span> <span class="text-zinc-400"><?php echo htmlspecialchars(trim(($personnage['doubleur_prenom'] ?? '') . ' ' . ($personnage['doubleur_nom'] ?? ''))); ?></span></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-zinc-500 italic">Aucun personnage renseigné pour cet épisode.</p>
            <?php endif; ?>
        </section>

        <!-- Guest Stars -->
        <section>
            <h3 class="text-2xl font-bold text-white mb-6 border-l-4 border-yellow-500/70 pl-3">Guest Stars</h3>
            <?php if (!empty($episodeGuestStars)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    <?php foreach ($episodeGuestStars as $guestStar): ?>
                        <div class="bg-zinc-900 border border-zinc-800 rounded-lg overflow-hidden hover:bg-zinc-800 transition-colors group">
                            <!-- Image placeholder with icon -->
                            <div class="w-full aspect-square bg-zinc-950 flex items-center justify-center border-b border-zinc-800 relative">
                                <?php if ($guestStar->getImageUrlPath()): ?>
                                    <img src="<?= htmlspecialchars($guestStar->getImageUrlPath()) ?>" alt="<?= htmlspecialchars($guestStar->getNomComplet()) ?>" class="absolute inset-0 w-full h-full object-cover">
                                <?php else: ?>
                                    <svg class="w-16 h-16 text-yellow-500/30 group-hover:text-yellow-500/50 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <?php endif; ?>
                            </div>
                            <div class="p-4 text-center">
                                <h4 class="font-bold text-zinc-100 text-sm mb-1 truncate">
                                    <?php echo htmlspecialchars($guestStar->getNomComplet()); ?>
                                </h4>
                                <p class="text-xs text-zinc-500 italic"><?php echo htmlspecialchars($guestStar->getPosition()->getLibelle()); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-zinc-500 italic">Aucun guest star renseigné pour cet épisode.</p>
            <?php endif; ?>
        </section>

        <!-- Scénaristes et Réalisateurs Grid Layout -->
        <section>
            <h3 class="text-2xl font-bold text-white mb-6 border-l-4 border-zinc-500 pl-3">Équipe de production</h3>
            
            <?php if (!empty($episodeScenaristes) || !empty($episodeRealisateurs)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    
                    <!-- Scénaristes -->
                    <?php if (!empty($episodeScenaristes)): ?>
                        <?php foreach ($episodeScenaristes as $scenariste): ?>
                            <div class="bg-zinc-900 border border-zinc-800 rounded-lg overflow-hidden hover:bg-zinc-800 transition-colors group">
                                <!-- Image placeholder with icon -->
                                <div class="w-full aspect-square bg-zinc-950 flex items-center justify-center border-b border-zinc-800 relative">
                                    <?php if ($scenariste->getImageUrlPath()): ?>
                                        <img src="<?= htmlspecialchars($scenariste->getImageUrlPath()) ?>" alt="<?= htmlspecialchars($scenariste->getNomComplet()) ?>" class="absolute inset-0 w-full h-full object-cover">
                                    <?php else: ?>
                                        <svg class="w-16 h-16 text-zinc-700 group-hover:text-zinc-500 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4 text-center">
                                    <h4 class="font-bold text-zinc-100 text-sm mb-1 truncate">
                                        <?php echo htmlspecialchars($scenariste->getNomComplet()); ?>
                                    </h4>
                                    <p class="text-xs text-zinc-500 italic">Scénariste</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Réalisateurs -->
                    <?php if (!empty($episodeRealisateurs)): ?>
                        <?php foreach ($episodeRealisateurs as $realisateur): ?>
                            <div class="bg-zinc-900 border border-zinc-800 rounded-lg overflow-hidden hover:bg-zinc-800 transition-colors group">
                                <!-- Image placeholder with icon -->
                                <div class="w-full aspect-square bg-zinc-950 flex items-center justify-center border-b border-zinc-800 relative">
                                    <?php if ($realisateur->getImageUrlPath()): ?>
                                        <img src="<?= htmlspecialchars($realisateur->getImageUrlPath()) ?>" alt="<?= htmlspecialchars($realisateur->getNomComplet()) ?>" class="absolute inset-0 w-full h-full object-cover">
                                    <?php else: ?>
                                        <svg class="w-16 h-16 text-zinc-700 group-hover:text-zinc-500 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4 text-center">
                                    <h4 class="font-bold text-zinc-100 text-sm mb-1 truncate">
                                        <?php echo htmlspecialchars($realisateur->getNomComplet()); ?>
                                    </h4>
                                    <p class="text-xs text-zinc-500 italic">Réalisateur</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            <?php else: ?>
                <p class="text-zinc-500 italic">Aucun membre de l'équipe de production renseigné.</p>
            <?php endif; ?>
        </section>
        
    </div>

</div>
<?php else: ?>
    <div class="min-h-[50vh] flex items-center justify-center">
        <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-10 text-center max-w-lg">
            <h2 class="text-xl font-bold text-zinc-100 mb-2">Épisode introuvable</h2>
            <p class="text-zinc-500 mb-6">Nous ne parvenons pas à trouver les détails pour cet épisode.</p>
            <a href="index.php?action=serie" class="btn-secondary">Retour aux séries</a>
        </div>
    </div>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>