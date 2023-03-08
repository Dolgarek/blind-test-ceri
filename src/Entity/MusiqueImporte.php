<?php

namespace App\Entity;

use App\Repository\MusiqueImporteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusiqueImporteRepository::class)]
class MusiqueImporte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'musiqueImportes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\OneToOne(inversedBy: 'musiqueImporte', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?MusiqueInfo $musiqueInfo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateImportation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getMusiqueInfo(): ?MusiqueInfo
    {
        return $this->musiqueInfo;
    }

    public function setMusiqueInfo(MusiqueInfo $musiqueInfo): self
    {
        $this->musiqueInfo = $musiqueInfo;

        return $this;
    }

    public function getDateImportation(): ?\DateTimeInterface
    {
        return $this->dateImportation;
    }

    public function setDateImportation(\DateTimeInterface $dateImportation): self
    {
        $this->dateImportation = $dateImportation;

        return $this;
    }
}
