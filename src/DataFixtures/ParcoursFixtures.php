<?php

namespace App\DataFixtures;

use App\Entity\Filiere;
use App\Entity\Parcours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParcoursFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['Genie Logiciel',             1],
            ['Data Engineering',           1],
            ['Cyber Security',             2],
            ['Cloud & Networks',           2],
            ['Automation Industrielle',    3],
            ['Embedded Systems',           3],
            ['Mecatronique',               4],
            ['Instrumentation Biomedicale',5],
            ['Chimie Industrielle',        6],
        ];

        foreach ($data as [$name, $filiereId]) {
            $parcours = new Parcours();
            $parcours->setName($name);
            $parcours->setFiliere($manager->getRepository(Filiere::class)->find($filiereId));

            $manager->persist($parcours);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            FiliereFixtures::class,
        ];
    }
}
