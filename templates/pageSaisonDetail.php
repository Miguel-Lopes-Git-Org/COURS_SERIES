<?php $title = "Saison " . htmlspecialchars($selectedSeason) . " - " . htmlspecialchars($fetchSerieDetails->getTitreVF()); ?>

<?php ob_start(); ?>

<?php
function excerptText(string $text, int $max = 240): string
{
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($text, 0, $max, '...');
    }

    if (strlen($text) <= $max) {
        return $text;
    }

    return substr($text, 0, $max - 3) . '...';
}
?>

<!-- Season Hero Backdrop -->
<div class="relative w-full overflow-hidden min-h-[50vh] md:min-h-[70vh] lg:min-h-[80vh] mb-8">
    <div class="absolute inset-0 bg-zinc-950">
        <?php 
        // fallback to standard image if poster is missing
        $bgImage = null;
        if (method_exists($fetchSerieDetails, 'getBannerPathUrl') && $fetchSerieDetails->getBannerPathUrl()) {
            $bgImage = $fetchSerieDetails->getBannerPathUrl();
        } else if (isset($saisonInfos['banner_path_url']) && $saisonInfos['banner_path_url']) {
            $bgImage = $saisonInfos['banner_path_url'];
        } else if ($fetchSerieDetails->getImageUrlPath()) {
            $bgImage = $fetchSerieDetails->getImageUrlPath();
        }
        ?>
        <?php if ($bgImage): ?>
            <img class="absolute w-full h-full object-cover opacity-50 select-none" src="<?php echo htmlspecialchars($bgImage); ?>" alt="<?php echo htmlspecialchars($fetchSerieDetails->getTitreVF()); ?>">
        <?php endif; ?>
    </div>
    
    <div class="absolute inset-0 z-10 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-zinc-950/20"></div>
    
    <div class="absolute inset-0 z-20 flex flex-col justify-end px-4 sm:px-8 lg:px-16 pb-12 pt-32">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight mb-2 drop-shadow-lg">
            <?php echo htmlspecialchars($fetchSerieDetails->getTitreVF()); ?>
        </h1>
        <h2 class="text-2xl sm:text-3xl font-bold text-zinc-300 mb-6 drop-shadow-md">
            Saison <?php echo htmlspecialchars($selectedSeason); ?>
        </h2>
        
        <div class="flex flex-wrap text-sm text-zinc-400 gap-x-6 gap-y-2 max-w-3xl">
            <p><strong>Épisodes :</strong> <span class="text-zinc-200"><?php echo htmlspecialchars((string)$saisonInfos['nombre_episodes']); ?></span></p>
            <p><strong>Début tournage :</strong> <span class="text-zinc-200"><?php echo htmlspecialchars($saisonInfos['date_debut_tournage'] ?? 'Inconnu'); ?></span></p>
            <p><strong>Fin tournage :</strong> <span class="text-zinc-200"><?php echo htmlspecialchars($saisonInfos['date_fin_tournage'] ?? 'Inconnu'); ?></span></p>
        </div>
    </div>
</div>

<div class="px-4 sm:px-8 lg:px-16 pb-20 w-full relative z-30">
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        <!-- Main Content: Episodes -->
        <div class="flex-grow lg:w-3/4">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-white">Épisodes</h3>
                
                <?php $nbSaisons = (int)$fetchSerieDetails->getNbSaisons(); ?>
                <?php if ($nbSaisons > 1): ?>
                    <div class="relative">
                        <select class="appearance-none bg-zinc-800 border-zinc-700 text-white py-2 pl-4 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-red-600 font-medium cursor-pointer" onchange="location = this.value;">
                            <?php for ($i = 1; $i <= $nbSaisons; $i++): ?>
                                <?php $url = sprintf('index.php?action=saisonDetail&slug=%s&saison=%d', urlencode($fetchSerieDetails->getSlug()), $i); ?>
                                <option value="<?php echo $url; ?>" <?php if ($i === (int)$selectedSeason) echo 'selected'; ?>>Saison <?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-zinc-400">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($fetchSaisonEpisodes)): ?>
                <div class="flex flex-col space-y-4">
                    <?php foreach ($fetchSaisonEpisodes as $ep): ?>
                        <?php $episodeUrl = sprintf('index.php?action=episodeDetail&slug=%s&saison=%d&episode=%d', urlencode($fetchSerieDetails->getSlug()), $selectedSeason, $ep->getNumEpisode()); ?>

                        <a href="<?php echo $episodeUrl; ?>" class="group flex flex-col sm:flex-row bg-zinc-900 border border-zinc-800 rounded-lg overflow-hidden hover:bg-zinc-800 transition-colors duration-300">
                            <!-- Episode Image thumbnail -->
                            <div class="relative sm:w-64 h-48 sm:h-auto flex-shrink-0 bg-zinc-950">
                                <?php if (method_exists($ep, 'getImageUrlPath') && $ep->getImageUrlPath()): ?>
                                    <img src="<?php echo htmlspecialchars($ep->getImageUrlPath()); ?>" alt="Épisode <?php echo htmlspecialchars($ep->getNumEpisode()); ?>" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                <?php else: ?>
                                    <div class="absolute inset-0 bg-gradient-to-br from-zinc-800 to-zinc-900 flex items-center justify-center">
                                        <svg viewBox="0 0 24 24" fill="none" class="w-12 h-12 text-zinc-600"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                <?php endif; ?>
                                <div class="absolute bottom-2 left-2 bg-black/80 px-2 py-0.5 rounded text-xs font-bold text-white border border-zinc-700 backdrop-blur-sm">
                                    Ép. <?php echo htmlspecialchars($ep->getNumEpisode()); ?>
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="w-12 h-12 bg-black/60 rounded-full flex items-center justify-center border-2 border-white/80 scale-90 group-hover:scale-100 transition-transform">
                                        <svg class="w-5 h-5 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Episode Info -->
                            <div class="p-4 sm:p-6 flex flex-col justify-center flex-grow">
                                <h4 class="text-lg font-bold text-zinc-100 mb-1 group-hover:text-red-500 transition-colors">
                                    <?php echo htmlspecialchars($ep->getTitreFr()); ?>
                                </h4>
                                <div class="text-sm font-medium text-zinc-500 italic mb-3">
                                    <?php echo htmlspecialchars($ep->getTitreVo()); ?>
                                </div>
                                <p class="text-zinc-400 text-sm leading-relaxed hidden sm:block">
                                    <?php echo htmlspecialchars(excerptText((string)$ep->getResume(), 200)); ?>
                                </p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-10 text-center">
                    <p class="text-zinc-400 text-lg">Aucun épisode trouvé pour cette saison.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar: Info -->
        <aside class="lg:w-1/4">
            <div class="bg-zinc-900 border border-zinc-800 rounded-lg p-6 sticky top-24">
                <h3 class="text-lg font-bold text-zinc-100 mb-4 pb-4 border-b border-zinc-800">Casting & Équipe</h3>
                
                <div class="mb-6">
                    <h4 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-3">Producteur(s) exécutif(s)</h4>
                    <?php if (!empty($fetchSaisonProducteurs)): ?>
                        <ul class="space-y-2">
                            <?php foreach ($fetchSaisonProducteurs as $prod): ?>
                                <li class="text-zinc-300 text-sm flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-600 mr-2"></span>
                                    <?php echo htmlspecialchars($prod->getNomComplet()); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-zinc-500 text-sm italic">Non renseigné</p>
                    <?php endif; ?>
                </div>
                
                <a href="index.php?action=serieDetail&slug=<?php echo urlencode($fetchSerieDetails->getSlug()); ?>" class="block w-full text-center bg-zinc-800 hover:bg-zinc-700 text-white text-sm font-bold py-3 rounded transition-colors">
                    ← Revenir à la série
                </a>
            </div>
        </aside>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require "layout.php"; ?>