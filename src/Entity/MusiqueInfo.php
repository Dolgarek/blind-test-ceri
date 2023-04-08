<?php

namespace App\Entity;

use App\Repository\MusiqueInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusiqueInfoRepository::class)]
class MusiqueInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artiste = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $album = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $groupe = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDeSortie = null;

    #[ORM\ManyToMany(targetEntity: Theme::class, mappedBy: 'musiqueInfos')]
    private Collection $themes;

    #[ORM\OneToOne(mappedBy: 'musiqueInfo', cascade: ['persist', 'remove'])]
    private ?Musique $musique = null;

    #[ORM\OneToOne(mappedBy: 'musiqueInfo', cascade: ['persist', 'remove'])]
    private ?MusiqueImporte $musiqueImporte = null;

    #[ORM\Column(type: 'simple_array', nullable: true)]
    private array $tags = [];

    #[ORM\Column(nullable: true)]
    private ?int $timestamp = null;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getArtiste(): ?string
    {
        return $this->artiste;
    }

    public function setArtiste(?string $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(?string $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(?string $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getDateDeSortie(): ?\DateTimeInterface
    {
        return $this->dateDeSortie;
    }

    public function setDateDeSortie(\DateTimeInterface $dateDeSortie): self
    {
        $this->dateDeSortie = $dateDeSortie;

        return $this;
    }

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes->add($theme);
            $theme->addMusiqueInfo($this);
        } else { dump("debug", $this->themes); }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->removeElement($theme)) {
            $theme->removeMusiqueInfo($this);
        }

        return $this;
    }

    public function getMusique(): ?Musique
    {
        return $this->musique;
    }

    public function setMusique(Musique $musique): self
    {
        // set the owning side of the relation if necessary
        if ($musique->getMusiqueInfo() !== $this) {
            $musique->setMusiqueInfo($this);
        }

        $this->musique = $musique;

        return $this;
    }

    public function getMusiqueImporte(): ?MusiqueImporte
    {
        return $this->musiqueImporte;
    }

    public function setMusiqueImporte(MusiqueImporte $musiqueImporte): self
    {
        // set the owning side of the relation if necessary
        if ($musiqueImporte->getMusiqueInfo() !== $this) {
            $musiqueImporte->setMusiqueInfo($this);
        }

        $this->musiqueImporte = $musiqueImporte;

        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getTagsString():?String
    {
        $strTags = "";
        foreach ($this->tags as $tag) {
            $strTags = $strTags . $tag;
        }
        return $strTags;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    public function setTimestamp(?int $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
