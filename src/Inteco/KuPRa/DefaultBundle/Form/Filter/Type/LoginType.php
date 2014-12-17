<?php
namespace Inteco\KuPRa\DefaultBundle\Form\Filter\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class BookingRoomListFilterType
 * @package Inteco\KuPRa\DefaultBundle\Form\Filter\Type
 */
class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return FormBuilderInterface|void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
/*            ->add('loginForm','hidden', array('data' => 1))*/
            ->add('loginName', 'text', ['label' => 'Prisijungimo vardas'])
            ->add('password', 'password', ['label' => 'Slaptažodis'])
            ->add('login', 'submit',['label' => 'Prisijungti']);

        return $builder;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inteco\KuPRa\DefaultBundle\Form\Filter\Model\LoginModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'login';
    }
}