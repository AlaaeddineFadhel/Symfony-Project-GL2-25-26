<?php

namespace App\Entity;

use App\Enum\JobMode;
use App\Enum\JobType;
use App\Repository\JobRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $entreprise = null;

    #[ORM\Column(enumType: JobType::class)]
    private ?JobType $jobType = null;

    #[ORM\Column(enumType: JobMode::class)]
    private ?JobMode $jobMode = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $applicationLink = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $companyLink = null;

    #[ORM\Column(length: 150 , unique: true)]
    private ?string $contactEmail = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $requirements = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $responsibilities = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $salaryMin = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2 ,nullable: true)]
    private ?string $salaryMax = null;

    #[ORM\Column(type: 'string', length: 3, nullable: false, options: ['default' => 'TND', 'fixed' => true])]
    private ?string $currency = "TND";

    #[ORM\Column(nullable: true)]
    private ?int $reqExperience = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    private ?City $city = null;

    #[ORM\Column(type: 'datetime', nullable: true, options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTime $datePublication = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $deadline = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    private ?User $createdBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(?string $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getJobType(): ?JobType
    {
        return $this->jobType;
    }

    public function setJobType(JobType $job_type): static
    {
        $this->jobType = $job_type;

        return $this;
    }

    public function getJobMode(): ?JobMode
    {
        return $this->jobMode;
    }

    public function setJobMode(JobMode $jobMode): static
    {
        $this->jobMode = $jobMode;

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

    public function getApplicationLink(): ?string
    {
        return $this->applicationLink;
    }

    public function setApplicationLink(?string $application_link): static
    {
        $this->applicationLink = $application_link;

        return $this;
    }

    public function getCompanyLink(): ?string
    {
        return $this->companyLink;
    }

    public function setCompanyLink(?string $companyLink): static
    {
        $this->companyLink = $companyLink;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getRequirements(): ?string
    {
        return $this->requirements;
    }

    public function setRequirements(?string $requirements): static
    {
        $this->requirements = $requirements;

        return $this;
    }

    public function getResponsibilities(): ?string
    {
        return $this->responsibilities;
    }

    public function setResponsibilities(?string $responsibilities): static
    {
        $this->responsibilities = $responsibilities;

        return $this;
    }

    public function getSalaryMin(): ?string
    {
        return $this->salaryMin;
    }

    public function setSalaryMin(?string $salary_min): static
    {
        $this->salaryMin = $salary_min;

        return $this;
    }

    public function getSalaryMax(): ?string
    {
        return $this->salaryMax;
    }

    public function setSalaryMax(string $salaryMax): static
    {
        $this->salaryMax = $salaryMax;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getReqExperience(): ?int
    {
        return $this->reqExperience;
    }

    public function setReqExperience(?int $reqExperience): static
    {
        $this->reqExperience = $reqExperience;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getDatePublication(): ?\DateTime
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTime $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getDeadline(): ?\DateTime
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTime $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
