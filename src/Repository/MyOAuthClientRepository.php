<?php

namespace App\Repository;

use App\Entity\MyOAuthClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MyOAuthClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyOAuthClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyOAuthClient[]    findAll()
 * @method MyOAuthClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyOAuthClientRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, MyOAuthClient::class);
        $this->manager = $manager;
    }

    public function saveClient($identifier, $name, $secret)
    {
        $newClient = new MyOAuthClient();
        $newClient->setIdentifier($identifier);
        $newClient->setName($name);
        $newClient->setSecret($secret);

        $this->manager->persist($newClient);
        $this->manager->flush();
    }

    public function clientExist($identifier): bool
    {
        $isExist = $this->findBy(['identifier' => $identifier]);
        if ($isExist){
            return true;
        }
        else{
            return false;
        }
    }

    public function checkSecret($identifier, $secret): bool
    {
        $isExits = $this->findOneBy(['identifier' => $identifier]);
        $temp = $isExits->getSecret();

        if ($temp === $secret){
            return true;
        }
        return false;
    }

    public function updateParameters($identifier, $grant, $scope)
    {
        $existingClient = $this->manager->getRepository(MyOAuthClient::class)->findOneBy(['identifier' => $identifier]);

        if(strlen($grant) != 0 && $grant != "null"){
            $existingClient->setGrants($grant);
        }

        # TODO: Dodać sprawdzanie czy scope istnieje (+ dodać typy scopów)

        if(strlen($scope) != 0 && $scope != "null"){
            $existingClient->setScopes($scope);
        }

        $this->manager->flush();
    }

    public function deActive($identifier, $secret)
    {
        $existingClient = $this->manager->getRepository(MyOAuthClient::class)->findOneBy(['identifier' => $identifier]);

        $existingClient->setIsActive(false);

        $this->manager->flush();
    }

    public function upActive($identifier, $secret)
    {
        $existingClient = $this->manager->getRepository(MyOAuthClient::class)->findOneBy(['identifier' => $identifier]);

        $existingClient->setIsActive(true);

        $this->manager->flush();
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
