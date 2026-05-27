<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100 , unique: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, UserSkills>
     */
    #[ORM\OneToMany(targetEntity: UserSkills::class, mappedBy: 'skill')]
    private Collection $userSkills;

    /**
     * @var Collection<int, ProjectSkills>
     */
    #[ORM\OneToMany(targetEntity: ProjectSkills::class, mappedBy: 'skill')]
    private Collection $projectSkills;

    /**
     * @var Collection<int, User>
     */


    public function __construct()
    {
        $this->userSkills = new ArrayCollection();
        $this->projectSkills = new ArrayCollection();
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
     * @return Collection<int, UserSkills>
     */
    public function getUserSkills(): Collection
    {
        return $this->userSkills;
    }

    public function addUserSkill(UserSkills $userSkill): static
    {
        if (!$this->userSkills->contains($userSkill)) {
            $this->userSkills->add($userSkill);
            $userSkill->setSkill($this);
        }

        return $this;
    }

    public function removeUserSkill(UserSkills $userSkill): static
    {
        if ($this->userSkills->removeElement($userSkill)) {
            // set the owning side to null (unless already changed)
            if ($userSkill->getSkill() === $this) {
                $userSkill->setSkill(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProjectSkills>
     */
    public function getProjectSkills(): Collection
    {
        return $this->projectSkills;
    }

    public function addProjectSkill(ProjectSkills $projectSkill): static
    {
        if (!$this->projectSkills->contains($projectSkill)) {
            $this->projectSkills->add($projectSkill);
            $projectSkill->setSkill($this);
        }

        return $this;
    }

    public function removeProjectSkill(ProjectSkills $projectSkill): static
    {
        if ($this->projectSkills->removeElement($projectSkill)) {
            // set the owning side to null (unless already changed)
            if ($projectSkill->getSkill() === $this) {
                $projectSkill->setSkill(null);
            }
        }

        return $this;
    }


}
