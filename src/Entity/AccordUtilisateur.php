<?php

namespace App\Entity;

use App\Repository\AccordUtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccordUtilisateurRepository::class)]
class AccordUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'accordUtilisateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\OneToOne(inversedBy: 'accordUtilisateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?AccordRGPD $accordRGPD = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getAccordRGPD(): ?AccordRGPD
    {
        return $this->accordRGPD;
    }

    public function setAccordRGPD(AccordRGPD $accordRGPD): self
    {
        $this->accordRGPD = $accordRGPD;

        return $this;
    }
}
