<?php
namespace Inteco\KuPRa\DefaultBundle\Form\Filter\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class BookingRoomListFilterType
 * @package Inteco\KuPRa\DefaultBundle\Form\Filter\Type
 */
class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return FormBuilderInterface|void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', 'file', ['data_class' => 'Symfony\Component\HttpFoundation\File\File', 'label' => 'Nuotrauka'])
            ->add('submit', 'submit', ['label' => 'Pateikti']);

        return $builder;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Inteco\KuPRa\DefaultBundle\Form\Filter\Model\ImageModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'image_profile';
    }
}