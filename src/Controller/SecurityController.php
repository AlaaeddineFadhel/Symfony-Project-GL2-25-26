<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController{
#[Route('/login', name: 'app_login')]
public function login(AuthenticationUtils $authenticationUtils): Response
{   
     if ($this->getUser()){
    return $this->redirectToRoute('app_feed');}
    
    registrationForm =$this->createForm(RegistrationFormType::class,new User(),[''
    'action'=> '$this->generateUrl("app_register")',
    'method'=> 'POST',
    ]);
    return $this->render('security/login.html.twig', [
        'registrationForm' => $registrationForm->createView(),
        'error' => $authenticationUtils->getLastAuthenticationError(),
        'last_username' => $authenticationUtils->getLastUsername(),
    ]);

}
#[Route('/logout', name:'app_logout')]
public function logout(): void
{
 throw new \LogicException('This should never be reached.');
 }
 
 }