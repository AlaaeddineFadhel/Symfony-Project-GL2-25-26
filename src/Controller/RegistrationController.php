<?php

namespace App\Controller;

use App\Entity\Insatien;
use App\Entity\User;
use App\Form\RegistrationForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request                     $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface      $em,
        Security                    $security
    ): Response {
        // Redirige si déjà connecté
        if ($this->getUser()) {
            return $this->redirectToRoute('app_feed');
        }
        $user = new user();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $insatien = new Insatien();
            $insatien->setNom($form->get('nom')->getData());
            $insatien->setPrenom($form->get('prenom')->getData());
            $insatien->setEmail($form->get('email')->getData());
 
            $user->setPasswordHash(
                $hasher->hashPassword($user, $form->get('plainPassword')->getData())
            );
            $user->setInsatien($insatien);
            $user->setUpdatedAt(new \DateTime());
 
            $em->persist($insatien);
            $em->persist($user);
            $em->flush();
 
            return $security->login($user, 'form_login', 'main');
        }
 
        return $this->render('security/login.html.twig', [
            'registrationForm' => $form,
            'loginError'       => null,
            'lastUsername'     => '',
            'activePanel'      => 'register',
        ]);
    }

     
 }

?>