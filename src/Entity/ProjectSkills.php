<?php

namespace App\Entity;

use App\Repository\ProjectSkillsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectSkillsRepository::class)]
#[ORM\Table(name: 'project_skills')]
class ProjectSkills
{
    // 👇 removed #[ORM\GeneratedValue] and #[ORM\Column] — composite PK instead
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'projectSkills')]
    #[ORM\JoinColumn(name: 'project_id', nullable: false, onDelete: 'CASCADE')]
    private ?Project $project = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Skill::class, inversedBy: 'projectSkills')]
    #[ORM\JoinColumn(name: 'skill_id', nullable: false, onDelete: 'CASCADE')]
    private ?Skill $skill = null;

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;
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
