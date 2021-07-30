<?php

namespace App\DataFixtures;

use App\Entity\MyOAuthClient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OAuthFixture extends Fixture
{
    // delete from sqlite_sequence where name='your_table';

    private static $identifier = [
        '1234567890',
        '0987654321',
        '1231231231',
        '1234123412',
        '1234512345',
        '1122334455',
        '9988776655',
    ];

    private static $secret = [
        'abcd1234abcd1234abcd',
        '12345abcde12345abcde',
        'abcdefghijklmnouprst',
        '22222aaaaabbbbb11111',
        '1234509876abcdefghij',
        'asdfghjkllkjhgfdsa12',
        'poiuytrewqasdfghjkl0',
    ];

    private static $name = [
        'FloppaApp',
        'SomeApp',
        'ThinkApp',
        'HoApp',
        'ExitApp',
        'TwajterApp',
        'FloppaLiteApp',
    ];

    private static $scopes = [
        'add read update delete',
        'add update',
        'read',
        'add read',
        'add',
        'read',
        '',
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 7; $i++) {
                $client = new MyOAuthClient();
                $client->setIsActive(true);
                $client->setName(self::$name[$i]);
                $client->setScopes(self::$scopes[$i]);
                $client->setIdentifier(self::$identifier[$i]);
                $client->setSecret(self::$secret[$i]);
                $manager->persist($client);
        }
        $manager->flush();
    }
}
