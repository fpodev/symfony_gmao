<?php

namespace App\Repository;

use App\Entity\CompagnyService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompagnyService|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompagnyService|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompagnyService[]    findAll()
 * @method CompagnyService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompagnyServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompagnyService::class);
    }

    // /**
    //  * @return CompagnyService[] Returns an array of CompagnyService objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompagnyService
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
