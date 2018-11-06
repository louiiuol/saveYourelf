<?php

namespace Hugo\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',           'text')
            ->add('imageobj',           new ImageobjType())
            ->add('categories','entity', array(
                      'class'    => 'HugoPlatformBundle:Category',
                      'property' => 'name',
                      'multiple' => true,
                      'expanded' => true
                ))
            ->add('save',            'submit');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hugo\PlatformBundle\Entity\Object'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hugo_platformbundle_object';
    }
}
