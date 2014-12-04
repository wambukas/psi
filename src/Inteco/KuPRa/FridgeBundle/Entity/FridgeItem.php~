<?php

namespace Inteco\KuPRa\FridgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FridgeItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inteco\KuPRa\FridgeBundle\Entity\FridgeItemRepository")
 */
class FridgeItem
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
     * @var integer
     *
     * @ORM\Column(name="Amount", type="integer")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Product", cascade={"persist"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Fridge", cascade={"persist"})
     */
    private $fridge;

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
     * Set amount
     *
     * @param integer $amount
     * @return FridgeItem
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set product
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\Product $product
     * @return FridgeItem
     */
    public function setProduct(\Inteco\KuPRa\FridgeBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Inteco\KuPRa\FridgeBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set fridge
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\Fridge $fridge
     * @return FridgeItem
     */
    public function setFridge(\Inteco\KuPRa\FridgeBundle\Entity\Fridge $fridge = null)
    {
        $this->fridge = $fridge;

        return $this;
    }

    /**
     * Get fridge
     *
     * @return \Inteco\KuPRa\FridgeBundle\Entity\Fridge 
     */
    public function getFridge()
    {
        return $this->fridge;
    }
}
