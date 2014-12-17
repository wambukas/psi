<?php

namespace Inteco\KuPRa\FridgeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FridgeItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', null, ['label' => 'Kiekis'])
            ->add('product', null, ['label' => 'Produktas'])
            ->add('Įdėti', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inteco\KuPRa\FridgeBundle\Entity\FridgeItem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'inteco_kupra_fridgebundle_fridgeitem';
    }
}
