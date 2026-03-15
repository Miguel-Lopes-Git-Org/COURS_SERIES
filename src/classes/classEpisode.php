<?php

class EPISODE
{
    private string $titreSerie;
    private string $slug;
    private int $nbSaisons;
    private int $idSaison;
    private int $numEpisode;
    private string $titreVo;
    private string $titreFr;
    private ?string $dateDiffusionUsa;
    private ?string $dateDiffusionFr;
    private ?string $resume;
    private ?string $imageUrlPath;
    private ?string $bannerPathUrl;
    private ?string $description;

    public function __construct(
        string $titreSerie,
        string $slug,
        int $nbSaisons,
        int $idSaison,
        int $numEpisode,
        string $titreVo,
        string $titreFr,
        ?string $dateDiffusionUsa,
        ?string $dateDiffusionFr,
        ?string $resume,
        ?string $imageUrlPath = null,
        ?string $bannerPathUrl = null,
        ?string $description = null
    ) {
        $this->titreSerie = $titreSerie;
        $this->slug = $slug;
        $this->nbSaisons = $nbSaisons;
        $this->idSaison = $idSaison;
        $this->numEpisode = $numEpisode;
        $this->titreVo = $titreVo;
        $this->titreFr = $titreFr;
        $this->dateDiffusionUsa = $dateDiffusionUsa;
        $this->dateDiffusionFr = $dateDiffusionFr;
        $this->resume = $resume;
        $this->imageUrlPath = $imageUrlPath;
        $this->bannerPathUrl = $bannerPathUrl;
        $this->description = $description;
    }

    public function getTitreSerie(): string
    {
        return $this->titreSerie;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getNbSaisons(): int
    {
        return $this->nbSaisons;
    }

    public function getIdSaison(): int
    {
        return $this->idSaison;
    }

    public function getNumEpisode(): int
    {
        return $this->numEpisode;
    }

    public function getTitreVo(): string
    {
        return $this->titreVo;
    }

    public function getTitreFr(): string
    {
        return $this->titreFr;
    }

    public function getDateDiffusionUsa(): ?string
    {
        return $this->dateDiffusionUsa;
    }

    public function getDateDiffusionFr(): ?string
    {
        return $this->dateDiffusionFr;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function getImageUrlPath(): ?string
    {
        return $this->imageUrlPath;
    }

    public function getBannerPathUrl(): ?string
    {
        return $this->bannerPathUrl;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
