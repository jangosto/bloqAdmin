<?php

namespace AppBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use Symfony\Component\Security\Core\Util\SecureRandom;

class UserCreationFormHandler extends BaseHandler
{
    public function process($confirmation = false)
    {
        $generator = new SecureRandom();
        
        $user = $this->userManager->createUser();
        $this->form->setData($user);

        if ('POST' == $this->request->getMethod()) {
            $this->form->bind($this->request);
            if ($this->form->isValid()) {
                echo "es valido";die;
                return true;
            }
        }

        return false;
    }
}

