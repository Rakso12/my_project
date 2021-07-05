<?php

namespace App\Entity;

use App\Repository\HashToPostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HashToPostRepository::class)
 */
class HashToPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @var
     */
    private $id_post;

    /**
     * @ORM\Column(type="integer")
     * @var
     */
    private $id_hash;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdPost()
    {
        return $this->id_post;
    }

    /**
     * @param mixed $id_post
     */
    public function setIdPost($id_post): void
    {
        $this->id_post = $id_post;
    }

    /**
     * @return mixed
     */
    public function getIdHash()
    {
        return $this->id_hash;
    }

    /**
     * @param mixed $id_hash
     */
    public function setIdHash($id_hash): void
    {
        $this->id_hash = $id_hash;
    }
}
