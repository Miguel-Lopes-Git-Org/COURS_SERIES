<?php $title = "Détails de la série" ?>

<?php ob_start(); ?>

<?php if ($fetchSerieDetails): ?>
    <div class="relative w-full overflow-hidden min-h-[60vh] md:min-h-[85vh] lg:min-h-[95vh] mb-12">
        <div class="absolute inset-0 bg-zinc-950">
            <?php 
            $videoUrl = $fetchSerieDetails->getVideoPathUrl();
            if ($videoUrl): 
                // Detection simple d'URL youtube et extraction de l'ID
                $ytMatch = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $videoUrl, $match);
                if ($ytMatch && !empty($match[1])):
                    $ytId = $match[1];
            ?>
                <!-- YouTube Iframe Background -->
                <div class="video-background-wrapper absolute inset-0 w-full h-full overflow-hidden pointer-events-none opacity-40">
                    <iframe 
                        class="absolute top-1/2 left-1/2 w-[150vw] h-[150vh] min-w-[100vw] min-h-[100vh] -translate-x-1/2 -translate-y-1/2 object-cover"
                        src="https://www.youtube.com/embed/<?php echo $ytId; ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo $ytId; ?>&controls=0&showinfo=0&autohide=1&modestbranding=1&rel=0&iv_load_policy=3" 
                        frameborder="0" 
                        allow="autoplay; encrypted-media" 
                        allowfullscreen>
                    </iframe>
                </div>
            <?php else: ?>
                <!-- HTML5 Native Video Fallback -->
                <video autoplay loop muted playsinline class="absolute w-full h-full object-cover opacity-40 select-none pointer-events-none">
                    <source src="<?php echo htmlspecialchars($videoUrl); ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            
            <?php else: ?>
                <?php 
                $bgImage = $fetchSerieDetails->getBannerPathUrl() ?: $fetchSerieDetails->getImageUrlPath();
                if ($bgImage): 
                ?>
                    <img class="absolute w-full h-full object-cover opacity-40 select-none animate-in fade-in duration-1000" src="<?php echo htmlspecialchars($bgImage); ?>" alt="Image de <?php echo htmlspecialchars($fetchSerieDetails->getTitreVF()); ?>">
                <?php else: ?>
                    <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-900 to-zinc-950 z-10"></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <div class="absolute inset-0 z-20 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
        <div class="absolute inset-0 z-20 bg-gradient-to-r from-zinc-950 via-zinc-950/60 to-transparent"></div>
        
        <div class="absolute inset-0 z-30 flex flex-col justify-end px-4 sm:px-8 lg:px-16 pb-16 pt-32">
            <div class="max-w-3xl">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight mb-2 drop-shadow-2xl">
                    <?php echo htmlspecialchars($fetchSerieDetails->getTitreVF()); ?>
                </h1>
                
                <?php if ($fetchSerieDetails->getTitreVO() && $fetchSerieDetails->getTitreVO() !== $fetchSerieDetails->getTitreVF()): ?>
                    <h2 class="text-xl sm:text-2xl font-bold text-zinc-400 italic mb-4 drop-shadow-md">
                        <?php echo htmlspecialchars($fetchSerieDetails->getTitreVO()); ?>
                    </h2>
                <?php endif; ?>
                
                <div class="flex flex-wrap items-center gap-4 text-sm sm:text-base text-zinc-300 font-medium mb-6">
                    <span class="text-green-500 font-bold"><?= htmlspecialchars($fetchSerieDetails->getDateCreation()) ?></span>
                    <span class="px-2 py-0.5 border border-zinc-600 rounded bg-zinc-800/80"><?php echo htmlspecialchars($fetchSerieDetails->getNbSaisons()); ?> Saisons</span>
                    <span class="px-2 py-0.5 border border-zinc-600 rounded bg-zinc-800/80">HD</span>
                    <span><?php echo htmlspecialchars($fetchSerieDetails->getGenre()); ?></span>
                </div>

                <p class="text-lg text-zinc-200 leading-relaxed mb-8 drop-shadow-md">
                    <?php echo htmlspecialchars($fetchSerieDetails->getDescription()); ?>
                </p>



                <div class="flex flex-wrap gap-4 mb-10">
                    <a href="index.php?action=saisonDetail&slug=<?php echo urlencode($fetchSerieDetails->getSlug()); ?>&saison=1" class="bg-white text-black px-8 py-3.5 rounded md:text-lg font-bold flex items-center hover:bg-zinc-200 transition shadow-lg">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-2"><path d="M8 5v14l11-7z"/></svg>
                        Saison 1
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-8 text-sm text-zinc-400">
                    <p><span class="text-zinc-500">Durée moyenne :</span> <span class="text-zinc-200"><?php echo htmlspecialchars($fetchSerieDetails->getDureeMoyenneEpisodes()); ?> mins</span></p>
                    <p><span class="text-zinc-500">Pays :</span> <span class="text-zinc-200"><?php echo htmlspecialchars($fetchSerieDetails->getPays()); ?></span></p>
                    <p><span class="text-zinc-500">Générique :</span> <span class="text-zinc-200"><?php echo htmlspecialchars($fetchSerieDetails->getMusiqueGenerique()); ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="px-4 sm:px-8 lg:px-16 pb-20 w-full relative z-40">
        <?php if (!empty($fetchSerieDetails->getChaineDiffusion())): ?>
            <section class="mb-12">
                <h2 class="text-xl sm:text-2xl font-bold text-zinc-100 mb-6">Diffusions</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    <?php foreach ($fetchSerieDetails->getChaineDiffusion() as $diffusion): ?>
                        <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-5 flex items-center justify-between hover:border-zinc-700 transition-colors">
                            <div>
                                <h3 class="font-bold text-zinc-100"><?php echo htmlspecialchars($diffusion->getNomChaine()); ?></h3>
                                <p class="text-sm text-zinc-500">Canal <?php echo htmlspecialchars($diffusion->getNumeroChaine()); ?> • <?php echo htmlspecialchars($diffusion->getPays()); ?></p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" /></svg>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="min-h-[50vh] flex items-center justify-center">
        <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-10 text-center max-w-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-zinc-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <h2 class="text-xl font-bold text-zinc-100 mb-2">Série introuvable</h2>
            <p class="text-zinc-500 mb-6">Nous ne parvenons pas à trouver les détails pour cette série.</p>
            <a href="index.php?action=serie" class="btn-secondary">Retour aux séries</a>
        </div>
    </div>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>