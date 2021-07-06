<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    private static $firstName = [
        'Jim',
        'Simon',
        'Carl',
        'Evy',
        'Murphy',
        'Greg',
        'Adam',
        'Peter',
    ];

    public function load(ObjectManager $manager)
    {
        for($i = 1; $i < 5; $i++) {
            $user = new User();
            $user->setEmail('uzytkownik'.$i.'@xyz.com');
            $user->setFirstName(self::$firstName[$i]);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
