<?php
require_once __DIR__ . '/../model.php';

function formatDateFr(?string $date): string
{
    if (empty($date)) {
        return '';
    }

    $timestamp = strtotime($date);
    if ($timestamp === false) {
        return $date;
    }

    return date('d/m/Y', $timestamp);
}

function controllerPageSaisonDetail()
{
    global $fetchSerieDetails, $fetchSaisonEpisodes, $fetchSaisonProducteurs, $selectedSeason, $saisonInfos;

    $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
    $selectedSeason = isset($_GET['saison']) ? (int)$_GET['saison'] : 1;

    // Récupère les détails de la série pour l'en-tête et le nombre de saisons
    $fetchSerieDetails = getSerieDetails($slug);

    // Récupère les épisodes / métadonnées de la saison
    $fetchSaisonEpisodes = getSaisonDetails($slug, $selectedSeason);

    // Récupère la liste des producteurs pour la saison
    $fetchSaisonProducteurs = getSaisonProducteurs($slug, $selectedSeason);

    $datesUsa = [];
    $datesFr = [];
    foreach ($fetchSaisonEpisodes as $episode) {
        $dateUsa = $episode->getDateDiffusionUsa();
        $dateFr = $episode->getDateDiffusionFr();

        if (!empty($dateUsa)) {
            $datesUsa[] = $dateUsa;
        }
        if (!empty($dateFr)) {
            $datesFr[] = $dateFr;
        }
    }

    sort($datesUsa);
    sort($datesFr);

    $dateDebut = !empty($datesUsa) ? $datesUsa[0] : (!empty($datesFr) ? $datesFr[0] : null);
    $dateFin = !empty($datesFr) ? $datesFr[count($datesFr) - 1] : (!empty($datesUsa) ? $datesUsa[count($datesUsa) - 1] : null);

    $saisonInfos = [
        'nombre_episodes' => count($fetchSaisonEpisodes),
        'date_debut_tournage' => formatDateFr($dateDebut),
        'date_fin_tournage' => formatDateFr($dateFin),
    ];

    require_once __DIR__ . '/../../templates/pageSaisonDetail.php';
}
