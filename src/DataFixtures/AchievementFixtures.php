<?php

namespace App\DataFixtures;

use App\Entity\Achievement;
use App\Entity\User;
use App\Enum\AchievementType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AchievementFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $achievements = [
            [
                'user'            => 'user_1',
                'title'           => 'Hackathon Winner',
                'issuer'          => 'INSAT',
                'achievementType' => AchievementType::Competition,
                'dateObtained'    => new \DateTime('2024-04-15'),
                'lien'            => null,
                'description'     => 'Won first place in INSAT Hackathon.',
            ],
            [
                'user'            => 'user_2',
                'title'           => 'NVIDIA Computer Vision Certification',
                'issuer'          => 'NVIDIA',
                'achievementType' => AchievementType::Award,
                'dateObtained'    => new \DateTime('2025-02-16'),
                'lien'            => null,
                'description'     => 'Certification in Computer Vision for Industrial Inspection.',
            ],
            [
                'user'            => 'user_3',
                'title'           => 'Top CTF Player',
                'issuer'          => 'Tunisia CyberCup',
                'achievementType' => AchievementType::Competition,
                'dateObtained'    => new \DateTime('2023-11-10'),
                'lien'            => null,
                'description'     => 'Ranked in top 5 nationally.',
            ],
        ];

        foreach ($achievements as $data) {
            $achievement = new Achievement();
            $achievement->setUser($this->getReference($data['user'], User::class));
            $achievement->setTitle($data['title']);
            $achievement->setIssuer($data['issuer']);
            $achievement->setAchievementType($data['achievementType']);
            $achievement->setDateObtained($data['dateObtained']);
            $achievement->setLien($data['lien']);
            $achievement->setDescription($data['description']);

            $manager->persist($achievement);
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
