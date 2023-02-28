<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: MusiqueInfo::class, inversedBy: 'themes')]
    private Collection $musiqueInfos;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    public function __construct()
    {
        $this->musiqueInfos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, MusiqueInfo>
     */
    public function getMusiqueInfos(): Collection
    {
        return $this->musiqueInfos;
    }

    public function addMusiqueInfo(MusiqueInfo $musiqueInfo): self
    {
        if (!$this->musiqueInfos->contains($musiqueInfo)) {
            $this->musiqueInfos->add($musiqueInfo);
        }

        return $this;
    }

    public function removeMusiqueInfo(MusiqueInfo $musiqueInfo): self
    {
        $this->musiqueInfos->removeElement($musiqueInfo);

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
}
