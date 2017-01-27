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
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('PortalBundle:TileGroup')->getAll();

        $response = new Response($this->serialize($entities));
        $response->headers->add(array('Access-Control-Allow-Origin' => '*'));
        return $response;
    }

    /**
     * Adicionar grupo de accesos directos
     * Responde al RF 111
     *
     * @Route("/", name="tilegroup_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new TileGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($entity);
            $em->flush();

            return new Response('El grupo de accesos directos fue creado satisfactoriamente.');
        }

        return new Response($form->getErrors(), Response::HTTP_INTERNAL_SERVER_ERROR);
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

        return $form;
    }

    /**
     * Displays a form to create a new TileGroup entity.
     *
     * @Route("/new", name="tilegroup_new", options={"expose"=true})
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
     * @Route("/{id}", name="tilegroup_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:TileGroup')->get($id);

        if (!$entity) {
            return new Response('Unable to find Tile entity.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response($this->serialize($entity));

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
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:TileGroup')->get($id);

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
     * Modificar grupo de accesos directos
     * Responde al RF 112
     *
     * @Route("/{id}", name="tilegroup_update", options={"expose"=true})
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:TileGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TileGroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return new Response("El grupo de accesos directos con id '$id' fue modificado satisfactoriamente.");
        }

        return new Response('You have an error', Response::HTTP_INTERNAL_SERVER_ERROR);

    }

    /**
     * Eliminar grupo de accesos directos
     * Responde al RF 113
     *
     * @Route("/{id}", name="tilegroup_delete", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $entity = $em->getRepository('PortalBundle:TileGroup')->find($id);

        if (!$entity) {
            return new Response('Unable to find TileGroup entity.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $em->remove($entity);
        $em->flush();

        return new Response("El grupo de accesos directos con id '$id' fue eliminado satisfactoriamente.");
    }
}
