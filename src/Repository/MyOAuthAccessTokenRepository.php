<?php

namespace App\Repository;

use App\Entity\MyOAuthAccessToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MyOAuthAccessToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyOAuthAccessToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyOAuthAccessToken[]    findAll()
 * @method MyOAuthAccessToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyOAuthAccessTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyOAuthAccessToken::class);
    }

    // /**
    //  * @return MyOAuthAccessToken[] Returns an array of MyOAuthAccessToken objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MyOAuthAccessToken
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
