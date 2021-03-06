<?php

namespace App\Database;


/**
 * les objet de la class fichier represent les données de la table fichier
 * 1 instance = 1 ligne
 */
class Fichier
{

    private ?int $id = null;
    private ?string $nom = null;
    private ?string $nom_original = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }


    public function getNomOriginal(): ?string
    {
        return $this->nom_original;
    }
    public function setNomOriginal(string $nom_original): self
    {
        $this->nom_original = $nom_original;
        return $this;
    }
}