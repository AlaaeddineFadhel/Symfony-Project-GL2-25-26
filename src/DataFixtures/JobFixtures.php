<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Job;
use App\Entity\User;
use App\Enum\JobType;
use App\Enum\JobMode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JobFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $jobs = [
            [
                'titre'            => 'Backend Java Developer',
                'entreprise'       => 'Vermeg',
                'jobType'          => JobType::FullTime,
                'jobMode'          => JobMode::Hybrid,
                'description'      => 'Development of enterprise backend solutions.',
                'applicationLink'  => 'https://vermeg.com/careers',
                'companyLink'      => 'https://vermeg.com',
                'contactEmail'     => 'hr@vermeg.com',
                'requirements'     => 'Java, Spring Boot, SQL',
                'responsibilities' => 'Develop REST APIs and microservices',
                'salaryMin'        => 2500,
                'salaryMax'        => 4000,
                'currency'         => 'TND',
                'reqExperience'    => 2,
                'country'          => 1,
                'city'             => 1,
                'createdBy'        => 1,
            ],
            [
                'titre'            => 'Data Engineering Intern',
                'entreprise'       => 'Sopra HR',
                'jobType'          => JobType::Internship,
                'jobMode'          => JobMode::Onsite,
                'description'      => 'Work on ETL and analytics pipelines.',
                'applicationLink'  => 'https://soprahr.com/jobs',
                'companyLink'      => 'https://soprahr.com',
                'contactEmail'     => 'internships@soprahr.com',
                'requirements'     => 'Python, SQL, Spark basics',
                'responsibilities' => 'Build and maintain data workflows',
                'salaryMin'        => 800,
                'salaryMax'        => 1200,
                'currency'         => 'TND',
                'reqExperience'    => 0,
                'country'          => 1,
                'city'             => 6,
                'createdBy'        => 2,
            ],
            [
                'titre'            => 'Cybersecurity Analyst',
                'entreprise'       => 'Telnet',
                'jobType'          => JobType::FullTime,
                'jobMode'          => JobMode::Remote,
                'description'      => 'Monitor and secure enterprise systems.',
                'applicationLink'  => 'https://groupe-telnet.com',
                'companyLink'      => 'https://groupe-telnet.com',
                'contactEmail'     => 'jobs@telnet.com',
                'requirements'     => 'Networking, Linux, Security',
                'responsibilities' => 'Incident response and vulnerability analysis',
                'salaryMin'        => 3000,
                'salaryMax'        => 5000,
                'currency'         => 'TND',
                'reqExperience'    => 3,
                'country'          => 1,
                'city'             => 1,
                'createdBy'        => 3,
            ],
        ];

        foreach ($jobs as $i => $data) {
            $job = new Job();
            $job->setTitre($data['titre']);
            $job->setEntreprise($data['entreprise']);
            $job->setJobType($data['jobType']);
            $job->setJobMode($data['jobMode']);
            $job->setDescription($data['description']);
            $job->setApplicationLink($data['applicationLink']);
            $job->setCompanyLink($data['companyLink']);
            $job->setContactEmail($data['contactEmail']);
            $job->setRequirements($data['requirements']);
            $job->setResponsibilities($data['responsibilities']);
            $job->setSalaryMin($data['salaryMin']);
            $job->setSalaryMax($data['salaryMax']);
            $job->setCurrency($data['currency']);
            $job->setReqExperience($data['reqExperience']);
            $job->setCountry($manager->getRepository(Country::class)->find($data['country']));
            $job->setCity($manager->getRepository(City::class)->find($data['city']));
            $job->setCreatedBy($manager->getRepository(User::class)->find($data['createdBy']));

            $manager->persist($job);
            $this->addReference('job_' . ($i + 1), $job);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
            CityFixtures::class,
            UserFixtures::class,
        ];
    }
}
