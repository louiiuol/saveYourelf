<?php

namespace Hugo\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // Ajoutez vos champs ici, revoilà notre champ *location* :
        $builder
        ->add('firstname' ,'text', array ('required' => false))
        ->add('lastname','text',array ('required' => false))
        ->add('birth','date', array ('required' => false, 'years' => range(date('Y') -100, date('Y')-3)))
        ->add('phone','text', array ('required' => false))
        ->add('location','text', array ('required' => false))
        ->add('bio','textarea', array ('required' => false))
        ;
    }

    public function getName()
    {
        return 'hugo_user_registration';
    }
}