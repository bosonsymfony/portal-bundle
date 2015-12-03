<?php

namespace UCI\Boson\PortalBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use UCI\Boson\PortalBundle\Entity\Content;
use UCI\Boson\PortalBundle\Entity\Icon;
use UCI\Boson\PortalBundle\Entity\Image;
use UCI\Boson\PortalBundle\Entity\ImageSet;
use UCI\Boson\PortalBundle\Form\ContentType;
use UCI\Boson\PortalBundle\Form\IconType;
use UCI\Boson\PortalBundle\Form\ImageSetType;
use UCI\Boson\PortalBundle\Form\ImageType;
use UCI\Boson\PortalBundle\Util\Globals;

/**
 * Content controller.
 *
 * @Route("/content")
 */
class ContentController extends Controller
{
    public function serialize($data, $format = 'json')
    {
        $serializer = $this->get('jms_serializer');
        return $serializer->serialize($data, $format);
    }

    /**
     * Return all icons
     *
     * @Route("/icons", name="content_icons", options={"expose"=true})
     * @Method("GET")
     */
    public function getIconsAction()
    {
        $stylesService = $this->get('portal.styles');
        $styles = array(
            'icons' => $stylesService->icons()
        );
        $response = new Response($this->serialize($styles));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Lists all Content entities.
     *
     * @Route("/", name="content", options={"expose"=true})
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entities = $em->getRepository('PortalBundle:Content')->getAll();

        $response = new Response($this->serialize($entities));
        $response->headers->add(array('Access-Control-Allow-Origin' => '*'));
        return $response;
    }

    /**
     * Creates a new Content entity.
     *
     * @Route("/", name="content_create", options={"expose"=true})
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $type = $request->request->get('type');
        $entity = null;
        $form = null;

        switch ($type) {
            case 'icon':
                $entity = new Icon();
                $form = $this->createForm(new IconType(), $entity, array(
                    'action' => $this->generateUrl('content_create'),
                    'method' => 'POST',
                ));
                break;
            case 'image':
                $entity = new Image();
                $form = $this->createForm(new ImageType(), $entity, array(
                    'action' => $this->generateUrl('content_create'),
                    'method' => 'POST',
                ));
                break;
            case 'image-set':
                $entity = new ImageSet();
                $form = $this->createForm(new ImageSetType(), $entity, array(
                    'action' => $this->generateUrl('content_create'),
                    'method' => 'POST',
                ));
                break;
        }
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($entity);
            $em->flush();

            return new Response('The Content was created successfully.');
        }

        return new Response($form->getErrors(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Creates a form to create a Content entity.
     *
     * @param Content $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Content $entity)
    {
        $form = $this->createForm(new ContentType(), $entity, array(
            'action' => $this->generateUrl('content_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Content entity.
     *
     * @Route("/new", name="content_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Content();

        $form = $this->createForm(new ImageSetType(), new ImageSet(), array(
            'action' => $this->generateUrl('content_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Content entity.
     *
     * @Route("/{id}", name="content_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:Content')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
        }

        return new Response($this->serialize($entity));
    }

    /**
     * Displays a form to edit an existing Content entity.
     *
     * @Route("/{id}/edit", name="content_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:Content')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
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
     * Creates a form to edit a Content entity.
     *
     * @param Content $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Content $entity)
    {
        $form = $this->createForm(new ContentType(), $entity, array(
            'action' => $this->generateUrl('content_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Content entity.
     *
     * @Route("/{id}", name="content_update", options={"expose"=true})
     * @Method("PUT")
     * @Template("PortalBundle:Content:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.entity_manager');

        $entity = $em->getRepository('PortalBundle:Content')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Content entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return new Response("The Content with id '$id' was updated successfully.");
        }

        return new Response('You have an error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Deletes a Content entity.
     *
     * @Route("/{id}", name="content_delete", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $entity = $em->getRepository('PortalBundle:Content')->find($id);

        if (!$entity) {
            return new Response('Unable to find Content entity.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $tiles = $em->getRepository('PortalBundle:Content')->getTilesByContent($id);
        foreach ($tiles as $index => $tile) {
            $tile->removeContent($entity);
            $em->persist($tile);
        }
        $em->flush();

        $em->remove($entity);
        $em->flush();

        return new Response("The Content with id '$id' was deleted successfully.");
    }
}
