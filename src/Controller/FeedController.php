<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use App\Repository\JobRepository;
use App\Repository\PostRepository;

class FeedController extends AbstractController
{
    #[Route('/feed', name: 'feed')]
    public function index(
        UserRepository $userRepo,
        JobRepository  $jobRepo,
        PostRepository $postRepo
    ): Response
    {
        // login check
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('feed/index.html.twig', [
            'profiles' => $userRepo->findAllProfiles(),
            'jobs' => $jobRepo->findAllJobs(),
            'internships' => $jobRepo->findInternships(),
            'posts' => $postRepo->findAllPosts(),
        ]);
    }
//zeyda ?
    #[Route('/feed-test', name: 'app_feed_test')]
    public function test(): Response
    {
        return $this->render('base.html.twig');
    }
}
