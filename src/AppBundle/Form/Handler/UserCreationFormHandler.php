<?php

namespace AppBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;

class UserCreationFormHandler extends BaseHandler
{
    public function process($confirmation = false)
    {
        $password = substr($this->tokenGenerator->generateToken(), 0, 15);

        $user = $this->createUser();
        $user->setPlainPassword($password);
        $this->form->setData($user);

        if ('POST' === $this->request->getMethod()) {
            $this->form->handleRequest($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($user, $confirmation);

                return true;
            }
        }

        return false;
    }
}

