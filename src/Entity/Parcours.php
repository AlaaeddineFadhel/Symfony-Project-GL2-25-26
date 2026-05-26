<?php

namespace App\Entity;

use App\Repository\ParcoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcoursRepository::class)]
class Parcours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120 , unique: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'parcours')]
    private ?Filiere $filiere = null;

    /**
     * @var Collection<int, Insatien>
     */
    #[ORM\OneToMany(targetEntity: Insatien::class, mappedBy: 'parcours')]
    private Collection $insatiens;

    public function __construct()
    {
        $this->insatiens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Insatien>
     */
    public function getInsatiens(): Collection
    {
        return $this->insatiens;
    }

    public function addInsatien(Insatien $insatien): static
    {
        if (!$this->insatiens->contains($insatien)) {
            $this->insatiens->add($insatien);
            $insatien->setParcours($this);
        }

        return $this;
    }

    public function removeInsatien(Insatien $insatien): static
    {
        if ($this->insatiens->removeElement($insatien)) {
            // set the owning side to null (unless already changed)
            if ($insatien->getParcours() === $this) {
                $insatien->setParcours(null);
            }
        }

        return $this;
    }
}
