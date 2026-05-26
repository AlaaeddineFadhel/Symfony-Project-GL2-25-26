<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\JobRepository;

class JobDetailController extends AbstractController
{
    #[Route('/job/{id}', name: 'job_detail')]
    public function show(int $id): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

    
        $jobRepo = new JobRepository();


        $job = $jobRepo->findById($id);

        if (!$job) {
            throw $this->createNotFoundException('Job not found');
        }
        $salaryMin = $job->salary_min ?? null;
        $salaryMax = $job->salary_max ?? null;
        $currency  = $job->currency ?: 'TND';

        if ($salaryMin === null && $salaryMax === null) {
            $salaryText = 'Not specified';
        } elseif ($salaryMin !== null && $salaryMax !== null) {
            $salaryText = number_format((float)$salaryMin, 2) .
                ' - ' .
                number_format((float)$salaryMax, 2) .
                ' ' . $currency;
        } elseif ($salaryMin !== null) {
            $salaryText = number_format((float)$salaryMin, 2) . ' ' . $currency;
        } else {
            $salaryText = number_format((float)$salaryMax, 2) . ' ' . $currency;
        }

        $experienceText = $job->req_experience === null
            ? 'Not specified'
            : $job->req_experience . ' years';

        $countryText = $job->country_name ?: 'Not specified';
        $cityText    = $job->city_name ?: 'Not specified';

        $publicationText = $job->date_publication ?: 'Not specified';
        $deadlineText    = $job->deadline ?: 'Not specified';


        return $this->render('job/jobdetail.html.twig', [
            'job' => $job,

            'salaryText' => $salaryText,
            'experienceText' => $experienceText,
            'countryText' => $countryText,
            'cityText' => $cityText,
            'publicationText' => $publicationText,
            'deadlineText' => $deadlineText,
        ]);
    }
}