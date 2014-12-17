<?php

namespace Inteco\KuPRa\DefaultBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Inteco\KuPRa\DefaultBundle\Entity\Image;
use Inteco\KuPRa\DefaultBundle\Manager\ImageManager;

/**
 * Class IntecoExtension
 * @package Inteco\CommonBundle\Twig
 */
class IntecoExtension extends \Twig_Extension
{
    /** @var ContainerInterface */
    private $container;

    /** @var \Inteco\KuPRa\DefaultBundle\Manager\ImageManager $imageManager */
    private $imageManager;

    /**
     * @param ContainerInterface $container
     * @param ImageManager       $imageManager
     */
    public function __construct(
        ContainerInterface $container,
        ImageManager $imageManager
    )
    {
        $this->container = $container;
        $this->imageManager = $imageManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            'camelize' => new \Twig_Filter_Method($this, 'camelizeFilter'),
            'imagePath' => new \Twig_Filter_Method($this, 'imagePath'),
        ];
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'photoPrototype'        => new \Twig_Function_Method($this, 'photoPrototype'),
            'mediaPanelPrototype'   => new \Twig_Function_Method($this, 'mediaPanelPrototype'),
        ];
    }

    /**
     * @param Image $image
     * @param       $filter
     * @param bool  $temp
     * @param bool  $absolute
     *
     * @return null
     */
    public function imagePath(Image $image, $filter, $temp = false, $absolute = false)
    {
        if (!$image instanceof Image) {
            return null;
        } else {
            if ($temp) {
                return $this->imageManager->getTempResolvedPath($image->getPath(), $filter, $absolute);
            } else {
                return $this->imageManager->getResolvedPath($image, $filter, $absolute);
            }
        }
    }

    /**
     * @param $imageFormView
     *
     * @return mixed
     */
    public function photoPrototype($imageFormView)
    {
        return $this->container->get('templating')
            ->render('IntecoKuPRaDefaultBundle:Twig:mediaPrototype.html.twig', [
                'imageFormType' => $imageFormView,
            ]);
    }

    /**
     * @param $mediaImages
     *
     * @return mixed
     */
    public function mediaPanelPrototype($mediaImages)
    {
        return $this->container->get('templating')
            ->render('IntecoKuPRaDefaultBundle:Twig:mediaPanelPrototype.html.twig', [
                'mediaImages' => $mediaImages,
            ]);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function camelizeFilter($value)
    {
        if (!is_string($value)) {
            return $value;
        }
        $chunks = explode('_', $value);

        return implode('', array_map(function ($s) {
            if (is_numeric($s)) {
                return false;
            }

            return ucfirst($s);
        }, $chunks));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'inteco_extension';
    }
}