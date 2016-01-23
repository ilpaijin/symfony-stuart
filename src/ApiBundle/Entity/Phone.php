<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiBundle\Entity\User\User;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="phones", uniqueConstraints={@ORM\UniqueConstraint(name="number_UNIQUE", columns={"phoneNumber"})})
 */
class Phone
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var [type]
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=false, unique=true)
     */
    protected $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\User\User", inversedBy="phones")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * Gets the value of user.
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the value of user.
     *
     * @param mixed $user the user
     *
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}

