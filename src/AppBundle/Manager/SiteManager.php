<?php

namespace AppBundle\Manager;

class SiteManager
{
    protected $dm;
    protected $repository;
    protected $class;

    public function __construct($dm, $class)
    {
        $this->dm = $dm;
        $this->class = $class;
        $this->repository = $dm->getRepository($this->class);
    }

    public function getAllSites()
    {
        $sites = $this->repository
            ->findAll();

        return $sites;
    }
}
