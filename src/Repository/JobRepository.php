<?php

namespace App\Repository;

use App\Entity\Job;
use App\Enum\JobType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Job>
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function findFiltered(
        string $title,
        string $country,
        string $city,
        string $jobType,
        string $remote,
        int $salary,
        string $onsite,
        string $hybrid
    ): array {
        $qb = $this->createQueryBuilder('j')
            ->leftJoin('j.country', 'c')
            ->leftJoin('j.city', 'ci')
            ->addSelect('c', 'ci');

        if ($title !== '') {
            $qb->andWhere('LOWER(j.titre) LIKE :title')
                ->setParameter('title', '%' . mb_strtolower($title) . '%');
        }

        if ($country !== '') {
            $qb->andWhere('c.id = :country')
                ->setParameter('country', (int)$country);
        }

        if ($city !== '') {
            $qb->andWhere('ci.id = :city')
                ->setParameter('city', (int)$city);
        }

        if ($jobType !== '') {
            $jobTypeEnum = JobType::tryFrom($jobType);
            if ($jobTypeEnum !== null) {
                $qb->andWhere('j.jobType = :jobType')
                    ->setParameter('jobType', $jobTypeEnum);
            }
        }

        $modes = [];
        if ($remote === '1') {
            $modes[] = 'remote';
        }
        if ($onsite === '1') {
            $modes[] = 'onsite';
        }
        if ($hybrid === '1') {
            $modes[] = 'hybrid';
        }

        if (count($modes) > 0) {
            $qb->andWhere('j.jobMode IN (:modes)')
                ->setParameter('modes', $modes);
        }

        if ($salary > 0) {
            $qb->andWhere('(
                (j.salaryMin IS NOT NULL AND j.salaryMin >= :salary)
                OR (j.salaryMax IS NOT NULL AND j.salaryMax >= :salary)
            )')
                ->setParameter('salary', $salary);
        }

        return $qb
            ->orderBy('j.datePublication', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllJobs(): array
    {
        return $this->createQueryBuilder('j')
            ->where('j.jobType != :internship')
            ->setParameter('internship', JobType::Internship)
            ->orderBy('j.datePublication', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findInternships(): array
    {
        return $this->createQueryBuilder('j')
            ->where('j.jobType = :internship')
            ->setParameter('internship', JobType::Internship)
            ->orderBy('j.datePublication', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Job[] Returns an array of Job objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Job
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
