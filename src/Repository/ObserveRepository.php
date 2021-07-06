<?php

namespace App\Repository;

use App\Entity\Observe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Observe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Observe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Observe[]    findAll()
 * @method Observe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObserveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Observe::class);
    }

    // /**
    //  * @return Observe[] Returns an array of Observe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Observe
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
