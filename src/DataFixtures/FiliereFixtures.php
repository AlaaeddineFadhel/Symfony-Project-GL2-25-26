<?php

namespace App\DataFixtures;

use App\Entity\Filiere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FiliereFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $filiere = new Filiere();
        $filiere->setName('GL');
        $manager->persist($filiere);
        $filiere->setName('RT');
        $manager->persist($filiere);
        $filiere->setName('IIA');
        $manager->persist($filiere);
        $filiere->setName('IMI');
        $manager->persist($filiere);
        $filiere->setName('CH');
        $manager->persist($filiere);
        $filiere->setName('BIO');
        $manager->flush();
    }
}
