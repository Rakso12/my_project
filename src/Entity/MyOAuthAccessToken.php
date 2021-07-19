<?php

namespace App\Entity;

use App\Repository\MyOAuthAccessTokenRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

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
     * @ORM\Column(type="string", nullable=true)
     */
    private $user_id;

    /**
     * @ORM\Column(type="string")
     */
    private $scopes = "";

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_active;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * @param string|null $identifier
     * @return $this
     */
    public function setIdentifier(?string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    /**
     * @param string|null $client_id
     * @return $this
     */
    public function setClientId(?string $client_id): self
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getMakeDate(): ?\DateTimeInterface
    {
        return $this->make_date;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function setMakeDate(): self
    {
        $date = new DateTime(date('Y-m-d H:i:s'));
        $this->make_date = $date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    /**
     * @param string|null $user_id
     * @return $this
     */
    public function setUserId(?string $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getScopes(): string
    {
        return $this->scopes;
    }

    /**
     * @param string $scopes
     */
    public function setScopes(string $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     * @return $this
     */
    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

        return $this;
    }
}
