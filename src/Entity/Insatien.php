<?php

namespace App\Entity;

use App\Repository\InsatienRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Trait\CreatedAtTrait;

#[ORM\Entity(repositoryClass: InsatienRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Insatien
{
    use CreatedAtTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(length: 150 , unique: true)]
    private ?string $email = null;

    #[ORM\Column(nullable: true)]
    private ?int $promoYear = null;

    #[ORM\ManyToOne(inversedBy: 'insatiens')]
    private ?Parcours $parcours = null;

    #[ORM\ManyToOne(inversedBy: 'insatiens')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Filiere $filiere = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPromoYear(): ?int
    {
        return $this->promoYear;
    }

    public function setPromoYear(?int $promo_year): static
    {
        $this->promoYear = $promo_year;

        return $this;
    }

    public function getParcours(): ?Parcours
    {
        return $this->parcours;
    }

    public function setParcours(?Parcours $parcours): static
    {
        $this->parcours = $parcours;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): static
    {
        $this->filiere = $filiere;

        return $this;
    }
}
