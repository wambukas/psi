<?php

namespace Inteco\KuPRa\DefaultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname')
            ->add('name')
            ->add('surname')
            ->add('address', 'hidden')
            ->add('description', 'hidden')
            ->add('role', 'hidden')
            ->add('salt', 'hidden')
            ->add('loginName')
            ->add('password', 'repeated', array(
                'first_name'  => 'password',
                'second_name' => 'repeat',
                'type'        => 'password',)
            )
            ->add('submit', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inteco\KuPRa\DefaultBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inteco_kupra_defaultbundle_user';
    }
}
