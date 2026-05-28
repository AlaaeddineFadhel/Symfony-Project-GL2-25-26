<?php

namespace App\Controller;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('login/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    #[Route('/logout', name:'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This should never be reached.');
    }

    // Dev helper: create a test user with minimal related entities so you can log in.
    #[Route('/dev/create-test-user', name: 'dev_create_test_user', methods: ['GET'])]
    public function createTestUser(EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        // Create a Filiere if none exists
        $filiereRepo = $em->getRepository(\App\Entity\Filiere::class);
        $filiere = $filiereRepo->findOneBy([]);
        if (!$filiere) {
            $filiere = new \App\Entity\Filiere();
            $filiere->setName('Default Filiere');
            $em->persist($filiere);
        }

        // Create an Insatien
        $insatien = new \App\Entity\Insatien();
        $insatien->setNom('Doe');
        $insatien->setPrenom('John');
        $insatien->setEmail('test@example.com');
        $insatien->setPromoYear(2026);
        $insatien->setFiliere($filiere);
        $em->persist($insatien);

        // Create User
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setInsatien($insatien);
        $hashed = $hasher->hashPassword($user, 'secret123');
        $user->setPasswordHash($hashed);
        $em->persist($user);

        $em->flush();

        return new Response('Created test user: test@example.com / secret123');
    }
}
