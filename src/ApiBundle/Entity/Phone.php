<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiBundle\Entity\User\User;

/**
 * @Entity
 */
class Phone extends User
{
    /**
     * @ManyToOne(targetEntity="User", inversedBy="phones")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
}

