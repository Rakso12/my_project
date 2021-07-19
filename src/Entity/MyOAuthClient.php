<?php

namespace App\Entity;

use App\Repository\MyOAuthClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MyOAuthClientRepository::class)
 */
class MyOAuthClient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $identifier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secret;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grants = "";

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $scopes = "";

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    public function setSecret(?string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrants()
    {
        return $this->grants;
    }

    /**
     * @param mixed $grants
     */
    public function setGrants($grants): void
    {
        $this->grants = $grants;
    }

    /**
     * @return mixed
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param mixed $scopes
     */
    public function setScopes($scopes): void
    {
        $this->scopes = $scopes;
    }


}
