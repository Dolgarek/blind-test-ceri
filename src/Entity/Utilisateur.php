<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(type: 'simple_array')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: AccordRGPD::class)]
    private Collection $accordRGPDs;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?AccordUtilisateur $accordUtilisateur = null;

    #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private ?Connexion $connexion = null;

    #[ORM\ManyToMany(targetEntity: Partie::class, mappedBy: 'utilisateurs')]
    private Collection $parties;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: MusiqueImporte::class)]
    private Collection $musiqueImportes;

    #[ORM\Column(type: 'string', nullable: true)]
    private $avatarFileName = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Ticket::class)]
    private Collection $tickets;

    public function __construct()
    {
        $this->accordRGPDs = new ArrayCollection();
        $this->parties = new ArrayCollection();
        $this->musiqueImportes = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, AccordRGPD>
     */
    public function getAccordRGPDs(): Collection
    {
        return $this->accordRGPDs;
    }

    public function addAccordRGPD(AccordRGPD $accordRGPD): self
    {
        if (!$this->accordRGPDs->contains($accordRGPD)) {
            $this->accordRGPDs->add($accordRGPD);
            $accordRGPD->setCreatedBy($this);
        }

        return $this;
    }

    public function removeAccordRGPD(AccordRGPD $accordRGPD): self
    {
        if ($this->accordRGPDs->removeElement($accordRGPD)) {
            // set the owning side to null (unless already changed)
            if ($accordRGPD->getCreatedBy() === $this) {
                $accordRGPD->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getAccordUtilisateur(): ?AccordUtilisateur
    {
        return $this->accordUtilisateur;
    }

    public function setAccordUtilisateur(AccordUtilisateur $accordUtilisateur): self
    {
        // set the owning side of the relation if necessary
        if ($accordUtilisateur->getUtilisateur() !== $this) {
            $accordUtilisateur->setUtilisateur($this);
        }

        $this->accordUtilisateur = $accordUtilisateur;

        return $this;
    }

    public function getConnexion(): ?Connexion
    {
        return $this->connexion;
    }

    public function setConnexion(Connexion $connexion): self
    {
        // set the owning side of the relation if necessary
        if ($connexion->getUtilisateur() !== $this) {
            $connexion->setUtilisateur($this);
        }

        $this->connexion = $connexion;

        return $this;
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
            $party->addUtilisateur($this);
        }

        return $this;
    }

    public function removeParty(Partie $party): self
    {
        if ($this->parties->removeElement($party)) {
            $party->removeUtilisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, MusiqueImporte>
     */
    public function getMusiqueImportes(): Collection
    {
        return $this->musiqueImportes;
    }

    public function addMusiqueImporte(MusiqueImporte $musiqueImporte): self
    {
        if (!$this->musiqueImportes->contains($musiqueImporte)) {
            $this->musiqueImportes->add($musiqueImporte);
            $musiqueImporte->setUtilisateur($this);
        }

        return $this;
    }

    public function removeMusiqueImporte(MusiqueImporte $musiqueImporte): self
    {
        if ($this->musiqueImportes->removeElement($musiqueImporte)) {
            // set the owning side to null (unless already changed)
            if ($musiqueImporte->getUtilisateur() === $this) {
                $musiqueImporte->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getAvatarFileName()
    {
        return $this->avatarFileName;
    }

    public function setAvatarFileName($avatarFileName)
    {
        $this->avatarFileName = $avatarFileName;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getCreatedBy() === $this) {
                $ticket->setCreatedBy(null);
            }
        }

        return $this;
    }
}
