<?php

namespace App\Entity;

use App\Repository\CurrentAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrentAnswerRepository::class)]
class CurrentAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $answer = null;

    #[ORM\Column]
    private ?int $currentId = null;

    #[ORM\Column(length: 255)]
    private ?string $ssid = null;

    #[ORM\Column]
    private ?bool $answerCorrect = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getCurrentId(): ?int
    {
        return $this->currentId;
    }

    public function setCurrentId(int $currentId): self
    {
        $this->currentId = $currentId;

        return $this;
    }

    public function getSsid(): ?string
    {
        return $this->ssid;
    }

    public function setSsid(string $ssid): self
    {
        $this->ssid = $ssid;

        return $this;
    }

    public function isAnswerCorrect(): ?bool
    {
        return $this->answerCorrect;
    }

    public function setAnswerCorrect(bool $answerCorrect): self
    {
        $this->answerCorrect = $answerCorrect;

        return $this;
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
}
