<?php

namespace App\Entity;

use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FiliereRepository::class)]
class Filiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120 , unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Parcours>
     */
    #[ORM\OneToMany(targetEntity: Parcours::class, mappedBy: 'filiere')]
    private Collection $parcours;

    /**
     * @var Collection<int, Insatien>
     */
    #[ORM\OneToMany(targetEntity: Insatien::class, mappedBy: 'filiere')]
    private Collection $insatiens;

    public function __construct()
    {
        $this->parcours = new ArrayCollection();
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

    /**
     * @return Collection<int, Parcours>
     */
    public function getParcours(): Collection
    {
        return $this->parcours;
    }

    public function addParcour(Parcours $parcour): static
    {
        if (!$this->parcours->contains($parcour)) {
            $this->parcours->add($parcour);
            $parcour->setFiliere($this);
        }

        return $this;
    }

    public function removeParcour(Parcours $parcour): static
    {
        if ($this->parcours->removeElement($parcour)) {
            // set the owning side to null (unless already changed)
            if ($parcour->getFiliere() === $this) {
                $parcour->setFiliere(null);
            }
        }

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
            $insatien->setFiliere($this);
        }

        return $this;
    }

    public function removeInsatien(Insatien $insatien): static
    {
        if ($this->insatiens->removeElement($insatien)) {
            // set the owning side to null (unless already changed)
            if ($insatien->getFiliere() === $this) {
                $insatien->setFiliere(null);
            }
        }

        return $this;
    }
}
