<?php

namespace App\DataFixtures;

use App\Entity\Hashtag;
use App\Entity\HashToPost;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service_locator;

class AppFixtures extends Fixture
{
    // delete from sqlite_sequence where name='your_table';

    private static $hashtags = [
        'IT',
        'NYC',
        'PRz',
        'OPTeam',
        'Comarch',
        'Ideo',
        'PGS',
        'Fabrity',
    ];

    private static $hashtags2 = [
        'Marketing',
        'NewWorld',
        'Carrer',
        'Safe',
        'Keep',
        'Sleep',
        'Lorem',
        'Ipsum',
    ];

    private static $postContent = [
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vulputate ligula eu dolor suscipit iaculis vitae 
        id ipsum. Nam mollis auctor orci, a porttitor dui tempor a. Donec bibendum tellus massa. In porta nunc ut cursus
        condimentum. Sed et malesuada turpis, quis facilisis tellus. Quisque vel neque venenatis, pulvinar velit id, euismod est.',

        'Suspendisse consectetur tortor eu massa viverra blandit. Phasellus in nibh vel sem scelerisque pulvinar ut id diam. 
        Aenean vulputate et eros ut ultrices. Aenean vehicula, elit a tempor pellentesque, tortor mi pellentesque justo, 
        lacinia posuere libero purus sit amet tellus. Suspendisse potenti. Maecenas elementum elit sem, non finibus eros 
        euismod sit amet. Duis dui urna, sollicitudin vitae eleifend vel, rhoncus vulputate diam. Nullam blandit dui eu',

        'enim mattis, ut eleifend velit tincidunt. Praesent vitae tincidunt lectus, eget viverra odio. Nam tempus, justo 
        non interdum congue, magna lorem tempus quam, vel dignissim nulla quam at tortor.Nullam a aliquam turpis, eu 
        vulputate risus. Phasellus ornare, sapien vel pharetra maximus, lacus quam condimentum est, vel fermentum nibh 
        ipsum nec lectus. Proin nec elit nec magna consequat ornare. Duis semper consequat neque, a ornare nibh efficitur in.',

        'Suspendisse potenti. Cras id blandit ipsum. Nunc sodales massa ut vulputate egestas. Proin tincidunt id nunc ac sodales. 
        Duis sit amet nunc sed ex ultricies faucibus a sit amet massa. Proin ac eros at sem varius commodo vehicula sed sem. 
        Nunc iaculis cursus felis et lobortis. Aenean tincidunt tellus in neque varius, et rhoncus mi molestie. Aliquam feugiat, 
        est pretium hendrerit semper, sapien lorem vehicula nibh, in blandit ligula sapien sit amet turpis.',

        'Mauris et tellus sapien. Pellentesque varius felis ac ligula consequat suscipit. Integer lectus ligula, porttitor 
        sit amet purus ut, tristique congue velit. Vivamus venenatis libero quam, consectetur posuere lorem consequat quis. 
        Praesent ipsum est, hendrerit sit amet consectetur sit amet, hendrerit nec orci. Phasellus lacus enim, sagittis at 
        gravida et, finibus semper ante.',

        'In in tincidunt sem. Nulla viverra velit vitae tellus consequat varius. Cras viverra diam nulla, id scelerisque 
        nisl blandit ac. Sed sagittis ligula ut ornare hendrerit. Integer ac dolor velit. Cras at ante neque. 
        Nunc molestie lacus et risus dapibus pretium. Curabitur ante lorem, finibus ac odio ac, malesuada porta libero. 
        Praesent quis dolor ex. Pellentesque facilisis ipsum at magna gravida condimentum. Nulla sit amet mi ullamcorper, 
        mattis dolor id, hendrerit erat.',

        'Proin porta eget purus quis suscipit. Cras tincidunt cursus nunc, sit amet aliquam magna. Sed et maximus lacus. 
        Aliquam nec eleifend lacus. Pellentesque at quam ut nibh interdum ullamcorper quis nec libero. Ut orci libero, 
        euismod et eros eget, gravida fringilla velit. Quisque nec blandit eros, eget hendrerit ipsum. Ut malesuada metus 
        nec vulputate dictum. In venenatis euismod aliquam.',
        'Donec varius magna sed enim egestas, non mollis risus volutpat. Quisque hendrerit dolor vitae lectus semper, 
        at congue felis condimentum. Ut quis purus feugiat, efficitur tortor sed, tincidunt mi. Duis maximus facilisis 
        leo vel fringilla. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae 
        Mauris porttitor fermentum ligula sed varius.',
    ];

    private static $hashToHTP = [
        5,
        6,
        7,
        5,
        6,
        7,
    ];

    private static $postToHTP = [
        1,
        2,
        3,
        4,
        5,
    ];

    private static $observeHash = [
        1,
        2,
        3,
        4,
        1,
        2,
        4,
        3,
    ];

    private static $observeUsers = [
        1,
        1,
        1,
        1,
        2,
        2,
        3,
        3,
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 8; $i++)
        {
            if($i < 7){
                $post = new Post();
                $post->setContent(self::$postContent[$i]);
                $post->setAuthor($i);
                $tmp = self::$hashtags[$i]." ".self::$hashtags2[$i];
                $post->setHashtags($tmp);
                $manager->persist($post);
            }

            /*if($i < 8){
                $observe = new Observe();
                $observe->setIdUser(self::$observeUsers[$i]);
                $observe->setIdHash(self::$observeHash[$i]);
                $manager->persist($observe);
            }*/
        }
        $manager->flush();

        for($i = 0; $i < 3; $i++){
            $hashtag = new Hashtag();
            $hashtag->setName(self::$hashtags[$i]);
            $manager->persist($hashtag);
        }
        $manager->flush();

        for($i = 0; $i < 5; $i++){
            $hashToPost = new HashToPost();
            $hashToPost->setIdHash(self::$hashToHTP[$i]);
            $hashToPost->setIdPost(self::$postToHTP[$i]);
            $manager->persist($hashToPost);
        }
        $manager->flush();
    }
}
