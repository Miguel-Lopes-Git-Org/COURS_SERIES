<?php

class SERIES
{
    private string $titreVF;
    private ?string $imageUrlPath;
    private ?string $videoPathUrl;
    private ?string $bannerPathUrl;
    private ?string $slug;
    private ?string $genre;
    private ?string $pays;

    public function __construct(string $titreVF, ?string $imageUrlPath = null, ?string $videoPathUrl = null, ?string $bannerPathUrl = null, ?string $slug = null, ?string $genre = null, ?string $pays = null)
    {
        $this->titreVF = $titreVF;
        $this->slug = $slug;
        $this->imageUrlPath = $imageUrlPath;
        $this->videoPathUrl = $videoPathUrl;
        $this->bannerPathUrl = $bannerPathUrl;
        $this->genre = $genre;
        $this->pays = $pays;
    }

    public function __destruct() {}

    public function getTitreVF(): string
    {
        return $this->titreVF;
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
}
