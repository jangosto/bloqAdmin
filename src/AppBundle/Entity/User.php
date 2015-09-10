<?php

// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $lastName;

    /**
     * @ORM\ManyToMany(targetEntity="Site")
     */
    protected $sites;

    public function __construct()
    {
        parent::__construct();

        $this->sites = array();
    }
    
    /**
     * Get firstName.
     *
     * @return firstName.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * Set firstName.
     *
     * @param firstName the value to set.
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    
    /**
     * Get lastName.
     *
     * @return lastName.
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * Set lastName.
     *
     * @param lastName the value to set.
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
}

