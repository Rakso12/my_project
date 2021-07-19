<?php

namespace App\Repository;

use App\Entity\MyOAuthAccessToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MyOAuthAccessToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyOAuthAccessToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyOAuthAccessToken[]    findAll()
 * @method MyOAuthAccessToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyOAuthAccessTokenRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * MyOAuthAccessTokenRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, MyOAuthAccessToken::class);
        $this->manager = $manager;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function generateToken()
    {
        $tmp = random_bytes(20);
        $token = bin2hex($tmp);
        return $token;
    }

    /**
     * @param $username
     * @param $token
     * @param $client_id
     * @throws \Exception
     */
    public function setAccess($username, $token, $client_id)
    {
        $newToken = new MyOAuthAccessToken();

        $newToken->setUserId($username);
        $newToken->setIdentifier($token);
        $newToken->setClientId($client_id);
        $newToken->setScopes("");
        $newToken->setIsActive(true);
        $newToken->setMakeDate();

        $this->manager->persist($newToken);
        $this->manager->flush();
    }

    /**
     * @param $token
     * @return array|false|string[]
     */
    public function getTokenScope($token)
    {
        $tokenDetails = $this->findOneBy(['identifier' => $token]);

        $scope = $tokenDetails['scope'];

        $scopeArray = preg_split("/[\s,]+/", $scope);

        return $scopeArray;
    }

    /**
     * @param $token
     * @return bool
     */
    public function isExistToken($token)
    {
        $isExits = $this->findOneBy(['identifier' => $token]);

        if($isExits){
            return true;
        }
        return false;
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
