<?php
require_once __DIR__ . '/../model.php';

function controllerPageSerie()
{
    global $fetchSeries;

    $fetchSeries = getAllSeries();

    require_once __DIR__ . '/../../templates/pageSerie.php';
}
