<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass= ProduitRepository::class))
 */
// #[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
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
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $titre = null;

    /**
     * @ORM\Column(type="text")
     */
    // #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $couleur = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $taille = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $collection = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $photo = null;

    /**
     * @ORM\Column()
     */
    // #[ORM\Column]
    private ?int $prix = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    // #[ORM\Column(length: 255)]
    private ?string $stock = null;

    /**
     * @ORM\Column(type= "datetime")
     */
    // #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_enregistrement = null;

    /**
     * @ORM\Column(mappedBy= "produit", targetEntity= Commande::class, orphanRemoval= true)
     */
    // #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Commande::class, orphanRemoval: true)]
    private Collection $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getCollection(): ?string
    {
        return $this->collection;
    }

    public function setCollection(string $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(string $stock): self
    {
        $this->stock = $stock;

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

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

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
            $commande->setProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getProduit() === $this) {
                $commande->setProduit(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitre() ;
    }

}
