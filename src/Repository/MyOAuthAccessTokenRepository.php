<?php

namespace App\Repository;

use App\Entity\MyOAuthAccessToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

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
        $tokenDetails = $this->manager->getRepository(MyOAuthAccessToken::class)->findOneBy(['identifier' => $token]);

        $scope = $tokenDetails->getScopes();

        $scopeArray = preg_split("/[\s,]+/", $scope);

        return $scopeArray;
    }

    /**
     * @param $token
     * @return bool
     */
    public function isExistToken($token): bool
    {
        $isExist = $this->findOneBy(['identifier' => $token]);

        if($isExist){
            return true;
        }
        return false;
    }

    public function checkTokenTerm($token): bool
    {
        $isExist = $this->findOneBy(['identifier' => $token]);
        $date = new DateTime(date('Y-m-d H:i:s'));
        $datemp1 = $isExist->getMakeDate();
        $datemp2 = clone($datemp1);
        $datemp2->modify('+1 day');

        if($isExist){
            if($datemp1 < $date && $datemp2 > $date){
                return true;
            }
            $isExist->setIsActive(false);
            return false;
        }

        return false;
    }

    public function checkTokenUser($author, $token): bool
    {
        $isExist = $this->findOneBy(['identifier' => $token]);

        if($isExist->getUserId() == $author){
            return true;
        }
        return false;
    }

    public function checkScope($scope, $token)
    {
        $scopeArray = $this->getTokenScope($token);
        $flag = false;

        foreach ($scopeArray as $item){
            if($item == $scope){
                $flag = true;
            }
        }
        return $flag;
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
