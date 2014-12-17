<?php

namespace Inteco\KuPRa\DefaultBundle\EventListener;

use Inteco\KuPRa\DefaultBundle\Entity\Image;
use Inteco\KuPRa\DefaultBundle\EntityRepository\ImageRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ImageListener
 * @package Inteco\KuPRa\DefaultBundle\EventListener
 */
class ImageListener implements EventSubscriberInterface
{
    /**
     * @var int
     */
    protected $imagesPerDir;

    /**
     * @var string
     */
    protected $tempImageDirectory;

    /**
     * @var string
     */
    protected $imageDirectory;

    /**
     * @var string
     */
    protected $imageSourceRootDirectory;

    /**
     * @param $imagesPerDirectory
     * @param $tempImageDirectory
     * @param $imageDirectory
     * @param $imageSourceRootDirectory
     */
    public function __construct(
        $imagesPerDirectory,
        $tempImageDirectory,
        $imageDirectory,
        $imageSourceRootDirectory
    )
    {
        $this->imagesPerDir = $imagesPerDirectory;
        $this->tempImageDirectory = $tempImageDirectory;
        $this->imageDirectory = $imageDirectory;
        $this->imageSourceRootDirectory = $imageSourceRootDirectory;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        /* @var $image Image */
        $image = $args->getEntity();
        if ($image instanceof Image) {

            $file = $this->imageSourceRootDirectory . DIRECTORY_SEPARATOR .
                $this->imageDirectory . DIRECTORY_SEPARATOR . $image->getPath();

            if (file_exists($file)) {
                @unlink($this->imageSourceRootDirectory . DIRECTORY_SEPARATOR .
                    $this->imageDirectory . DIRECTORY_SEPARATOR . $image->getPath());
            }
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var $image Image */
        $image = $args->getEntity();

        /** @var EntityManager $entityManager */
        $entityManager = $args->getEntityManager();

        if ($image instanceof Image) {

            /** @var ImageRepository $repository */
            $repository = $entityManager->getRepository('IntecoKuPRaDefaultBundle:Image');

            $folderName = ceil($repository->getImagesCount() / $this->imagesPerDir);
            $directory = $this->imageSourceRootDirectory . DIRECTORY_SEPARATOR;
            $directory .= $this->imageDirectory .DIRECTORY_SEPARATOR. $folderName;

            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            $finalImagePath = $directory. DIRECTORY_SEPARATOR . $image->getPath();
            $tempImagePath = $this->imageSourceRootDirectory . DIRECTORY_SEPARATOR
                . $this->tempImageDirectory . DIRECTORY_SEPARATOR
                . $image->getPath();

            @rename($tempImagePath, $finalImagePath );

            $image->setPath($folderName . DIRECTORY_SEPARATOR . $image->getPath());
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array();
    }
}