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
            ->add('id', 'hidden')
            ->add('title', null, ['label' =>'Pavadinimas'])
            ->add('portion', null, ['label' =>'Porcijų skaičius'])
            ->add('preparation', null, ['label' =>'Paruošimo trukme (min.)'])
            ->add('description', null, ['label' =>'Aprašymas'])
            ->add('file', 'file', ['multiple' => true, 'data_class' => 'Symfony\Component\HttpFoundation\File\File', 'label' => 'Nuotrauka/os'])
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
