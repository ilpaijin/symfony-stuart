<?php

namespace ApiBundle\Entity\User;

use ApiBundle\Entity\UserInterface;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="username_UNIQUE", columns={"username"})})
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"happy_user" = "ApiBundle\Entity\HappyUser"})
 */
abstract class User implements UserInterface
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    protected $username;

    /**
     * @var bool
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    protected $enabled;

    /**
     * @var string
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    protected $salt;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_of_birth", type="datetime", nullable=true)
     */
    protected $dateOfBirth;

    /**
     * @var string
     * @ORM\Column(name="firstname", type="string", length=64, nullable=true)
     */
    protected $firstname;

    /**
     * @var string
     * @ORM\Column(name="lastname", type="string", length=64, nullable=true)
     */
    protected $lastname;

    /**
     * @var string
     * @ORM\Column(name="username_canonical", type="string", length=255, nullable=true)
     */
    protected $username_canonical;

    /**
     * @var Phone
     * @ORM\OneToMany(targetEntity="ApiBundle\Entity\Phone", mappedBy="user")
     *
     */
    protected $phones;

    public function __construct()
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->enabled = false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function setEnabled($boolean)
    {
        $this->enabled = (Boolean) $boolean;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getUsername();
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Gets the value of username_canonical.
     *
     * @return string
     */
    public function getUsernameCanonical()
    {
        return $this->username_canonical;
    }

    /**
     * Sets the value of username_canonical.
     *
     * @param string $username_canonical the username canonical
     *
     * @return self
     */
    public function setUsernameCanonical($username_canonical)
    {
        $this->username_canonical = $username_canonical;

        return $this;
    }

    /**
     * Gets the value of phones.
     *
     * @return Phone
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Sets the value of phones.
     *
     * @param Phone $phones the phones
     *
     * @return self
     */
    public function setPhones(Phone $phones)
    {
        $this->phones = $phones;

        return $this;
    }
}
