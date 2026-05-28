<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_feed');
        }

        $registrationForm = $this->createForm(RegistrationForm::class, new user(), [
            'action' => $this->generateUrl('app_register'),
            'method' => 'POST',
        ]);

        return $this->render('security/login.html.twig', [
            'registrationForm' => $registrationForm,
            'loginError'       => $authenticationUtils->getLastAuthenticationError(),
            'lastUsername'     => $authenticationUtils->getLastUsername(),
            'activePanel'      => 'login',
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This should never be reached.');
    }
}
?>