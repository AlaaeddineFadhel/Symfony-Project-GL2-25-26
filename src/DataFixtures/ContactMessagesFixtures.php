<?php

namespace App\DataFixtures;


use App\Entity\ContactMessages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactMessagesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $messages = [
            [
                'firstName' => 'Ali',
                'lastName'  => 'Ben Salah',
                'email'     => 'ali.bensalah@gmail.com',
                'topic'     => 'Internship',
                'message'   => 'Hello, I would like to know if internship offers are still available.',
            ],
            [
                'firstName' => 'Meriem',
                'lastName'  => 'Khalfallah',
                'email'     => 'meriem.kh@gmail.com',
                'topic'     => 'Bug Report',
                'message'   => 'There is an issue when uploading profile pictures.',
            ],
            [
                'firstName' => 'Hichem',
                'lastName'  => 'Tlili',
                'email'     => 'hichem.tlili@gmail.com',
                'topic'     => 'Partnership',
                'message'   => 'We are interested in collaborating with INSAT alumni.',
            ],
        ];

        foreach ($messages as $data) {
            $message = new ContactMessages();
            $message->setFirstName($data['firstName']);
            $message->setLastName($data['lastName']);
            $message->setEmail($data['email']);
            $message->setTopic($data['topic']);
            $message->setMessage($data['message']);

            $manager->persist($message);
        }

        $manager->flush();
    }
}
