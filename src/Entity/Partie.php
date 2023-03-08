<?php

namespace App\Entity;

use App\Repository\PartieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartieRepository::class)]
class Partie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'parties')]
    private Collection $utilisateurs;

    #[ORM\Column]
    private ?int $nombreDeMusique = null;

    #[ORM\Column(length: 255)]
    private ?string $niveauDeDifficulte = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\ManyToMany(targetEntity: Musique::class, mappedBy: 'parties')]
    private Collection $musiques;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->musiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateurs->removeElement($utilisateur);

        return $this;
    }

    public function getNombreDeMusique(): ?int
    {
        return $this->nombreDeMusique;
    }

    public function setNombreDeMusique(int $nombreDeMusique): self
    {
        $this->nombreDeMusique = $nombreDeMusique;

        return $this;
    }

    public function getNiveauDeDifficulte(): ?string
    {
        return $this->niveauDeDifficulte;
    }

    public function setNiveauDeDifficulte(string $niveauDeDifficulte): self
    {
        $this->niveauDeDifficulte = $niveauDeDifficulte;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return Collection<int, Musique>
     */
    public function getMusiques(): Collection
    {
        return $this->musiques;
    }

    public function addMusique(Musique $musique): self
    {
        if (!$this->musiques->contains($musique)) {
            $this->musiques->add($musique);
            $musique->addParty($this);
        }

        return $this;
    }

    public function removeMusique(Musique $musique): self
    {
        if ($this->musiques->removeElement($musique)) {
            $musique->removeParty($this);
        }

        return $this;
    }
}
