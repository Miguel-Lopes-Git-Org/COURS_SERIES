<?php

class Position
{
    private string $libelle;

    public function __construct(string $libelle)
    {
        $this->libelle = $libelle;
    }

    public function getLibelle(): string
    {
        return $this->libelle;
    }
}
