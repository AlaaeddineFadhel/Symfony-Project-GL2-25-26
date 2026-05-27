<?php

namespace App\Entity;

use App\Repository\UserSkillsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSkillsRepository::class)]
#[ORM\Table(name: 'user_skills')]
class UserSkills
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'userSkills')]
    #[ORM\JoinColumn(name: 'user_id', nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Skill::class, inversedBy: 'userSkills')]
    #[ORM\JoinColumn(name: 'skill_id', nullable: false, onDelete: 'CASCADE')]
    private ?Skill $skill = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): static
    {
        $this->skill = $skill;
        return $this;
    }
}
