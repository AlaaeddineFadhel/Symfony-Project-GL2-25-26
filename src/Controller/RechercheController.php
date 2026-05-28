<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]

    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $query = trim($request->query->get('query') ?? '');
        $filter = $request->query->get('filter') ?? '';
        $qb = null;

        if ($query !== '') {
            $qb = $userRepository->createQueryBuilder('u');

            switch ($filter) {
                case 'promo':
                    $qb->join('u.insatien', 'i')->where('i.promoYear LIKE :query');
                    break;
                case 'skills':
                    $qb->join('u.userSkills', 'us')->join('us.skill', 's')->where('s.name LIKE :query');
                    break;
                case 'parcours':
                    $qb->join('u.insatien', 'i')->join('i.parcours', 'p')->where('p.name LIKE :query');
                    break;
                case 'filiere':
                    $qb->join('u.insatien', 'i')->join('i.filiere', 'f')->where('f.name LIKE :query');
                    break;
                default:
                    $qb->join('u.insatien', 'i')
                        ->where('i.nom LIKE :query OR i.prenom LIKE :query OR u.email LIKE :query');
                    break;
            }

            $qb->setParameter('query', '%' . $query . '%');
        }

        $results = $paginator->paginate(
            $qb ?? [],
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('recherche/index.html.twig', [
            'form' => $form,
            'results' => $results,
            'query' => $query,
            'filter' => $filter,
        ]);
    }}
