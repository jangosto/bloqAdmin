<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="site")
 */
class Site
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
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $slug;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $domain;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $enabled;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="sites")
     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return id.
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set id.
     *
     * @param id the value to set.
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Get name.
     *
     * @return name.
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set name.
     *
     * @param name the value to set.
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get slug.
     *
     * @return slug.
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set slug.
     *
     * @param slug the value to set.
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
    
    /**
     * Get domain.
     *
     * @return domain.
     */
    public function getDomain()
    {
        return $this->domain;
    }
    
    /**
     * Set domain.
     *
     * @param domain the value to set.
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }
    
    /**
     * Get enabled.
     *
     * @return enabled.
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    /**
     * Set enabled.
     *
     * @param enabled the value to set.
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
    
    /**
     * Get users.
     *
     * @return users.
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    /**
     * Set users.
     *
     * @param users the value to set.
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    public function addUser(User $user)
    {
        $this->users[] = $user;
    }
}

