<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $posts = [
            [
                'user'    => 'user_1',
                'content' => 'Shared a few notes from my latest backend internship experience.',
            ],
            [
                'user'    => 'user_2',
                'content' => 'Looking for collaborators on a data engineering study project.',
            ],
            [
                'user'    => 'user_3',
                'content' => 'Posted useful cybersecurity resources for students preparing CTFs.',
            ],
        ];

        foreach ($posts as $i => $data) {
            $post = new Post();
            $post->setUser($this->getReference($data['user'], User::class));
            $post->setContent($data['content']);

            $manager->persist($post);
            $this->addReference('post_' . ($i + 1), $post);
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
