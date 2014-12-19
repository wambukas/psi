<?php

namespace Inteco\KuPRa\FridgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inteco\KuPRa\FridgeBundle\Entity\MenuRepository")
 */
class Menu
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
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="menu")
     */
    private $menuItem;

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
     * Constructor
     */
    public function __construct()
    {
        $this->recipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add recipes
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\Recipe $recipes
     * @return Menu
     */
    public function addRecipe(\Inteco\KuPRa\FridgeBundle\Entity\Recipe $recipes)
    {
        $this->recipes[] = $recipes;

        return $this;
    }

    /**
     * Remove recipes
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\Recipe $recipes
     */
    public function removeRecipe(\Inteco\KuPRa\FridgeBundle\Entity\Recipe $recipes)
    {
        $this->recipes->removeElement($recipes);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Set author
     *
     * @param \Inteco\KuPRa\DefaultBundle\Entity\User $author
     * @return Menu
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

    /**
     * Add menuItem
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\MenuItem $menuItem
     * @return Menu
     */
    public function addMenuItem(\Inteco\KuPRa\FridgeBundle\Entity\MenuItem $menuItem)
    {
        $this->menuItem[] = $menuItem;

        return $this;
    }

    /**
     * Remove menuItem
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\MenuItem $menuItem
     */
    public function removeMenuItem(\Inteco\KuPRa\FridgeBundle\Entity\MenuItem $menuItem)
    {
        $this->menuItem->removeElement($menuItem);
    }

    /**
     * Get menuItem
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMenuItem()
    {
        return $this->menuItem;
    }
}
