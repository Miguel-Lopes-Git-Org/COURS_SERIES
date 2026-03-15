<?php

class CHAINE
{
    private string $nomChaine;
    private int $numeroChaine;
    private string $pays;
    private string $codeIso;

    public function __construct(string $nomChaine, int $numeroChaine, string $pays, string $codeIso)
    {
        $this->nomChaine = $nomChaine;
        $this->numeroChaine = $numeroChaine;
        $this->pays = $pays;
        $this->codeIso = $codeIso;
    }

    public function __destruct() {}

    public function getNomChaine(): string
    {
        return $this->nomChaine;
    }

    public function getNumeroChaine(): int
    {
        return $this->numeroChaine;
    }

    public function getPays(): string
    {
        return $this->pays;
    }

    public function getCodeIso(): string
    {
        return $this->codeIso;
    }
}
