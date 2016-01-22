<?php

namespace ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * [buildForm description]
     *
     * @param  FormBuilderInterface $builder
     * @param  array                $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'string');
    }

    /**
     * [configureOptions description]
     *
     * @param  OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ApiBundle\Entity\User',
            'csrf_protection' => false
        ));
    }

    /**
     * [getName description]
     *
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}
