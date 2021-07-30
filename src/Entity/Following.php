<?php

namespace App\Entity;

use App\Repository\FollowingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity to store data about other users and hashtags followed by the currently logged in user.
 * @ORM\Entity(repositoryClass=FollowingRepository::class)
 */
class Following
{
    /**
     * Simply ID of user following data.
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Email of individual users
     * @ORM\Column(type="string", length=255)
     */
    private $user_email;

    /**
     * Hashtags that are following by the user.
     * @ORM\Column(type="string", length=255)
     */
    private $hashtags;

    /**
     * Other users that are following by the user.
     * @ORM\Column(type="string", length=255)
     */
    private $users;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Return the email of the user whose record this is.
     * @return string|null
     */
    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    /**
     * Give access to change the email of the user whose record this is.
     * ATTENTION: Probably useless and that can produce errors
     * @param string $user_email
     * @return $this
     */
    public function setUserEmail(string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    /**
     * Return the string of hashtags following by user. Hashtags are separated by space.
     * @return string|null
     */
    public function getHashtags(): ?string
    {
        return $this->hashtags;
    }

    /**
     * Give access to change the hashtags string.
     * ATTENTION: Remember about space between hashtags.
     * @param string $hashtags
     * @return $this
     */
    public function setHashtags(string $hashtags): self
    {
        $this->hashtags = $hashtags;

        return $this;
    }

    /**
     * Return the string of users following by user. Users are separated by space.
     * @return string|null
     */
    public function getUsers(): ?string
    {
        return $this->users;
    }

    /**
     * Give access to change the users string.
     * ATTENTION: Remember about space between users.
     * @param string $users
     * @return $this
     */
    public function setUsers(string $users): self
    {
        $this->users = $users;

        return $this;
    }
}
