<?php

namespace App\Repository;

use App\Entity\Hashtag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hashtag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hashtag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hashtag[]    findAll()
 * @method Hashtag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HashtagRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * HashtagRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Hashtag::class);
        $this->manager = $manager;
    }

    /**
     * @param $name
     */
    public function saveHashtag($name)
    {
        $newHashtag = new Hashtag();
        $newHashtag->setName($name);

        $this->manager->persist($newHashtag);
        $this->manager->flush();
    }

    /**
     * @param $hashtag
     */
    public function removeHashtag($hashtag)
    {
        $this->manager->remove($hashtag);
        $this->manager->flush();
    }


    // /**
    //  * @return Hashtag[] Returns an array of Hashtag objects
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
    public function findOneBySomeField($value): ?Hashtag
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
