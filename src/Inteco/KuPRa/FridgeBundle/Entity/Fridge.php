<?php

namespace Inteco\KuPRa\FridgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fridge
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inteco\KuPRa\FridgeBundle\Entity\FridgeRepository")
 */
class Fridge
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
     * @ORM\OneToMany(targetEntity="FridgeItem", mappedBy="fridge")
     */
    private $products;

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
     * Set author
     *
     * @param \Inteco\KuPRa\DefaultBundle\Entity\User $author
     * @return Fridge
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

    public function __toString()
    {
        return $this->author->getNickname();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add products
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\FridgeItem $products
     * @return Fridge
     */
    public function addProduct(\Inteco\KuPRa\FridgeBundle\Entity\FridgeItem $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * Remove products
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\FridgeItem $products
     */
    public function removeProduct(\Inteco\KuPRa\FridgeBundle\Entity\FridgeItem $products)
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
}
