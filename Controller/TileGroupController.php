<?php

namespace UCI\Boson\PortalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use UCI\Boson\PortalBundle\Entity\TileGroup;
use UCI\Boson\PortalBundle\Form\TileGroupType;

/**
 * TileGroup controller.
 *
 * @Route("/tilegroup")
 */
class TileGroupController extends Controller
{
    public function serialize($data, $format = 'json')
    {
        $serializer = $this->get('jms_serializer');
        return $serializer->serialize($data, $format);
    }

    /**
     * Lists all TileGroup entities.
     *
     * @Route("/", name="tilegroup", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PortalBundle:TileGroup')->getAll();

        $response = new Response($this->serialize($entities));
        $response->headers->add(array('Access-Control-Allow-Origin' => '*'));
        return $response;
    }

    /**
     * Creates a new TileGroup entity.
     *
     * @Route("/", name="tilegroup_create")
     * @Method("POST")
     * @Template("PortalBundle:TileGroup:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TileGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tilegroup_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TileGroup entity.
     *
     * @param TileGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TileGroup $entity)
    {
        $form = $this->createForm(new TileGroupType(), $entity, array(
            'action' => $this->generateUrl('tilegroup_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TileGroup entity.
     *
     * @Route("/new", name="tilegroup_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TileGroup();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a TileGroup entity.
     *
     * @Route("/{id}", name="tilegroup_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PortalBundle:TileGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TileGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TileGroup entity.
     *
     * @Route("/{id}/edit", name="tilegroup_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PortalBundle:TileGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TileGroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a TileGroup entity.
     *
     * @param TileGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(TileGroup $entity)
    {
        $form = $this->createForm(new TileGroupType(), $entity, array(
            'action' => $this->generateUrl('tilegroup_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing TileGroup entity.
     *
     * @Route("/{id}", name="tilegroup_update")
     * @Method("PUT")
     * @Template("PortalBundle:TileGroup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PortalBundle:TileGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TileGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tilegroup_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a TileGroup entity.
     *
     * @Route("/{id}", name="tilegroup_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PortalBundle:TileGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TileGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tilegroup'));
    }

    /**
     * Creates a form to delete a TileGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tilegroup_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
