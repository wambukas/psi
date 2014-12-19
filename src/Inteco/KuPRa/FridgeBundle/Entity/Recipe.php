<?php

namespace Inteco\KuPRa\FridgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Recipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inteco\KuPRa\FridgeBundle\Entity\RecipeRepository")
 */
class Recipe
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
     * @ORM\ManyToOne(targetEntity="\Inteco\KuPRa\DefaultBundle\Entity\User")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="Portion", type="integer", nullable=true)
     */
    private $portion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Preparation", type="integer", nullable=true)
     */
    private $preparation;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @Vich\UploadableField(mapping="recipe_image")
     *
     * @var File $image
     */
    protected $image;

    /**
     * @ORM\OneToMany(targetEntity="RecipeItem", mappedBy="recipe")
     */
    private $products;

    /**
     * @var array
     *
     * @ORM\Column(name="Paths", type="array")
     */
    private $paths;

    /**
     * @var boolean
     *
     * @ORM\Column(name="private", type="boolean", nullable=true)
     */
    private $private;
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
     * @return Recipe
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
     * Set portion
     *
     * @param integer $portion
     * @return Recipe
     */
    public function setPortion($portion)
    {
        $this->portion = $portion;

        return $this;
    }

    /**
     * Get portion
     *
     * @return integer 
     */
    public function getPortion()
    {
        return $this->portion;
    }

    /**
     * Set preparation
     *
     * @param Integer $preparation
     * @return Recipe
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation
     *
     * @return Integer
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Recipe
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
     * Set author
     *
     * @param \Inteco\KuPRa\DefaultBundle\Entity\User $author
     * @return Recipe
     */
    public function setAuthor(\Inteco\KuPRa\DefaultBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Inteco\KuPRa\DefaultBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    public function __construct()
    {
        $this->paths = [];
    }

    /**
     * Set paths
     *
     * @param array $paths
     * @return Recipe
     */
    public function setPaths($paths)
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * Get paths
     *
     * @return array 
     */
    public function getPaths()
    {
        return $this->paths;
    }

    /**
     * @param string $path
     * @return Recipe
     */
    public function addPaths($path)
    {
        $this->paths[] = $path;
        return $this->paths;
    }

    public function getFile()
    {
        return $this->image;
    }

    /**
     * @param array $image
     */
    public function setFile(array $image = null)
    {
        $this->image = $image;
    }

    /**
     * Add products
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\RecipeItem $products
     * @return Recipe
     */
    public function addProduct(\Inteco\KuPRa\FridgeBundle\Entity\RecipeItem $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\RecipeItem $products
     */
    public function removeProduct(\Inteco\KuPRa\FridgeBundle\Entity\RecipeItem $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * Set private
     *
     * @param boolean $private
     * @return Recipe
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean 
     */
    public function getPrivate()
    {
        return $this->private;
    }
}
