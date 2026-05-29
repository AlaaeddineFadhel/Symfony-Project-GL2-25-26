<?php

namespace App\DataFixtures;

use App\Entity\UserSkills;
use App\Entity\User;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserSkillFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['user_1', 'skill_1'],
            ['user_1', 'skill_2'],
            ['user_1', 'skill_6'],
            ['user_1', 'skill_10'],

            ['user_2', 'skill_8'],
            ['user_2', 'skill_9'],
            ['user_2', 'skill_10'],

            ['user_3', 'skill_13'],
            ['user_3', 'skill_14'],
            ['user_3', 'skill_12'],

            ['user_4', 'skill_3'],
            ['user_4', 'skill_4'],
            ['user_4', 'skill_15'],

            ['user_5', 'skill_6'],
            ['user_5', 'skill_7'],
            ['user_5', 'skill_12'],
        ];

        foreach ($data as [$userRef, $skillRef]) {
            $userSkill = new UserSkills();
            $userSkill->setUser($this->getReference($userRef, User::class));
            $userSkill->setSkill($this->getReference($skillRef, Skill::class));

            $manager->persist($userSkill);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SkillFixtures::class,
        ];
    }
}
