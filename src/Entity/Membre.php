<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass= MembreRepository::class)
 * @UniqueEntity(fields: ['email'], message: 'Un compte existe déjà avec cet email')
 */
// #[ORM\Entity(repositoryClass: MembreRepository::class)]
// #[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length= 180, unique= true)
     */
    // #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @ORM\Column()
     */ //! Array ou quelque chose ?
    // #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    /**
     * @ORM\Column()
     */ //! Parenthèses ?
    // #[ORM\Column]
    private ?string $password = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $civilite = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    /**
     * @ORM\Column(type= "datetime"))
     */
    // #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_enregistrement = null;

    /**
     * @ORM\Column(mappedBy= "membre", targetEntity= Commande::class, orphanRemoval= true)
     */
    // #[ORM\OneToMany(mappedBy: 'membre', targetEntity: Commande::class, orphanRemoval: true)]
    private Collection $commandes;


    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
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

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getDateEnregistrement(): ?\DateTimeInterface
    {
        return $this->date_enregistrement;
    }

    public function setDateEnregistrement(\DateTimeInterface $date_enregistrement): self
    {
        $this->date_enregistrement = $date_enregistrement;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setMembre($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getMembre() === $this) {
                $commande->setMembre(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getEmail() ;
    }

}
