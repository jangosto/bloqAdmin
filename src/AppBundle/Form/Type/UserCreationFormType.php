<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

class UserCreationFormType extends AbstractType
{
    private $class;
    private $roles;
    private $sites;
    private $securityContext;

    /**
     * @param string $class The User class name
     */
    public function __construct($class, $roles, $securityContext, $sitesManager)
    {
        $this->class = $class;
        $this->securityContext = $securityContext;
        $this->roles = $this->getRolesForUser($roles);

        $sites = $sitesManager->getAll();
        $sitesArray = array("names" => array(), "ids" => array());
        foreach ($sites as $site) {
            $sitesArray['names'][] = $site->getName();
            $sitesArray['ids'][] = $site->getId();
        }
        $this->sites = $sitesArray;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array(
                'label' => 'form.username',
                'translation_domain' => 'FOSUserBundle',
                'required' => true
            ))
            ->add('email', 'email', array(
                'label' => 'form.email',
                'translation_domain' => 'FOSUserBundle',
                'required' => true
            ))
            ->add('firstName', null, array(
                'label' => 'form.firstName',
                'translation_domain' => 'FOSUserBundle'
            ))
            ->add('lastName', null, array(
                'label' => 'form.lastName',
                'translation_domain' => 'FOSUserBundle'
            ))
            ->add('sites', 'choice', array(
                'required' => true,
                'multiple' => true,
                'expanded' => false,
                'choice_list' => new ChoiceList(
                    $this->sites['ids'],
                    $this->sites['names']
                )
            ))
            ->add('roles', 'choice', array(
                'required' => true,
                'multiple' => true,
                'expanded' => false,
                'choice_list' => new ChoiceList(
                    $this->roles,
                    $this->roles
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'creation',
        ));
    }

    public function getName()
    {
        return 'app_user_creation';
    }
    
    /**
     * Get roles.
     *
     * @return roles.
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    /**
     * Set roles.
     *
     * @param roles the value to set.
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Get sites.
     *
     * return sites.
     */
    public function getSites()
    {
        return $this->sites;
    }

    /**
     * Set sites.
     *
     * @param sites the value to set.
     */
    public function setSites($sites)
    {
        $this->sites = $sites;
    }

    private function getRolesForUser($tmpRoles)
    {
        $roles = array();
        $formatedRoles = $this->formatRolesForForm($tmpRoles);

        foreach ($formatedRoles as $role) {
            if ($this->securityContext->isGranted($role) && $role !== "ROLE_USER") {
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
