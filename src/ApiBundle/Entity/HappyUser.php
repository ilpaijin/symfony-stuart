<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiBundle\Entity\User\User;

/**
 * @ORM\Entity(repositoryClass="HappyUserRepository")
 */
class HappyUser extends User
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     */
    protected $id;
}
