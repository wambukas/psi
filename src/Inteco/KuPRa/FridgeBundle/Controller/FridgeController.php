<?php

namespace Inteco\KuPRa\FridgeBundle\Controller;

use Doctrine\ORM\EntityManager;
use Inteco\KuPRa\FridgeBundle\Entity\Measurement;
use Inteco\KuPRa\FridgeBundle\Form\MeasurementType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Inteco\KuPRa\FridgeBundle\Entity\Fridge;
use Inteco\KuPRa\FridgeBundle\Form\FridgeType;

/**
 * Fridge controller.
 *
 * @Route("/fridge")
 */
class FridgeController extends Controller
{

    /**
     * Lists all Fridge entities.
     *
     * @Route("/", name="_fridge")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:fridge.html.twig")
     */
    public function fridgeAction()
    {
        return [];
    }

    /**
     * @Route("/measurement", name="_measurement")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:measurement.html.twig")
     */
    public function measurementAction()
    {
        $em = $this->getDoctrine()->getManager();
        $err = '';
        $measurement = new Measurement();
        $form = $this->createForm(new MeasurementType(), $measurement);

        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findAll();
        if ($this->getRequest()->isMethod('POST')) {
            $form->submit($this->getRequest());
            $checkTitle = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findOneBy(array('title'=>$measurement->getTitle()));
            $checkShort = $em->getRepository('IntecoKuPRaFridgeBundle:Measurement')->findOneBy(array('shortTitle'=>$measurement->getShortTitle()));
            if ($form->isValid()) {
                if(empty($checkTitle) && empty($checkShort)){
                $em->persist($measurement);
                $em->flush();
                } else {
                    $err = "Measurement exists";
                }
            }
        }
        return ['form' => $form->createView(), 'entities' => $entities, 'err' => $err];
    }

    /**
     * @Route("/products", name="_products")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:products.html.twig")
     */
    public function productsAction()
    {
        return [];
    }

    /**
     * @Route("/recipe", name="_recipe")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:recipe.html.twig")
     */
    public function recipeAction()
    {
        return [];
    }

    /**
     * @Route("/menu", name="_menu")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:menu.html.twig")
     */
    public function menuAction()
    {
        return [];
    }
}
