<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * PostRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Post::class);
        $this->manager = $manager;
    }

    /**
     * @param $content
     * @param $author
     */
    public function savePost($content, $author, $hashtags)
    {
        $newPost = new Post();
        $newPost->setContent($content);
        $newPost->setAuthor($author);
        $newPost->setHashtags($hashtags);

        $this->manager->persist($newPost);
        $this->manager->flush();
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function updatePost(Post $post): Post
    {
        $this->manager->persist($post);
        $this->manager->flush();

        return $post;
    }

    /**
     * @param Post $post
     */
    public function removePost(Post $post)
    {
        $this->manager->remove($post);
        $this->manager->flush();
    }

    public function getPosts($authorId)
    {
        $posts = $this->findBy(array('author' => $authorId));
        return $posts;
    }

    public function getPostByHash($hashtag){

        $allPosts = $this->findAll();

        $tmp = [];
        $i = 0;

        foreach ($allPosts as $post)
        {
            $temp = $post->getHashtags();
            $hashtagArray = preg_split("/[\s,]+/", $temp);

            foreach ($hashtagArray as $hash){
                if($hash == $hashtag){
                    $tmp[] = $post;
                    break;
                }
            }
        }

        return $tmp;
    }

    public function getByFollowingPorperties($hashtags, $users)
    {
        // dodać zczytywanie hashtagów + separacje oraz wysyłanie listy postów spowrotem wykluczając powtórzenia
        return true;
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
