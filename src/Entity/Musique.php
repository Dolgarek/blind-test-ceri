<?php

namespace App\Entity;

use App\Repository\MusiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusiqueRepository::class)]
class Musique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Partie::class, inversedBy: 'musiques')]
    private Collection $parties;

    #[ORM\OneToOne(inversedBy: 'musique', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?MusiqueInfo $musiqueInfo = null;

    #[ORM\Column]
    private ?bool $isGlobal = null;

    #[ORM\Column(type: 'string')]
    private $musiqueFilename;

    public function getBrochureFilename(): string
    {
        return $this->musiqueFilename;
    }

    public function setBrochureFilename(string $musiqueFilename): self
    {
        $this->musiqueFilename = $musiqueFilename;

        return $this;
    }

    public function __construct()
    {
        $this->parties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Partie>
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Partie $party): self
    {
        if (!$this->parties->contains($party)) {
            $this->parties->add($party);
        }

        return $this;
    }

    public function removeParty(Partie $party): self
    {
        $this->parties->removeElement($party);

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

    public function isIsGlobal(): ?bool
    {
        return $this->isGlobal;
    }

    public function setIsGlobal(bool $isGlobal): self
    {
        $this->isGlobal = $isGlobal;

        return $this;
    }
}
