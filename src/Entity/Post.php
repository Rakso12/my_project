<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity to store data about the user's posts.
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * Id of post.
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Content of post.
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * Author of post.
     * @ORM\Column(type="integer")
     */
    private $author;

    /**
     * String with hashtags.
     * @ORM\Column(type="string")
     */
    private $hashtags = '';


    /**
     * Return id of post.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Return all content of post.
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Give access to change post content.
     * ATTENTION: Post content is string with white sign like space, tab etc..
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * Return author of post.
     * ATTENTION: author is integer ID not email.
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Give access to change author of post ID.
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * Return hashtags string.
     * @return string
     */
    public function getHashtags(): string
    {
        return $this->hashtags;
    }

    /**
     * Give access to change hashtag string.
     * ATTENTION: Remember about space between hashtags.
     * @param mixed $hashtags
     */
    public function setHashtags($hashtags): void
    {
        $this->hashtags = $hashtags;
    }

    /**
     * Return all info about all posts.
     * NOTICE: It is not used now.
     * @return array
     */
    public function toArray(): array
    {
        return
        [
            'id' => $this->getId(),
            'content' => $this->getContent(),
            'author' => $this->getAuthor(),
            'hashtags' => $this->getHashtags()
        ];
    }
}
