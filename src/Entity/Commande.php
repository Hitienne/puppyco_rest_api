<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Commande
{
    private $id;

    private $date;

    private $ville;

    private $pays;

    private $rue;

    private $codePostal;

    private $contenu;

    private $idClient;

    public function __construct()
    {
        $this->contenu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection|Contenu[]
     */
    public function getContenu(): Collection
    {
        return $this->contenu;
    }

    public function addContenu(Contenu $contenu): self
    {
        if (!$this->contenu->contains($contenu)) {
            $this->contenu[] = $contenu;
            $contenu->setIdCommande($this);
        }

        return $this;
    }

    public function removeContenu(Contenu $contenu): self
    {
        if ($this->contenu->contains($contenu)) {
            $this->contenu->removeElement($contenu);
            // set the owning side to null (unless already changed)
            if ($contenu->getIdCommande() === $this) {
                $contenu->setIdCommande(null);
            }
        }

        return $this;
    }

    public function getIdClient(): ?Client
    {
        return $this->idClient;
    }

    public function setIdClient(?Client $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }
}
