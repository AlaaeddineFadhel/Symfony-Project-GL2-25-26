<?php

namespace App\Entity;

use App\Enum\AchievementType;
use App\Repository\AchievementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Trait\CreatedAtTrait;

#[ORM\Entity(repositoryClass: AchievementRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Achievement
{
    use CreatedAtTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'achievements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $issuer = null;

    #[ORM\Column(enumType: AchievementType::class)]
    private ?AchievementType $achievementType = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateObtained = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lien = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    public function setIssuer(?string $issuer): static
    {
        $this->issuer = $issuer;

        return $this;
    }

    public function getAchievementType(): ?AchievementType
    {
        return $this->achievementType;
    }

    public function setAchievementType(AchievementType $achievementType): static
    {
        $this->achievementType = $achievementType;

        return $this;
    }

    public function getDateObtained(): ?\DateTime
    {
        return $this->dateObtained;
    }

    public function setDateObtained(?\DateTime $dateObtained): static
    {
        $this->dateObtained = $dateObtained;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
