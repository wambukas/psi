<?php

namespace Inteco\KuPRa\FridgeBundle\Controller;

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
     * @Route("/", name="fridge")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IntecoKuPRaFridgeBundle:Fridge')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Fridge entity.
     *
     * @Route("/", name="fridge_create")
     * @Method("POST")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Fridge();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('fridge_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Fridge entity.
     *
     * @param Fridge $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Fridge $entity)
    {
        $form = $this->createForm(new FridgeType(), $entity, array(
            'action' => $this->generateUrl('fridge_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Fridge entity.
     *
     * @Route("/new", name="fridge_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Fridge();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Fridge entity.
     *
     * @Route("/{id}", name="fridge_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IntecoKuPRaFridgeBundle:Fridge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fridge entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Fridge entity.
     *
     * @Route("/{id}/edit", name="fridge_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IntecoKuPRaFridgeBundle:Fridge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fridge entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Fridge entity.
    *
    * @param Fridge $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Fridge $entity)
    {
        $form = $this->createForm(new FridgeType(), $entity, array(
            'action' => $this->generateUrl('fridge_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Fridge entity.
     *
     * @Route("/{id}", name="fridge_update")
     * @Method("PUT")
     * @Template("IntecoKuPRaFridgeBundle:Fridge:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IntecoKuPRaFridgeBundle:Fridge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Fridge entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('fridge_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Fridge entity.
     *
     * @Route("/{id}", name="fridge_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IntecoKuPRaFridgeBundle:Fridge')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Fridge entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('fridge'));
    }

    /**
     * Creates a form to delete a Fridge entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fridge_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
