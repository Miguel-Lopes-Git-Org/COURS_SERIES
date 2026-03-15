<?php

require_once __DIR__ . '/classPosition.php';

class Personne
{
    protected string $nom;
    protected string $prenom;
    protected string $image_url_path;

    public function __construct(string $nom, string $prenom, string $image_url_path = '')
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->image_url_path = $image_url_path;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getImageUrlPath(): string
    {
        return $this->image_url_path;
    }

    public function setImageUrlPath(string $image_url_path): void
    {
        $this->image_url_path = $image_url_path;
    }

    public function getNomComplet(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
}

class Producteur extends Personne
{
    public function __construct(string $nom, string $prenom, string $image_url_path = '')
    {
        parent::__construct($nom, $prenom, $image_url_path);
    }
}

class Createur extends Personne
{
    public function __construct(string $nom, string $prenom, string $image_url_path = '')
    {
        parent::__construct($nom, $prenom, $image_url_path);
    }
}

class Scenariste extends Personne
{
    public function __construct(string $nom, string $prenom, string $image_url_path = '')
    {
        parent::__construct($nom, $prenom, $image_url_path);
    }
}

class Realisateur extends Personne
{
    public function __construct(string $nom, string $prenom, string $image_url_path = '')
    {
        parent::__construct($nom, $prenom, $image_url_path);
    }
}

class Acteur extends Personne
{
    public function __construct(string $nom, string $prenom, string $image_url_path = '')
    {
        parent::__construct($nom, $prenom, $image_url_path);
    }
}

class Doubleur extends Personne
{
    public function __construct(string $nom, string $prenom, string $image_url_path = '')
    {
        parent::__construct($nom, $prenom, $image_url_path);
    }
}

class Personnage extends Personne
{
    private string $desc_perso;

    public function __construct(string $nom, string $prenom, string $image_url_path = '', string $desc_perso = '')
    {
        parent::__construct($nom, $prenom, $image_url_path);
        $this->desc_perso = $desc_perso;
    }

    public function getDescPerso(): string
    {
        return $this->desc_perso;
    }

    public function setDescPerso(string $desc_perso): void
    {
        $this->desc_perso = $desc_perso;
    }
}

class GuestStar extends Personne
{
    private Position $position;

    public function __construct(string $nom, string $prenom, Position $position, string $image_url_path = '')
    {
        parent::__construct($nom, $prenom, $image_url_path);
        $this->position = $position;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }
}
