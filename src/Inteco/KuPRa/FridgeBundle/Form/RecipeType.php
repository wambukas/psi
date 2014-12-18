<?php

namespace Inteco\KuPRa\FridgeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RecipeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('portion')
            ->add('preparation')
            ->add('description')
            ->add('file', 'file', ['multiple' => true, 'data_class' => 'Symfony\Component\HttpFoundation\File\File', 'label' => 'Nuotrauka'])
            ->add('Išsaugoti', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inteco\KuPRa\FridgeBundle\Entity\Recipe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inteco_kupra_fridgebundle_recipe';
    }
}
