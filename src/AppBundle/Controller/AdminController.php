<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Bloq\Common\EntitiesBundle\Entity\User as AdminUser;

use AppBundle\Form\Type\UserCreationFormType as AdminUserCreationFormType;

/**
 * @Route("/")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/home.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}

