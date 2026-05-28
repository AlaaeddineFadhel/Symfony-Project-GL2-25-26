<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture
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

            // country_id is a relation object
            $country = $manager->getRepository(Country::class)->find($countryId);

            $city->setCountry($country);

            $manager->persist($city);
        }

        $manager->flush();
    }
}
