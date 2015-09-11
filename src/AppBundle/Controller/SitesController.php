<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Form\Type\UserCreationFormType as AdminUserCreationFormType;
use AppBundle\Entity\Site as AdminSite;

/**
 * @Route("/sites")
 */
class SitesController extends Controller
{
    /**
     * @Route("/list/", name="admin_sites_list")
     */
    public function listSitesAction()
    {
        $siteManager = $this->container->get('admin.manager.site');
        $sites = $siteManager->getAll();

        return $this->render('admin/sites_list.html.twig', array(
            'sites' => $sites
        ));
    }

    /**
     * @Route("/create/", name="admin_sites_create")
     */
    public function createSitesAction(Request $request)
    {
        $site = new AdminSite();
        $site->setEnabled(false);
        $form = $this->createForm('admin_site_creation', $site);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $site = $form->getData();

            $siteManager = $this->container->get('admin.manager.site');
            $siteManager->save($site);

            $route = "admin_sites_list";
            
            $url = $this->container->get('router')->generate($route);

            $response = new RedirectResponse($url);
            return $response;
        }

        return $this->render('admin/sites_create.html.twig', array(
            "form" => $form->createView()
        ));
    }

}

