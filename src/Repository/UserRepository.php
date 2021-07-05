<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, User::class);
        $this->manager = $manager;
    }

    /**
     * @param $email
     * @param $password
     * @param $firstName
     * @param $lastName
     * @param $birth_day
     */
    public function saveUser($email,$password,$firstName,$lastName,$birth_day)
    {
        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setPassword($password);
        $newUser->setFirstName($firstName);
        $newUser->setLastName($lastName);
        $newUser->setBirthDate($birth_day);

        $this->manager->persist($newUser);
        $this->manager->flush();
    }

    /**
     * @param User $user
     * @return User
     */
    public function updateUser(User $user): User
    {
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }

    /**
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
