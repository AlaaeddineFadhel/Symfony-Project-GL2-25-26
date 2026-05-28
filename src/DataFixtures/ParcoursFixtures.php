<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ParcoursFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['Genie Logiciel', 1],
            ['Data Engineering', 1],
            ['Cyber Security', 2],
            ['Cloud & Networks', 2],
            ['Automation Industrielle', 3],
            ['Embedded Systems', 3],
            ['Mecatronique', 4],
            ['Instrumentation Biomedicale', 5],
            ['Chimie Industrielle', 6],
        ];

        foreach ($data as [$name, $filiereId]) {

            $parcours = new Parcours();

            $parcours->setName($name);

            // filiere_id is an object relation
            $filiere = $manager->getRepository(Filiere::class)->find($filiereId);

            $parcours->setFiliere($filiere);

            $manager->persist($parcours);
        }

        $manager->flush();
    }
}
