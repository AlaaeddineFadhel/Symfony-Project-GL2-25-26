<?php

namespace App\Controller; 

use App\Entity\ContactMessages;
use App\Repo\ContactMessagesRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactMessagesController extends AbstractController
{
      #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        ContactMessagesRepository $repository
    ): Response {
        //login check
         if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $contact = new ContactMessages();
        $form    = $this->createForm(ContactType::class, $contact);
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($contact, flush: true);
 
            $this->addFlash('contact_success', 'Message Received!');
 
            // PRG — prevents duplicate submission on page refresh
            return $this->redirectToRoute('app_contact', ['sent' => 1]);
        }
 
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form,
            'sent'        => $request->query->getBoolean('sent'),
        ]);
    }
}
?>