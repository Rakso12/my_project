<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Repository for Post Repository
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    private $manager;
    private $userRepository;

    /**
     * PostRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     * @param UserRepository $userRepository
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, UserRepository $userRepository)
    {
        parent::__construct($registry, Post::class);
        $this->manager = $manager;
        $this->userRepository = $userRepository;
    }

    /**
     * Function which generate new post.
     * @param $content
     * @param $author
     * @param $hashtags
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
     * Function to update post.
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
     * Function to delete post.
     * @param Post $post
     */
    public function removePost(Post $post)
    {
        $this->manager->remove($post);
        $this->manager->flush();
    }

    /**
     * Function to get posts by author.
     * @param $authorId
     * @return Post[]
     */
    public function getPosts($authorId)
    {
        $posts = $this->findBy(array('author' => $authorId));
        return $posts;
    }

    /**
     * Function to get posts by hashtag.
     * @param $hashtag
     * @return array
     */
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

    /**
     * Function to get all post by following users and hashtags.
     * @param $hashtags
     * @param $users
     * @return array
     */
    public function getByFollowingProperties($hashtags, $users)
    {
        $hashtagArray = preg_split("/[\s,]+/", $hashtags);
        $usersArray = preg_split("/[\s,]+/", $users);

        $postsTmp = $this->findAll();
        $posts = [];

        $flag = false;

        foreach ($postsTmp as $post) {

            $postHashArray = preg_split("/[\s,]+/",$post->getHashtags());

            foreach ($hashtagArray as $funcHash){
                foreach ($postHashArray as $postHash){
                    if($funcHash == $postHash && $flag == false){
                        $posts[] = $post;
                        $flag = true;
                    }
                }
            }

            if($flag == false) {
                foreach ($usersArray as $oneUser) {
                    $author = $post->getAuthor();
                    $tmpAuthor = $this->userRepository->findOneBy(['id' => $author]);
                    $authorEmail = $tmpAuthor->getEmail();

                    if ($authorEmail == $oneUser){
                        $posts[] = $post;
                    }
                }
            }
            $flag = false;
        }

        // dodać zczytywanie hashtagów + separacje oraz wysyłanie listy postów spowrotem wykluczając powtórzenia
        return $posts;

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
