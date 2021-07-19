<?php

namespace App\Repository;

use App\Entity\HashToPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HashToPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method HashToPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method HashToPost[]    findAll()
 * @method HashToPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HashToPostRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * HashToPostRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, HashToPost::class);
        $this->manager = $manager;
    }

    /**
     * @param $id_post
     * @param $id_hash
     */
    public function saveHashToPost($id_post, $id_hash)
    {
        $newHashToPost = new HashToPost();
        $newHashToPost->setIdPost($id_post);
        $newHashToPost->setIdHash($id_hash);

        $this->manager->persist($newHashToPost);
        $this->manager->flush();
    }

    /**
     * @param $hashToPost
     * @return mixed
     */
    public function updateHashToPost($hashToPost)
    {
        $this->manager->persist($hashToPost);
        $this->manager->flush();

        return $hashToPost;
    }

    /**
     * @param HashToPost $hashToPost
     */
    public function removeHashToPost(HashToPost $hashToPost)
    {
        $this->manager->remove($hashToPost);
        $this->manager->flush();
    }

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
