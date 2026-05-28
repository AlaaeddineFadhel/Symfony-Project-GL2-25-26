<?php

namespace App\DataFixtures;

use App\Entity\Insatien;
use App\Entity\Parcours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InsatienFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['Chebbi', 'Arij', 'arij.chebbi@insat.ucar.tn', 2022, 1],
            ['Klai', 'Loua', 'loua.klai@insat.ucar.tn', 2023, 2],
            ['Selmi', 'Wala', 'wala.selmi@insat.ucar.tn', 2021, 3],
            ['Laarif', 'Talel', 'talel.laarif@insat.ucar.tn', 2024, 1],
            ['Fadhel', 'Alaa', 'alaa.fadhel@insat.ucar.tn', 2020, 4],
            ['Ben Salem', 'Aya', 'aya.bensalem@insat.ucar.tn', 2022, 5],
            ['Chaabani', 'Walid', 'walid.chaabani@insat.ucar.tn', 2021, 6],
            ['Kefi', 'Rim', 'rim.kefi@insat.ucar.tn', 2023, 2],
            ['Abid', 'Hedi', 'hedi.abid@insat.ucar.tn', 2019, 7],
            ['Mejri', 'Mariem', 'mariem.mejri@insat.ucar.tn', 2024, 1],
        ];

        foreach ($data as [$nom, $prenom, $email, $promoYear, $parcoursId]) {

            $insatien = new Insatien();

            $insatien->setNom($nom);
            $insatien->setPrenom($prenom);
            $insatien->setEmail($email);
            $insatien->setPromoYear($promoYear);

            // parcours_id is a relation object
            $parcours = $manager
                ->getRepository(Parcours::class)
                ->find($parcoursId);

            $insatien->setParcours($parcours);

            $manager->persist($insatien);
        }

        $manager->flush();
    }
}
