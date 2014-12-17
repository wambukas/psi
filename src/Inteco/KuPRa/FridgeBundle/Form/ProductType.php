<?php

namespace Inteco\KuPRa\FridgeBundle\Form;

use Inteco\KuPRa\DefaultBundle\Form\ImageProductType;
use Inteco\KuPRa\DefaultBundle\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Pavadinimas'])
            ->add('description', null, ['label' => 'Aprašymas'])
            ->add('measurement', null, ['label' => 'Matavimo vienetai'])
            ->add('imageFile', 'file', ['data_class' => 'Symfony\Component\HttpFoundation\File\File', 'label'=>'Nuotrauka'])
            ->add('Sukurti', 'submit');
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inteco\KuPRa\FridgeBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inteco_kupra_fridgebundle_product';
    }
}
