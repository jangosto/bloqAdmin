<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Form\Type\UserCreationFormType as EditorUserCreationFormType;
use AppBundle\Entity\User as EditorUser;


/**
 * @Route("/admin")
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

    /**
     * @Route("/users/list/", name="admin_users_list")
     */
    public function listUsersAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('admin/usersList.html.twig', array(
             'users' => $users
        ));
    }

    /**
     * @Route("/users/create/", name="admin_users_create")
     */
    public function createUsersAction()
    {
        $roles = $this->getRolesForUser();

        $user = new EditorUser();
        $createUserForm = $this->createForm(
            new EditorUserCreationFormType("AppBundle\\Entity\\User", 
                $roles
            ), 
            $user, 
            array()
        );

        return $this->render('admin/usersCreate.html.twig', array(
            "form" => $createUserForm->createView()
        ));
    }


    private function getRolesForUser()
    {
        $roles = array();
        $tmpRoles = $this->container->getParameter('security.role_hierarchy.roles');
        $formatedRoles = $this->formatRolesForForm($tmpRoles);

        foreach ($formatedRoles as $role) {
            if ($this->get("security.context")->isGranted($role)) {
                $roles[] = $role;
            }
        }

        return $roles;
    }

    private function formatRolesForForm($rolesArray)
    {
        $roles = array();
        foreach ($rolesArray as $roleKey => $inheritedRoles) {
            if (!in_array($roleKey, $roles)) {
                $roles[] = $roleKey;
            }
            foreach ($inheritedRoles as $role) {
                if (!in_array($role, $roles)) {
                    $roles[] = $role;
                }
            }
        }
        return $roles;
    }
}

