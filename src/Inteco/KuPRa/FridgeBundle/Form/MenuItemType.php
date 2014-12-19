<?php

namespace Inteco\KuPRa\FridgeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('portions', null, ['label' => 'Porcijos'])
            ->add('date', null, ['label' => 'Data'])
            ->add('submit', 'submit', ['label' => 'Išsaugoti'])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inteco\KuPRa\FridgeBundle\Entity\MenuItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inteco_kupra_fridgebundle_menuitem';
    }
}
