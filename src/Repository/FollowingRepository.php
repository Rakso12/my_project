<?php

namespace App\Repository;

use App\Entity\Following;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Following|null find($id, $lockMode = null, $lockVersion = null)
 * @method Following|null findOneBy(array $criteria, array $orderBy = null)
 * @method Following[]    findAll()
 * @method Following[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowingRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * FollowingRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Following::class);
        $this->manager = $manager;
    }

    /**
     * @param Following $currentFollowing
     * @param $following_users
     */
    public function addUser(Following $currentFollowing, $following_users): void
    {
        $currentFollowing->setUsers($following_users);

        $this->manager->persist($currentFollowing);
        $this->manager->flush();
    }

    /**
     * @param Following $currentFollowing
     * @param $following_hashtags
     */
    public function addHashtag(Following $currentFollowing, $following_hashtags)
    {
        $currentFollowing->setHashtags($following_hashtags);

        $this->manager->persist($currentFollowing);
        $this->manager->flush();
    }

    /**
     * @param Following $followingUser
     * @param $newFollowingUser
     */
    public function deleteUser(Following $followingUser, $newFollowingUser)
    {
        $followingUser->setUsers($newFollowingUser);

        $this->manager->persist($followingUser);
        $this->manager->flush();
    }

    public function deleteHashtag(Following $followingHashtag, $newFollowingHash)
    {
        $followingHashtag->setHashtags($newFollowingHash);

        $this->manager->persist($followingHashtag);
        $this->manager->flush();
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Following
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
