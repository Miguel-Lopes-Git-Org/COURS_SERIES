<?php $title = "Séries" ?>

<?php ob_start(); ?>

<?php 
// Pick a random series for the hero
$heroSerie = null;
if (!empty($fetchSeries)) {
    $randomIndex = array_rand($fetchSeries);
    $heroSerie = $fetchSeries[$randomIndex];
}
?>
<!-- Hero banner catalog -->
<?php if ($heroSerie): ?>
<div class="relative w-full overflow-hidden h-72 sm:h-96 md:h-[60vh] lg:h-[85vh] mb-8">
    <div class="absolute inset-0 bg-zinc-900">
        <!-- Optional fallback gradient for the generic catalog if no background is set -->
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/80 to-transparent z-10"></div>
        
        <?php 
        $heroVideo = $heroSerie->getVideoPathUrl();
        $heroBg = $heroSerie->getBannerPathUrl() ?: $heroSerie->getImageUrlPath();
        
        if ($heroVideo): 
            $ytMatch = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $heroVideo, $match);
            if ($ytMatch && !empty($match[1])):
                $ytId = $match[1];
        ?>
            <!-- YouTube Iframe Background -->
            <div class="video-background-wrapper absolute inset-0 w-full h-full overflow-hidden pointer-events-none opacity-40">
                <iframe 
                    class="absolute top-1/2 left-1/2 w-[150vw] h-[150vh] min-w-screen min-h-screen -translate-x-1/2 -translate-y-1/2 object-cover"
                    src="https://www.youtube.com/embed/<?php echo $ytId; ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo $ytId; ?>&controls=0&showinfo=0&autohide=1&modestbranding=1&rel=0&iv_load_policy=3" 
                    frameborder="0" 
                    allow="autoplay; encrypted-media" 
                    allowfullscreen>
                </iframe>
            </div>
        <?php else: ?>
            <video autoplay loop muted playsinline class="absolute w-full h-full object-cover opacity-40 select-none pointer-events-none">
                <source src="<?= htmlspecialchars($heroVideo) ?>" type="video/mp4">
            </video>
        <?php endif; ?>
        <?php elseif ($heroBg): ?>
            <img src="<?= htmlspecialchars($heroBg) ?>" class="absolute w-full h-full object-cover opacity-40 select-none" alt="Hero Background">
        <?php endif; ?>
    </div>
    
    <div class="absolute inset-y-0 left-0 w-full z-20 flex flex-col justify-end pb-16 px-4 sm:px-8 lg:px-12 pt-16">
        <h1 class="text-4xl sm:text-5xl md:text-7xl font-bold text-white tracking-tight mb-4 drop-shadow-2xl max-w-3xl">
            <?= htmlspecialchars($heroSerie->getTitreVF()) ?>
        </h1>
        <?php if ($heroSerie->getGenre()): ?>
            <p class="text-lg sm:text-xl text-zinc-300 font-semibold mb-6 drop-shadow-md">
                <?= htmlspecialchars($heroSerie->getGenre()) ?>
            </p>
        <?php endif; ?>
        <div class="flex gap-4">
            <a href="index.php?action=saisonDetail&slug=<?= urlencode($heroSerie->getSlug()) ?>&saison=1" class="bg-white text-black px-6 py-2.5 sm:px-8 sm:py-3 rounded md:text-lg font-bold flex items-center hover:bg-zinc-200 transition">
                <svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 mr-2"><path d="M8 5v14l11-7z"/></svg>
                Lecture Saison 1
            </a>
            <a href="index.php?action=serieDetail&slug=<?= urlencode($heroSerie->getSlug()) ?>" class="bg-zinc-500/50 hover:bg-zinc-500/70 text-white px-6 py-2.5 sm:px-8 sm:py-3 rounded md:text-lg font-bold flex items-center transition backdrop-blur-sm">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 mr-2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                Plus d'infos
            </a>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-zinc-950 to-transparent z-10"></div>
</div>
<?php endif; ?>

<div class="px-4 sm:px-8 lg:px-16 pb-20 relative z-20 -mt-10 sm:-mt-16">
    <?php if (!empty($fetchSeries)): 
        // Group series by genre
        $seriesByGenre = [];
        foreach ($fetchSeries as $serie) {
            $genre = $serie->getGenre() ?: 'Autres';
            // Fallback for missing genre if the getAllSeries doesn't fetch it by default
            if ($genre === 'Autres' && method_exists($serie, 'getGenre') && !$serie->getGenre()) {
                 // Try to guess or just leave in 'Autres'
            }
            $seriesByGenre[$genre][] = $serie;
        }
        
        // Sort genres alphabetically
        ksort($seriesByGenre);
    ?>
        <?php foreach ($seriesByGenre as $genre => $seriesInGenre): ?>
            <div class="mb-10">
                <h2 class="text-xl sm:text-2xl font-bold text-zinc-100 mb-4 px-1"><?= htmlspecialchars($genre) ?></h2>
                <div class="relative group/row">
                    <!-- Optional: Add left/right scroll buttons here if implementing a slider -->
                    <div class="flex overflow-x-auto gap-3 sm:gap-4 lg:gap-5 pb-4 snap-x hide-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
                        <?php foreach ($seriesInGenre as $serie): ?>
                            <div class="flex-none w-40 sm:w-48 lg:w-56 group relative rounded-md overflow-hidden bg-zinc-800 aspect-[2/3] cursor-pointer transition-transform duration-300 hover:scale-[1.05] hover:z-30 hover:shadow-2xl hover:shadow-black/50 ring-1 ring-zinc-800 snap-start">
                                <a href="index.php?action=serieDetail&slug=<?= htmlspecialchars($serie->getSlug()) ?>" class="block w-full h-full">
                                    <?php if (method_exists($serie, 'getImageUrlPath') && $serie->getImageUrlPath()): ?>
                                        <img src="<?= htmlspecialchars($serie->getImageUrlPath()) ?>" class="w-full h-full object-cover" alt="<?= htmlspecialchars($serie->getTitreVF()) ?>" onerror="this.src='https://via.placeholder.com/300x450/1f2937/a1a1aa?text=Image+Indisponible'">
                                    <?php else: ?>
                                        <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-gradient-to-br from-zinc-800 to-zinc-900">
                                            <span class="text-zinc-500 mb-2">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-12 h-12"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/></svg>
                                            </span>
                                            <span class="text-lg sm:text-xl font-bold font-sans text-zinc-400 drop-shadow-sm leading-tight"><?= htmlspecialchars($serie->getTitreVF()) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Details always explicitly visible -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/90 via-zinc-950/40 to-transparent flex flex-col justify-end p-4 drop-shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <h3 class="font-bold text-white leading-tight mb-2 opacity-90 text-sm sm:text-base"><?= htmlspecialchars($serie->getTitreVF()) ?></h3>
                                        <div class="flex items-center space-x-2 text-[10px] sm:text-xs font-medium text-white opacity-80">
                                            <span class="text-green-500">Recommandé</span>
                                            <span class="px-1.5 py-0.5 border border-zinc-600 rounded bg-zinc-800/80">HD</span>
                                        </div>
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-zinc-950 to-transparent group-hover:opacity-0 transition-opacity duration-300">
                                        <h3 class="font-bold text-white text-sm sm:text-base drop-shadow-md truncate"><?= htmlspecialchars($serie->getTitreVF()) ?></h3>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-10 text-center">
            <p class="text-zinc-400 text-lg">Aucun titre disponible dans le catalogue pour le moment.</p>
        </div>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>