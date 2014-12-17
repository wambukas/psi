<?php

namespace Inteco\KuPRa\DefaultBundle\Manager;

use Avalanche\Bundle\ImagineBundle\Imagine\CachePathResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Inteco\KuPRa\DefaultBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\LegacyValidator;
use Doctrine\ORM\EntityManager;

/**
 * Class ImageManager
 * @package Inteco\KuPRa\DefaultBundle\Manager
 */
class ImageManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var LegacyValidator
     */
    private $validator;

    /**
     * @var string
     */
    private $tempImageDirectory;

    /**
     * @var string
     */
    protected $imageDirectory;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var CachePathResolver
     */
    protected $resolver;

    /**
     * @param LegacyValidator $validator
     * @param $tempImageDirectory
     * @param $imageDirectory
     * @param TranslatorInterface $translator
     * @param CachePathResolver $resolver
     * @param EntityManager $entityManager
     */
    public function __construct(
        LegacyValidator $validator,
        $tempImageDirectory,
        $imageDirectory,
        TranslatorInterface $translator,
        CachePathResolver $resolver,
        EntityManager $entityManager
    )
    {
        $this->validator = $validator;
        $this->tempImageDirectory = $tempImageDirectory;
        $this->imageDirectory = $imageDirectory;
        $this->translator = $translator;
        $this->resolver = $resolver;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Image $image
     */
    public function register(Image $image)
    {
        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }

    /**
     * @param Request $request
     * @param $filter
     * @return array
     */
    public function prepare(Request $request, $filter)
    {
        if ($request->files->get('files')) {

            foreach($request->files->get('files') as $uploadImage) {

                $image = new Image();
                $image->setFile($uploadImage);

                /** @var ConstraintViolationList $violations */
                $violations = $this->validator->validate($image, ['OnlyFile']);

                if ($violations->count() <= 0) {

                    $this->preUpload($image);

                    $data = [
                        'path' => $image->getPath(),
                        'originalPath' => $image->getOriginalPath(),
                        'originalName' => $image->getOriginalName(),
                        'thumbnails' => []
                    ];

                    $filters = explode(",", $filter);

                    if (count($filters)) {
                        foreach ($filters as $thumbnailFilter) {

                            $data['thumbnails'][$thumbnailFilter] = $this->getTempResolvedPath($image->getPath(), $thumbnailFilter);

                            if (!isset($data['thumbnail'])) {
                                $data['thumbnail'] = $data['thumbnails'][$thumbnailFilter];
                            }
                        }
                    }

                    return $data;

                } else {

                    $result = ['violations' => []];

                    /* @var $violation \Symfony\Component\Validator\ConstraintViolation */
                    foreach ($violations as $violation) {
                        $result['violations'][] = $violation->getMessage();
                    }

                    return $result;
                }
            }
        }

        return [
            'violations' => [
                $this->translator->trans('file_size_must_be_smaller', [], 'validators')
            ]
        ];
    }

    /**
     * @param Image $image
     * @param $filter
     * @param bool $absolute
     * @return mixed|string
     */
    public function getResolvedPath(Image $image, $filter, $absolute = false)
    {
        return $this->getBrowserPath("{$this->imageDirectory}/{$image->getPath()}", $filter, $absolute);
    }

    /**
     * @param $imagePath
     * @param $filter
     * @param bool $absolute
     * @return mixed|string
     */
    public function getTempResolvedPath($imagePath, $filter, $absolute = false)
    {
        return  $this->getBrowserPath(
            $this->tempImageDirectory . DIRECTORY_SEPARATOR . $imagePath,
            $filter,
            $absolute
        );
    }

    /**
     * @param $path
     * @param $filter
     * @param bool $absolute
     * @return mixed|string
     */
    public function getBrowserPath($path, $filter, $absolute = false)
    {
        return $this->resolver->getBrowserPath($path, $filter, $absolute);
    }

    /**
     * @param Image $image
     */
    public function preUpload(Image $image)
    {
        $uploadedFile = $image->getFile();

        $extension = $uploadedFile->guessExtension();

        $imageName = sha1(uniqid(mt_rand(), true));
        $image->setPath($imageName.'.'.$extension);

        $image->setOriginalName($uploadedFile->getClientOriginalName());

        $uploadedFile->move($this->tempImageDirectory, $image->getPath());

        $image->setFile(null);
    }
}