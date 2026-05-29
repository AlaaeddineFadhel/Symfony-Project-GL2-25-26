<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\ProjectSkills;
use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectSkillFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['project_1', 'skill_2'],
            ['project_1', 'skill_10'],
            ['project_1', 'skill_6'],

            ['project_2', 'skill_8'],
            ['project_2', 'skill_9'],
            ['project_2', 'skill_10'],

            ['project_3', 'skill_3'],
            ['project_3', 'skill_4'],
            ['project_3', 'skill_10'],
        ];

        foreach ($data as [$projectRef, $skillRef]) {
            $projectSkill = new ProjectSkills();
            $projectSkill->setProject($this->getReference($projectRef, Project::class));
            $projectSkill->setSkill($this->getReference($skillRef, Skill::class));

            $manager->persist($projectSkill);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProjectFixtures::class,
            SkillFixtures::class,
        ];
    }
}
