<?php

class SAISON
{
    private int $idSaison;
    private int $numSaison;
    private int $nbEpisode;

    public function __construct(int $idSaison, int $numSaison, int $nbEpisode)
    {
        $this->idSaison = $idSaison;
        $this->numSaison = $numSaison;
        $this->nbEpisode = $nbEpisode;
    }

    public function __destruct() {}

    public function getIdSaison(): int
    {
        return $this->idSaison;
    }

    public function getNumSaison(): int
    {
        return $this->numSaison;
    }

    public function getNbEpisode(): int
    {
        return $this->nbEpisode;
    }
}
