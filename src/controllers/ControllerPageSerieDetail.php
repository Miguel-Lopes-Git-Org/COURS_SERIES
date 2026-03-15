<?php
require_once __DIR__ . '/../model.php';

function controllerPageSerieDetail()
{
    global $fetchSerieDetails;

    $slug = isset($_GET['slug']) ? $_GET['slug'] : null;

    $fetchSerieDetails = getSerieDetails($slug);
    $fetchDiffusions = getSerieChaines($slug);

    $fetchSerieDetails->setChaineDiffusion($fetchDiffusions);

    require_once __DIR__ . '/../../templates/pageSerieDetail.php';
}
