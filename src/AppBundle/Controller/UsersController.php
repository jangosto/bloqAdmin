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
 * @Route("/users")
 */
class UsersController extends Controller
{
    /**
     * @Route("/list/", name="admin_users_list")
     */
    public function listUsersAction()
    {
        $userManager = $this->container->get('entities.user.manager');
        $users = $userManager->findUsers();
        
        return $this->render('admin/users_list.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/create/", name="admin_users_create")
     */
    public function createUsersAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process !== false) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $route = 'fos_user_registration_check_email';
            } else {
                $authUser = true;
                $route = 'fos_user_registration_confirmed';

                $message = \Swift_Message::newInstance()
                    ->setSubject('Datos de Cuenta de Colaborador')
                    ->setFrom('noreplay@fanatic.futbol')
                    ->setTo($user->getEmailCanonical())
                    ->setBody(
                        $this->renderView(
                            "email/user_creation.email.twig",
                            array(
                                "user" => $user,
                                "pass" => $process,
                            ),
                            "text/html"
                        )
                    );
                $this->get('mailer')->send($message);
            }

//            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

/*            if ($authUser) {
                $this->authentificateUser($user, $response);
            }*/

            return $response;
        }

        return $this->render('admin/users_create.html.twig', array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{id}/", name="admin_users_edition")
     */
    public function editAction($id)
    {
        $userManager = $this->container->get('entities.user.manager');
        $user = $userManager->findUserBy(array('id' => $id));

        $form = $this->container->get('fos_user.profile.form');
        $formHandler = $this->container->get('fos_user.profile.form.handler');

        $process = $formHandler->process($user);
        if ($process) {
            $route = 'admin_users_list';
            $url = $this->container->get('router')->generate($route);
            $response = new RedirectResponse($url);

            return $response;
        }

        return $this->container->get('templating')->renderResponse(
            'admin/users_create.html.twig',
            array(
                'form' => $form->createView(),
                'user' => $user
            )
        );
    }
}
