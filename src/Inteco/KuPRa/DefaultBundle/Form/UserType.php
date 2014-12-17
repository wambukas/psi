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
            ->add('nickname', null, ['label' => 'Slapyvardis'])
            ->add('name', null, ['label' => 'Vardas'])
            ->add('surname', null, ['label' => 'Pavardė'])
            ->add('address', 'hidden')
            ->add('description', 'hidden')
            ->add('role', 'hidden')
            ->add('salt', 'hidden')
            ->add('loginName', null, ['label' => 'Prisijungimo vardas'])
            ->add('password', 'repeated', array(
                'first_name'  => 'Slaptazodis',
                'second_name' => 'Pakartoti',
                'type'        => 'password',)
            )
            ->add('submit', 'submit', ['label' => 'Pateikti'])
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
