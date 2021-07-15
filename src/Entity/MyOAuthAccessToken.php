<?php

namespace App\Entity;

use App\Repository\MyOAuthAccessTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MyOAuthAccessTokenRepository::class)
 */
class MyOAuthAccessToken
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
    private $client_id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $make_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id;

    /**
     * @ORM\Column(type="array")
     */
    private $scopes = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

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

    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    public function setClientId(?string $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    public function getMakeDate(): ?\DateTimeInterface
    {
        return $this->make_date;
    }

    public function setMakeDate(?\DateTimeInterface $make_date): self
    {
        $this->make_date = $make_date;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getScopes(): ?array
    {
        return $this->scopes;
    }

    public function setScopes(array $scopes): self
    {
        $this->scopes = $scopes;

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
}
