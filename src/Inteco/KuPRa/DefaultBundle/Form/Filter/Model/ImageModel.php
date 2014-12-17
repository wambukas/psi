<?php

namespace Inteco\KuPRa\DefaultBundle\Form\Filter\Model;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ImageModel {

    /**
     * @Vich\UploadableField(mapping="user_image")
     *
     * @var File $image
     */
    protected $image;

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImage(File $image = null)
    {
        $this->image = $image;
    }
}
