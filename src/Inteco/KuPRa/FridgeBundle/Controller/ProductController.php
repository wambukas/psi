<?php

namespace Inteco\KuPRa\FridgeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Inteco\KuPRa\FridgeBundle\Entity\Product;

/**
 * Product controller.
 *
 * @Route("/dgsdfgfdg")
 */
class ProductController extends Controller
{

    /**
     * Lists all Product entities.
     *
     * @Route("/", name="product")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Product')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IntecoKuPRaFridgeBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
