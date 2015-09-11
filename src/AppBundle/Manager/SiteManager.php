<?php

namespace AppBundle\Manager;

class SiteManager
{
    protected $em;
    protected $repository;
    protected $class;

    public function __construct($em, $class)
    {
        $this->em = $em;
        $this->class = $class;
        $this->repository = $em->getRepository($this->class);
    }

    public function getAll()
    {
        $sites = $this->repository
            ->findAll();

        if (null === $sites) {
            $sites = array();
        }

        return $sites;
    }

    public function getBySlug($slug)
    {
        $site = $this->repository
            ->findBy(
                array("slug" => $slug)
            );

        if (null === $sites) {
            $site = null;
        }

        return $site;
    }

    public function save($object)
    {
        $this->em->persist($object);
        $this->em->flush();

        return $object->getId();
    }

    public function disableById($id)
    {
        $site = $this->repository
            ->find($id);

        $site->setEnabled(false);

        $this->save($site);
    }
}

