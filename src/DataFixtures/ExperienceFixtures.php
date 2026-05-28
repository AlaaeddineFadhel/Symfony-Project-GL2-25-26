<?php

namespace App\DataFixtures;

use App\Entity\Experience;
use App\Entity\User;
use App\Enum\ExperienceType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExperienceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $experiences = [
            [
                'user'           => 1,
                'dateDebut'      => new \DateTime('2023-06-01'),
                'dateFin'        => new \DateTime('2023-08-31'),
                'entreprise'     => 'Vermeg',
                'experienceType' => ExperienceType::from('internship'),
                'lien'           => 'https://vermeg.com',
                'description'    => 'Worked on Spring Boot microservices.',
            ],
            [
                'user'           => 2,
                'dateDebut'      => new \DateTime('2024-01-15'),
                'dateFin'        => null,
                'entreprise'     => 'Freelance',
                'experienceType' => ExperienceType::from('freelance'),
                'lien'           => null,
                'description'    => 'Created dashboards and analytics reports.',
            ],
            [
                'user'           => 3,
                'dateDebut'      => new \DateTime('2022-07-01'),
                'dateFin'        => new \DateTime('2022-09-01'),
                'entreprise'     => 'Tunisie Telecom',
                'experienceType' => ExperienceType::from('internship'),
                'lien'           => null,
                'description'    => 'Network monitoring and security audits.',
            ],
        ];

        foreach ($experiences as $data) {
            $experience = new Experience();
            $experience->setUser($manager->getRepository(User::class)->find($data['user']));
            $experience->setDateDebut($data['dateDebut']);
            $experience->setDateFin($data['dateFin']);
            $experience->setEntreprise($data['entreprise']);
            $experience->setExperienceType($data['experienceType']);
            $experience->setLien($data['lien']);
            $experience->setDescription($data['description']);

            $manager->persist($experience);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
