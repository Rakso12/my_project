<?php

namespace App\Repository;

use App\Entity\MyOAuthClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MyOAuthClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyOAuthClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyOAuthClient[]    findAll()
 * @method MyOAuthClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyOAuthClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyOAuthClient::class);
    }

    public function saveClient($identifier, $name, $secret, $grants, $scopes)
    {
        $newClient = new MyOAuthClient();
        $newClient->setIdentifier($identifier);
        $newClient->setName($name);
        $newClient->setSecret($secret);

        # TODO zmienić scopy i granty na wrzucanie tablicy do bazy

        $newClient->setGrants($grants);
        $newClient->setScopes($scopes);
    }

    // /**
    //  * @return MyOAuthClient[] Returns an array of MyOAuthClient objects
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
    public function findOneBySomeField($value): ?MyOAuthClient
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
