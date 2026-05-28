<?php

namespace App\DataFixtures;

use App\Entity\Recommendation;  // fix: one 'm'
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecommendationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $recommandations = [
            [
                'fromUser' => 'user_1',
                'toUser'   => 'user_2',
                'texte'    => 'Yasmine is extremely skilled in data engineering and teamwork.',
            ],
            [
                'fromUser' => 'user_2',
                'toUser'   => 'user_1',
                'texte'    => 'Ahmed is a reliable backend developer with strong problem-solving skills.',
            ],
            [
                'fromUser' => 'user_4',
                'toUser'   => 'user_3',
                'texte'    => 'Omar has excellent cybersecurity knowledge and analytical thinking.',
            ],
        ];

        foreach ($recommandations as $data) {
            $recommandation = new Recommendation();
            $recommandation->setFromUser($this->getReference($data['fromUser'], User::class));
            $recommandation->setToUser($this->getReference($data['toUser'], User::class));
            $recommandation->setTexte($data['texte']);

            $manager->persist($recommandation);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
