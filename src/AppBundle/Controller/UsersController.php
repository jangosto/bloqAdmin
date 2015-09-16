<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Form\Type\UserCreationFormType as AdminUserCreationFormType;
use AppBundle\Entity\User as AdminUser;

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
        $userManager = $this->container->get('fos_user.user_manager');
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
        //$roles = $this->getRolesForUser();
        //$form->setRoles($roles);
        //ladybug_dump($form);die;

        return $this->render('admin/users_create.html.twig', array(
            "form" => $form->createView()
        ));
    }
}

