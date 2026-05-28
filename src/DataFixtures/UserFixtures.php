<?php

namespace App\DataFixtures;

use App\Entity\Insatien;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'email'        => 'arij.chebbi@gmail.com',
                'passwordHash' => '$2y$12$3F/.J4/r2IFQbD0S1d2FZesFTblTSzQYKPC8ht2sDlXzOeopo./w.',
                'profileLink'  => 'https://portfolio-ahmed.dev',
                'githubLink'   => 'https://github.com/ahmedbenamor',
                'linkedinLink' => 'https://linkedin.com/in/ahmedbenamor',
                'bio'          => 'Software engineer passionate about AI and distributed systems.',
                'avatarUrl'    => 'https://randomuser.me/api/portraits/men/1.jpg',
                'insatien'     => 'insatien_1',
            ],
            [
                'email'        => 'loua.klai@gmail.com',
                'passwordHash' => '$2y$12$3F/.J4/r2IFQbD0S1d2FZesFTblTSzQYKPC8ht2sDlXzOeopo./w.',
                'profileLink'  => 'https://yasmine-tech.dev',
                'githubLink'   => 'https://github.com/yasminetr',
                'linkedinLink' => 'https://linkedin.com/in/yasminetr',
                'bio'          => 'Data engineering student interested in big data and analytics.',
                'avatarUrl'    => 'https://randomuser.me/api/portraits/women/2.jpg',
                'insatien'     => 'insatien_2',
            ],
            [
                'email'        => 'wala.selmi@gmail.com',
                'passwordHash' => '$2y$12$3F/.J4/r2IFQbD0S1d2FZesFTblTSzQYKPC8ht2sDlXzOeopo./w.',
                'profileLink'  => null,
                'githubLink'   => 'https://github.com/walaselmi',
                'linkedinLink' => 'https://linkedin.com/in/walaselmi',
                'bio'          => 'Cybersecurity enthusiast and CTF player.',
                'avatarUrl'    => 'https://randomuser.me/api/portraits/men/3.jpg',
                'insatien'     => 'insatien_3',
            ],
            [
                'email'        => 'sarra.gharbi@gmail.com',
                'passwordHash' => '$2y$12$3F/.J4/r2IFQbD0S1d2FZesFTblTSzQYKPC8ht2sDlXzOeopo./w.',
                'profileLink'  => null,
                'githubLink'   => 'https://github.com/sarragh',
                'linkedinLink' => 'https://linkedin.com/in/sarragh',
                'bio'          => 'Full stack developer and open-source contributor.',
                'avatarUrl'    => 'https://randomuser.me/api/portraits/women/4.jpg',
                'insatien'     => 'insatien_4',
            ],
            [
                'email'        => 'mohamed.jlassi@gmail.com',
                'passwordHash' => '$2y$12$3F/.J4/r2IFQbD0S1d2FZesFTblTSzQYKPC8ht2sDlXzOeopo./w.',
                'profileLink'  => null,
                'githubLink'   => 'https://github.com/mjlassi',
                'linkedinLink' => 'https://linkedin.com/in/mjlassi',
                'bio'          => 'Cloud engineer working on scalable infrastructures.',
                'avatarUrl'    => 'https://randomuser.me/api/portraits/men/5.jpg',
                'insatien'     => 'insatien_5',
            ],
        ];

        foreach ($users as $i => $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPasswordHash($data['passwordHash']);
            $user->setProfileLink($data['profileLink']);
            $user->setGithubLink($data['githubLink']);
            $user->setLinkedinLink($data['linkedinLink']);
            $user->setBio($data['bio']);
            $user->setAvatarUrl($data['avatarUrl']);
            $user->setInsatien($this->getReference($data['insatien'], Insatien::class));

            $manager->persist($user);
            $this->addReference('user_' . ($i + 1), $user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            InsatienFixtures::class,
        ];
    }
}
