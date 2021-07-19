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

    /**
     * MyOAuthClientRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, MyOAuthClient::class);
        $this->manager = $manager;
    }

    /**
     * @param $identifier
     * @param $name
     * @param $secret
     */
    public function saveClient($identifier, $name, $secret)
    {
        $newClient = new MyOAuthClient();
        $newClient->setIdentifier($identifier);
        $newClient->setName($name);
        $newClient->setSecret($secret);

        $this->manager->persist($newClient);
        $this->manager->flush();
    }

    /**
     * @param $identifier
     * @return bool
     */
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

    /**
     * @param $identifier
     * @param $secret
     * @return bool
     */
    public function checkSecret($identifier, $secret): bool
    {
        $isExits = $this->findOneBy(['identifier' => $identifier]);
        $temp = $isExits->getSecret();

        if ($temp === $secret){
            return true;
        }
        return false;
    }

    /**
     * @param $identifier
     * @param $grant
     * @param $scope
     */
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

    /**
     * @param $identifier
     * @param $secret
     */
    public function deActive($identifier, $secret)
    {
        $existingClient = $this->manager->getRepository(MyOAuthClient::class)->findOneBy(['identifier' => $identifier]);

        $existingClient->setIsActive(false);

        $this->manager->flush();
    }

    /**
     * @param $identifier
     * @param $secret
     */
    public function upActive($identifier, $secret)
    {
        $existingClient = $this->manager->getRepository(MyOAuthClient::class)->findOneBy(['identifier' => $identifier]);

        $existingClient->setIsActive(true);

        $this->manager->flush();
    }

    /**
     * @param $client_id
     * @param $client_secret
     * @return bool
     */
    public function checkClient($client_id, $client_secret): bool
    {
        $existingClient = $this->manager->getRepository(MyOAuthClient::class)->findOneBy(['identifier' => $client_id]);

        if($existingClient->getSecret() != $client_secret) {
            return false;
        }
        return true;
    }

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
