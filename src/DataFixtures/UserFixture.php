<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $passwordHasher;

     public function __construct(UserPasswordHasherInterface $passwordHasher)
     {
         $this->passwordHasher = $passwordHasher;
     }

    private static $firstNameArray = [
        'Jim',
        'Simon',
        'Carl',
        'Evy',
        'Murphy',
        'Greg',
        'Adam',
        'Peter',
    ];

    private static $passwordArray = [
        'P@ssword',
        'CommonPassword',
        'Carl12345',
        'MyLittleDog',
        'SuperDangerPassword',
        'qwerty',
        'zaqwsx123',
    ];

    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 5; $i++) {
            $user = new User();
            $user->setEmail('uzytkownik'.$i.'@xyz.com');
            $user->setFirstName(self::$firstNameArray[$i]);
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                self::$passwordArray[$i]
            ));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
