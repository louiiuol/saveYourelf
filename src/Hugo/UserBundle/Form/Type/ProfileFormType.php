<?php

namespace Hugo\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        $builder
        ->add('firstname')
        ->add('lastname')
        ->add('birth','date', array ('required' => false, 'years' => range(date('Y') -100, date('Y')-3)))
        ->add('phone')
        ->add('location')
        ->add('bio')
        ;
    }

    public function getName()
    {
        return 'hugo_user_profile';
    }
    
}            