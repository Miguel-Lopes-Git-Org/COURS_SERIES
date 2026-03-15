<?php
require_once __DIR__ . '/../model.php';

function controllerPageEpisodeDetail()
{
    global $fetchSerieDetails, $selectedSeason, $selectedEpisode, $episodeDetail, $episodeScenaristes, $episodeRealisateurs, $episodeGuestStars, $episodePersonnages;

    $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
    $selectedSeason = isset($_GET['saison']) ? (int)$_GET['saison'] : 1;
    $selectedEpisode = isset($_GET['episode']) ? (int)$_GET['episode'] : 1;

    $fetchSerieDetails = getSerieDetails($slug);

    $episodeDetails = getEpisodeDetails($slug, $selectedSeason, $selectedEpisode);
    $episodeDetail = !empty($episodeDetails) ? $episodeDetails[0] : null;

    $episodeScenaristes = getEpisodeScenaristes($slug, $selectedSeason, $selectedEpisode);
    $episodeRealisateurs = getEpisodeRealisateurs($slug, $selectedSeason, $selectedEpisode);
    $episodeGuestStars = getEpisodeGuestStars($slug, $selectedSeason, $selectedEpisode);
    $episodePersonnages = getPersonnageDetails($slug, $selectedSeason, $selectedEpisode);

    require_once __DIR__ . '/../../templates/pageEpisode.php';
}
