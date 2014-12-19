<?php

namespace Inteco\KuPRa\FridgeBundle\Twig;

use Doctrine\ORM\EntityManager;

class ProductExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('product_search', array($this, 'productSearch')),
            new \Twig_SimpleFilter('recipe_search', array($this, 'recipeSearch')),
            new \Twig_SimpleFilter('product_name', array($this, 'productName')),
        );
    }

    /**
     * @param EntityManager $manager
     */
    public function __construct(
        EntityManager $manager
    )
    {
        $this->manager = $manager;
    }

    public function productSearch($tyngiu, $id, $fridgeId)
    {
        $em = $this->manager;
        $product = $em->getRepository('IntecoKuPRaFridgeBundle:FridgeItem')->findOneBy(['fridge' => $fridgeId, 'product' => $id]);
        if(!empty($product)){
            return $product->getAmount();
        } else {
            return 0;
        }
    }

    public function recipeSearch($tyngiu, $recipe, $fridge)
    {
        $em = $this->manager;
        $recipe = $em->getRepository('IntecoKuPRaFridgeBundle:Recipe')->findOneBy(['id' => $recipe]);
        $fridge = $em->getRepository('IntecoKuPRaFridgeBundle:Fridge')->findOneBy(['id' => $fridge]);
        $able = 1;
        foreach($recipe->getProducts() as $item){
            $product = $em->getRepository('IntecoKuPRaFridgeBundle:FridgeItem')->findOneBy(['fridge' => $fridge, 'product' => $item->getProduct()]);
            if(empty($product) || ($product->getAmount() < $item->getAmount())){
                $able = 0;
            }
        }
        return $able;
    }

    public function productName($tyngiu, $id)
    {
        $em = $this->manager;
        $product = $em->getRepository('IntecoKuPRaFridgeBundle:Product')->findOneBy(['id' => $id]);
        return $product;
    }

    public function getName()
    {
        return 'product_extension';
    }
}