<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [1, 'Tunis'],
            [1, 'Sfax'],
            [1, 'Sousse'],
            [1, 'Nabeul'],
            [1, 'Monastir'],
            [1, 'Ariana'],
            [2, 'Paris'],
            [2, 'Lyon'],
            [3, 'Montreal'],
            [4, 'Berlin'],
        ];

        foreach ($data as [$countryId, $name]) {
            $city = new City();
            $city->setName($name);
            $city->setCountry($manager->getRepository(Country::class)->find($countryId));

            $manager->persist($city);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
        ];
    }
}
