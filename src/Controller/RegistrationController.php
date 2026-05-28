<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Insatien;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET','POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('feed');
        }

        if ($request->isMethod('POST')) {
            $email = (string) $request->request->get('email');
            $plain = (string) $request->request->get('password');
            $prenom = (string) $request->request->get('prenom');
            $nom = (string) $request->request->get('nom');

            if (!$email || !$plain || !$prenom || !$nom) {
                $this->addFlash('error', 'Please fill all required fields.');
                return $this->redirectToRoute('app_register');
            }

            // ensure no duplicate
            $existing = $em->getRepository(User::class)->findOneBy(['email' => $email]);
            if ($existing) {
                $this->addFlash('error', 'Email already registered.');
                return $this->redirectToRoute('app_register');
            }

            // find or create a Filiere (Insatien requires filiere non-null)
            $filiereRepo = $em->getRepository(\App\Entity\Filiere::class);
            $filiere = $filiereRepo->findOneBy([]);
            if (!$filiere) {
                $filiere = new \App\Entity\Filiere();
                $filiere->setName('Default');
                $em->persist($filiere);
            }

            $insatien = new Insatien();
            $insatien->setPrenom($prenom);
            $insatien->setNom($nom);
            $insatien->setEmail($email);
            $insatien->setFiliere($filiere);
            $insatien->setPromoYear((int)($request->request->get('promoYear') ?? 0));
            $em->persist($insatien);

            $user = new User();
            $user->setEmail($email);
            $user->setInsatien($insatien);
            $hashed = $hasher->hashPassword($user, $plain);
            $user->setPasswordHash($hashed);
            $em->persist($user);

            $em->flush();

            $this->addFlash('success', 'Registration successful. Please login.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig');
    }
}
