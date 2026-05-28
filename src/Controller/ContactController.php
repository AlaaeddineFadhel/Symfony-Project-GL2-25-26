<?php

namespace App\Controller;

use App\Entity\ContactMessages;
use App\Form\ContactMessagesForm;
use App\Repository\ContactMessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        ContactMessagesRepository $repository
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $contact = new ContactMessages();

        $form = $this->createForm(ContactMessagesForm::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository->save($contact, flush: true);

            $this->addFlash('contact_success', 'Message Received!');

            return $this->redirectToRoute('app_contact', [
                'sent' => 1
            ]);
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
            'sent' => $request->query->getBoolean('sent'),
        ]);
    }
}
