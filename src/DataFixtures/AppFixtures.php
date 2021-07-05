<?php

namespace App\DataFixtures;

use App\Entity\Hashtag;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    protected $fk;

    private static $hashtags = [
        'IT',
        'NYC',
        'PRz',
        'OPTeam'
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

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i < 12; $i++)
        {
            $user = new User();
            $user->setEmail('simon'.$i.'@xyz.com');

            $user->setFirstName('sim'.$i);
            $user->setLastName('MCDonald'.$i);
            $user->setPassword(rand(1,100) * $i * rand(10,40));
            $new_date = date( "Y-m-d", strtotime( "2009-01-31 +".$i." month" ) );

            $user->setBirthDate($new_date);

            $manager->persist($user);

            if($i < 7){
                $post = new Post();
                $post->setContent(self::$postContent[$i]);
                $post->setAuthor($i);
                $manager->persist($post);
            }
        }
        $manager->flush();

        for($i = 0; $i < 3; $i++){
            $hashtag = new Hashtag();
            $hashtag->setName(self::$hashtags[$i]);
            $manager->persist($hashtag);
        }
        $manager->flush();
    }
}
