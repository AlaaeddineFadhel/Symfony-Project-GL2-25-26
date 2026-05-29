<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    private const SKILLS = [
        'Java',
        'Spring Boot',
        'Symfony',
        'React',
        'Angular',
        'Docker',
        'Kubernetes',
        'Python',
        'Machine Learning',
        'SQL',
        'Oracle',
        'Linux',
        'Cybersecurity',
        'Networking',
        'Node.js',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::SKILLS as $i => $name) {
            $skill = new Skill();
            $skill->setName($name);

            $manager->persist($skill);
            $this->addReference('skill_' . ($i + 1), $skill);
        }

        $manager->flush();
    }
}
