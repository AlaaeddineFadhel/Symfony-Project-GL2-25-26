<?php

namespace App\Controller;

use App\Entity\ContactMessages;
use App\Repository\ContactMessagesRepository;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, ContactMessagesRepository $repository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $contact = new ContactMessages();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($contact, true);
            $this->addFlash('contact_success', 'Message Received!');
            return $this->redirectToRoute('app_contact', ['sent' => 1]);
        }

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form,
            'sent' => $request->query->getBoolean('sent'),
        ]);
    }
}
