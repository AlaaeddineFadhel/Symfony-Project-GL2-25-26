<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\JobRepository;

class JobController extends AbstractController
{
    #[Route('/jobs', name: 'jobs')]
    public function index(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }


        $jobRepo = new JobRepository();
        $title   = $request->query->get('title', '');
        $country = $request->query->get('country', '');
        $city    = $request->query->get('city', '');
        $jobType = $request->query->get('job_type', '');

        $remote  = $request->query->get('remote', '');
        $onsite  = $request->query->get('onsite', '');
        $hybrid  = $request->query->get('hybrid', '');

        $salary  = $request->query->get('salary', 0);

        // dataa
        $jobs = $jobRepo->findFiltered(
            $title,
            $country,
            $city,
            $jobType,
            $remote,
            $salary,
            $onsite,
            $hybrid
        );
        return $this->render('job/index.html.twig', [
            'jobs'    => $jobs,
            'title'   => $title,
            'country' => $country,
            'city'    => $city,
            'jobType' => $jobType,
            'remote'  => $remote,
            'onsite'  => $onsite,
            'hybrid'  => $hybrid,
            'salary'  => $salary
        ]);
    }
}