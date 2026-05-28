<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SearchType;

final class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchType::class);

        return $this->render('recherche/index.html.twig', [
            'controller_name' => 'RechercheController',
            'form' => $form->createView(),
        ]);
    }
}
