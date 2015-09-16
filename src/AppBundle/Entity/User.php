<?php

// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\ManyToMany(targetEntity="Site", inversedBy="users")
     * @ORM\JoinTable(name="users_sites",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="site_id", referencedColumnName="id")}
     *      )
     */
    protected $sites;

    public function __construct()
    {
        parent::__construct();

        $this->sites = new ArrayCollection();
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
    
    /**
     * Get sites.
     *
     * @return sites.
     */
    public function getSites()
    {
        return $this->sites->toArray();
    }
    
    /**
     * Set sites.
     *
     * @param sites the value to set.
     */
    public function setSites($sites)
    {
        $this->sites = $sites;
    }

    public function addSite(Site $site)
    {
        $site->addUser($this);
        $this->sites[] = $site;
    }
}

