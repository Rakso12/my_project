<?php

namespace App\Repository;

use App\Entity\HashToPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HashToPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method HashToPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method HashToPost[]    findAll()
 * @method HashToPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HashToPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HashToPost::class);
    }

    // /**
    //  * @return HashToPost[] Returns an array of HashToPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HashToPost
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
