<?php

namespace App\Entity;

use App\Repository\AccordRGPDRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccordRGPDRepository::class)]
class AccordRGPD
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'accordRGPDs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $createdBy = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $fichier = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\OneToOne(mappedBy: 'accordRGPD', cascade: ['persist', 'remove'])]
    private ?AccordUtilisateur $accordUtilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedBy(): ?Utilisateur
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Utilisateur $createdBy): self
    {
        $this->createdBy = $createdBy;

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

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAccordUtilisateur(): ?AccordUtilisateur
    {
        return $this->accordUtilisateur;
    }

    public function setAccordUtilisateur(AccordUtilisateur $accordUtilisateur): self
    {
        // set the owning side of the relation if necessary
        if ($accordUtilisateur->getAccordRGPD() !== $this) {
            $accordUtilisateur->setAccordRGPD($this);
        }

        $this->accordUtilisateur = $accordUtilisateur;

        return $this;
    }
}
