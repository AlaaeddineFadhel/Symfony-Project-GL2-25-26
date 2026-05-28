<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\JobRepository;

class JobDetailController extends AbstractController
{
    #[Route('/job/{id}', name: 'job_detail')]
    public function show(int $id, JobRepository $jobRepo): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $job = $jobRepo->find($id);

        if (!$job) {
            throw $this->createNotFoundException('Job not found');
        }

        $salaryMin = $job->getSalaryMin();
        $salaryMax = $job->getSalaryMax();
        $currency  = $job->getCurrency() ?: 'TND';

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

        $experienceText = $job->getReqExperience() === null
            ? 'Not specified'
            : $job->getReqExperience() . ' years';

        $countryText = $job->getCountry()?->getName() ?: 'Not specified';
        $cityText    = $job->getCity()?->getName() ?: 'Not specified';

        $publicationText = $job->getDatePublication()?->format('Y-m-d') ?: 'Not specified';
        $deadlineText    = $job->getDeadline()?->format('Y-m-d') ?: 'Not specified';

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