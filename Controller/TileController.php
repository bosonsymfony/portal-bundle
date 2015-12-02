<?php

namespace UCI\Boson\PortalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use UCI\Boson\PortalBundle\Entity\Tile;
use UCI\Boson\PortalBundle\Form\TileType;
use UCI\Boson\PortalBundle\Util\Styles;

/**
 * Tile controller.
 *
 * @Route("/tile")
 */
class TileController extends Controller
{

    public function serialize($data, $format = 'json')
    {
        $serializer = $this->get('jms_serializer');
        return $serializer->serialize($data, $format);
    }

    /**
     * Return all styles
     *
     * @Route("/styles", name="tile_styles", options={"expose"=true})
     * @Method("GET")
     */
    public function getStylesAction()
    {
        $stylesService = $this->get('portal.styles');
        $styles = array(
            'colors' => $stylesService->colors(),
            'sizes' => $stylesService->sizes(),
            'effects' => $stylesService->effects()
        );
        $response = new Response($this->serialize($styles));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Return all funcionalidades
     *
     * @Route("/functions", name="tile_functions", options={"expose"=true})
     * @Method("GET")
     */
    public function getFuncionalidadesAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('PortalBundle:Tile')->getFunctions();

        $response = new Response($this->serialize($entities));
        $response->headers->add(array('Access-Control-Allow-Origin' => '*'));
        return $response;
    }

    /**
     * Lists all Tile entities.
     *
     * @Route("/", name="tile", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('PortalBundle:Tile')->getAll();

        $response = new Response($this->serialize($entities));
        $response->headers->add(array('Access-Control-Allow-Origin' => '*'));
        return $response;
    }

    /**
     * Creates a new Tile entity.
     *
     * @Route("/", name="tile_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity = new Tile();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $oldTile = $em->getRepository('PortalBundle:Tile')->findOneBy(
                array(
                    'funcionalidad' => $entity->getFuncionalidad()
                ));
            if ($oldTile != null) {
                $oldTile->setFuncionalidad(null);
                $em->persist($oldTile);
                $em->flush();
            }
            $em->persist($entity);
            $em->flush();

            return new Response('The Tile was created successfully.');
        }

        return new Response($form->getErrors(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Creates a form to create a Tile entity.
     *
     * @param Tile $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tile $entity)
    {
        $form = $this->createForm(new TileType(), $entity, array(
            'action' => $this->generateUrl('tile_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Tile entity.
     *
     * @Route("/new", name="tile_new", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tile();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tile entity.
     *
     * @Route("/{id}", name="tile_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:Tile')->get($id);

        if (!$entity) {
            return new Response('Unable to find Tile entity.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response($this->serialize($entity));
    }

    /**
     * Displays a form to edit an existing Tile entity.
     *
     * @Route("/{id}/edit", name="tile_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:Tile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tile entity.');
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
     * Creates a form to edit a Tile entity.
     *
     * @param Tile $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Tile $entity)
    {
        $form = $this->createForm(new TileType(), $entity, array(
            'action' => $this->generateUrl('tile_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Tile entity.
     *
     * @Route("/{id}", name="tile_update", options={"expose"=true})
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:Tile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tile entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $oldTile = $em->getRepository('PortalBundle:Tile')->findOneBy(
                array(
                    'funcionalidad' => $entity->getFuncionalidad()
                ));
            if ($oldTile != null) {
                if ($entity->getFuncionalidad() && $entity->getFuncionalidad()->getId() != $oldTile->getFuncionalidad()->getId()) {
                    $oldTile->setFuncionalidad(null);
                    $em->persist($oldTile);
                    $em->flush();
                }
            }
            $em->flush();

            return new Response("The Tile with id '$id' was updated successfully.");
        }

        return new Response('You have an error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Deletes a Tile entity.
     *
     * @Route("/{id}", name="tile_delete", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $entity = $em->getRepository('PortalBundle:Tile')->find($id);

        if (!$entity) {
            return new Response('Unable to find Tile entity.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $em->remove($entity);
        $em->flush();

        return new Response("The Tile with id '$id' was deleted successfully.");
    }
}
