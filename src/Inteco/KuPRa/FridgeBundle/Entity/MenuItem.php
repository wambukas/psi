<?php

namespace Inteco\KuPRa\FridgeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MenuItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Inteco\KuPRa\FridgeBundle\Entity\MenuItemRepository")
 */
class MenuItem
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
     * @ORM\Column(name="portions", type="integer")
     */
    private $portions;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Menu")
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe")
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
     * Set portions
     *
     * @param integer $portions
     * @return MenuItem
     */
    public function setPortions($portions)
    {
        $this->portions = $portions;

        return $this;
    }

    /**
     * Get portions
     *
     * @return integer 
     */
    public function getPortions()
    {
        return $this->portions;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return MenuItem
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set menu
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\Menu $menu
     * @return MenuItem
     */
    public function setMenu(\Inteco\KuPRa\FridgeBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Inteco\KuPRa\FridgeBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set recipe
     *
     * @param \Inteco\KuPRa\FridgeBundle\Entity\Recipe $recipe
     * @return MenuItem
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
