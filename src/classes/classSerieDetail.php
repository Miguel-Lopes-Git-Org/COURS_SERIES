<?php

require_once __DIR__ . '/classChaine.php';

class SERIESDETAIL
{
    private string $titreVF;
    private ?string $titreVO;
    private ?string $description;
    private ?string $dateCreation;
    private ?string $imageUrlPath;
    private ?string $videoPathUrl;
    private ?string $bannerPathUrl;
    private ?string $musiqueGenerique;
    private ?string $slug;
    private ?string $genre;
    private ?string $pays;
    private ?string $nombreSaisons;
    private ?string $dureeMoyenneEpisodes;

    /** @var CHAINE[] */
    private array $chaineDiffusion = [];

    public function __construct(
        string $titreVF,
        ?string $titreVO,
        ?string $description,
        ?string $dateCreation,
        ?string $imageUrlPath,
        ?string $videoPathUrl,
        ?string $bannerPathUrl,
        ?string $musiqueGenerique,
        ?string $slug = null,
        ?string $genre = null,
        ?string $pays = null,
        ?string $nombreSaisons = null,
        ?string $dureeMoyenneEpisodes = null
    ) {
        $this->titreVF = $titreVF;
        $this->titreVO = $titreVO;
        $this->description = $description;
        $this->dateCreation = $dateCreation;
        $this->slug = $slug;
        $this->imageUrlPath = $imageUrlPath;
        $this->videoPathUrl = $videoPathUrl;
        $this->bannerPathUrl = $bannerPathUrl;
        $this->musiqueGenerique = $musiqueGenerique;
        $this->genre = $genre;
        $this->pays = $pays;
        $this->nombreSaisons = $nombreSaisons;
        $this->dureeMoyenneEpisodes = $dureeMoyenneEpisodes;
    }

    public function __destruct() {}

    public function getTitreVF(): string
    {
        return $this->titreVF;
    }

    public function getTitreVO(): ?string
    {
        return $this->titreVO;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDateCreation(): ?string
    {
        return $this->dateCreation;
    }

    public function getImageUrlPath(): ?string
    {
        return $this->imageUrlPath;
    }

    public function getVideoPathUrl(): ?string
    {
        return $this->videoPathUrl;
    }

    public function getBannerPathUrl(): ?string
    {
        return $this->bannerPathUrl;
    }

    public function getMusiqueGenerique(): ?string
    {
        return $this->musiqueGenerique;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function getNbSaisons(): ?string
    {
        return $this->nombreSaisons;
    }

    public function getDureeMoyenneEpisodes(): ?string
    {
        return $this->dureeMoyenneEpisodes;
    }

    public function setChaineDiffusion(array $chaines): void
    {
        $this->chaineDiffusion = $chaines;
    }

    public function getChaineDiffusion(): array
    {
        return $this->chaineDiffusion;
    }
}
