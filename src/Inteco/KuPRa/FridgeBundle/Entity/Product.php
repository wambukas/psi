<?php

namespace Inteco\KuPRa\FridgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inteco\KuPRa\FridgeBundle\Entity\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Measurement $measurement
     *
     *  @ORM\ManyToOne(targetEntity="Measurement", cascade={"persist"})
     */
    private $measurement;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File $imageFile
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=255, name="image_name")
     *
     * @var string $imageName
     */
    protected $imageName;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set measurement
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\Measurement $measurement
     * @return Product
     */
    public function setMeasurement(\Inteco\KuPRa\FridgeBundle\Entity\Measurement $measurement = null)
    {
        $this->measurement = $measurement;

        return $this;
    }

    /**
     * Get measurement
     *
     * @return \Inteco\KuPRa\FridgeBundle\Entity\Measurement 
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }

    public function __toString()
    {
        return $this->title . ' (' . $this->measurement->getTitle() .') ';
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getImageFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getImageFile()->move(
            '/home/wambo/Projects/psi/src/Inteco/KuPRa/FridgeBundle/Resources/public/images',
            $this->getImageFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file

        $this->path = 'bundles/intecokuprafridge/images/'.$this->getImageFile()->getClientOriginalName();
        $this->imageName = $this->getImageFile()->getFilename();
        // clean up the file property as you won't need it anymore
        $this->imageFile = null;
    }
}
