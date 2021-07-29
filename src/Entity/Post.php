<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity to store data about the users posts.
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getHashtags(): string
    {
        return $this->hashtags;
    }

    /**
     * @param mixed $hashtags
     */
    public function setHashtags($hashtags): void
    {
        $this->hashtags = $hashtags;
    }

    /**
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
