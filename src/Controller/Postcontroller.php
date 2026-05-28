<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class PostController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em) {}

    #[Route('/post/create', name: 'app_post_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($request->isMethod('GET')) {
            return $this->render('post/create.html.twig');
        }

        // Get the text from a textarea (make sure your feed/post modal has name="content")
        $content = $request->request->get('content');

        if (!empty(trim($content))) {
            $post = new Post();
            $post->setContent($content);
            $post->setUser($currentUser);
            $post->setCreatedAt(new \DateTimeImmutable());

            $this->em->persist($post);
            $this->em->flush();

            $this->addFlash('success', 'Votre post a été publié !');
        } else {
            $this->addFlash('error', 'Le contenu du post ne peut pas être vide.');
        }

        // Redirect safely back to the profile page
        return $this->redirectToRoute('app_my_profile');
    }
}
