<?php

namespace App\Entity;

use App\Repository\ObserveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObserveRepository::class)
 */
class Observe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id_user;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id_hash;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user): void
    {
        $this->id_user = $id_user;
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
