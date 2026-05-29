<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $projects = [
            [
                'user'        => 'user_1',
                'title'       => 'Smart Campus',
                'description' => 'Web platform for university management.',
                'lien'        => 'https://github.com/ahmedbenamor/smart-campus',
                'dateDebut'   => new \DateTime('2024-01-01'),
                'dateFin'     => new \DateTime('2024-05-01'),
            ],
            [
                'user'        => 'user_2',
                'title'       => 'Big Data Analytics',
                'description' => 'Pipeline for processing student data.',
                'lien'        => 'https://github.com/yasminetr/bigdata-project',
                'dateDebut'   => new \DateTime('2023-09-01'),
                'dateFin'     => new \DateTime('2024-01-15'),
            ],
            [
                'user'        => 'user_4',
                'title'       => 'Pharma Management App',
                'description' => 'Pharmacy stock and order management system.',
                'lien'        => 'https://github.com/sarragh/pharma-app',
                'dateDebut'   => new \DateTime('2025-01-01'),
                'dateFin'     => null,
            ],
        ];

        foreach ($projects as $i => $data) {
            $project = new Project();
            $project->setUser($this->getReference($data['user'], User::class));
            $project->setTitle($data['title']);
            $project->setDescription($data['description']);
            $project->setLien($data['lien']);
            $project->setDateDebut($data['dateDebut']);
            $project->setDateFin($data['dateFin']);

            $manager->persist($project);
            $this->addReference('project_' . ($i + 1), $project);
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
