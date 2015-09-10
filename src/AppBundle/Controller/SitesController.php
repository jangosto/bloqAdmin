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
    public function listUsersAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('admin/users_list.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/create/", name="admin_sites_create")
     */
    public function createUsersAction()
    {
    }

}

