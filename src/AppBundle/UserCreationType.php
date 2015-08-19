<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserCreationType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User Class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->('username', null, array('label' => 'form.username', 'translation' => 'FOSUserBundle'))
            ->('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('roles')
            ->add('groups')
            ->add('enabled');
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getUser()
    {
        return 'app_user_creation';
    }
}
