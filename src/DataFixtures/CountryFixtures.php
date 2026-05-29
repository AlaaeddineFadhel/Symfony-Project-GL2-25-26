<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $countries = ['Tunisia', 'France','Canada','Germany'];
        foreach ($countries as $country) {
            $object = new Country();
            $object->setName($country);
            $manager->persist($object);
        }

        $manager->flush();
    }
}
