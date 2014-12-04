<?php

namespace Inteco\KuPRa\FridgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inteco\KuPRa\FridgeBundle\Entity\RecipeItemRepository")
 */
class RecipeItem
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
     * @ORM\ManyToOne(targetEntity="Recipe", cascade={"persist"})
     */
    private $recipe;

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
     * @return RecipeItem
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
     * @return RecipeItem
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
     * Set recipe
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\Recipe $recipe
     * @return RecipeItem
     */
    public function setRecipe(\Inteco\KuPRa\FridgeBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \Inteco\KuPRa\FridgeBundle\Entity\Recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }
}
