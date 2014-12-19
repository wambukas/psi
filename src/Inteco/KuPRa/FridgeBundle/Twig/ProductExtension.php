<?php

namespace Inteco\KuPRa\FridgeBundle\Twig;

use Doctrine\ORM\EntityManager;

class ProductExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('product_search', array($this, 'productSearch')),
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

    public function getName()
    {
        return 'product_extension';
    }
}