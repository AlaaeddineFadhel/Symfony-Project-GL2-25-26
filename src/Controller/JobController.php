<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Job;
use App\Enum\JobMode;
use App\Enum\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\JobRepository;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;

class JobController extends AbstractController
{
    #[Route('/jobs', name: 'jobs')]
    public function index(Request $request, JobRepository $jobRepo): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $title   = $request->query->get('title', '');
        $country = $request->query->get('country', '');
        $city    = $request->query->get('city', '');
        $jobType = $request->query->get('job_type', '');

        $remote  = $request->query->get('remote', '');
        $onsite  = $request->query->get('onsite', '');
        $hybrid  = $request->query->get('hybrid', '');

        $salary  = $request->query->get('salary', 0);

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

    #[Route('/job/new', name: 'app_job_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        CountryRepository $countryRepo,
        CityRepository $cityRepo
    ): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($request->isMethod('POST')) {
            $job = new Job();
            $job->setTitre((string) $request->request->get('titre', ''));
            $job->setEntreprise($request->request->get('entreprise'));
            $job->setDescription($request->request->get('description'));
            $job->setApplicationLink($request->request->get('applicationLink'));
            $job->setCompanyLink($request->request->get('companyLink'));
            $job->setContactEmail((string) $request->request->get('contactEmail', ''));
            $job->setRequirements($request->request->get('requirements'));
            $job->setResponsibilities($request->request->get('responsibilities'));
            $job->setSalaryMin($request->request->get('salaryMin'));
            $job->setSalaryMax($request->request->get('salaryMax'));
            $job->setCurrency((string) $request->request->get('currency', 'TND'));
            $job->setReqExperience($request->request->get('reqExperience') !== '' ? (int) $request->request->get('reqExperience') : null);
            $job->setDatePublication(new \DateTime());
            $job->setDeadline($request->request->get('deadline') ? new \DateTime((string) $request->request->get('deadline')) : null);
            $job->setCreatedBy($this->getUser());

            $jobType = JobType::tryFrom((string) $request->request->get('jobType', 'full-time')) ?? JobType::FullTime;
            $jobMode = JobMode::tryFrom((string) $request->request->get('jobMode', 'remote')) ?? JobMode::Remote;
            $job->setJobType($jobType);
            $job->setJobMode($jobMode);

            $countryId = $request->request->get('country');
            if ($countryId) {
                $country = $countryRepo->find((int) $countryId);
                if ($country instanceof Country) {
                    $job->setCountry($country);
                }
            }

            $cityId = $request->request->get('city');
            if ($cityId) {
                $city = $cityRepo->find((int) $cityId);
                if ($city instanceof City) {
                    $job->setCity($city);
                }
            }

            if (trim($job->getTitre() ?? '') === '' || trim($job->getContactEmail() ?? '') === '') {
                $this->addFlash('error', 'Title and contact email are required.');
            } else {
                $em->persist($job);
                $em->flush();
                $this->addFlash('success', 'Job posted successfully.');
                return $this->redirectToRoute('jobs');
            }
        }

        return $this->render('job/create.html.twig', [
            'countries' => $countryRepo->findAll(),
            'cities' => $cityRepo->findAll(),
        ]);
    }
}
