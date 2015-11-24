<?php

namespace UCI\Boson\PortalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PortalBundle:Default:index.html.twig', array(
            'background' => $this->getBackground(),
            'linea' => $this->getLinea()
        ));
    }

    public function adminAction()
    {
        return $this->render('PortalBundle:Default:admin.html.twig');
    }

    public function getTilesAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $funcionalidades = $this->get('boson.manager.funcionalidades')->obtenerFuncionalidadesUsuarioAutenticado();
        $entities = $em->getRepository('PortalBundle:TileGroup')->getAllTiles($funcionalidades);
        $response = new Response(json_encode($entities));
        $response->headers->add(array('Access-Control-Allow-Origin' => '*'));
        return $response;
    }

    public function getIUXParamsAction()
    {
        $iux = $this->container->getParameter('iux');
        return new Response(json_encode($iux));
    }

    public function loginAction()
    {
        return $this->redirect($this->generateUrl('aerial_ship_saml_sp.security.login'));
    }

    public function logoutAction()
    {
        return $this->redirect($this->generateUrl('aerial_ship_saml_sp.security.logout'));
    }

    public function getUserAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUsername();
        $response = new Response($user);
        $response->headers->add(array('Access-Control-Allow-Origin' => '*'));
        return $response;
    }

    public function changePropertyAction(Request $request)
    {
        $entityChange = $request->request->get('entity');
        $entityId = $request->request->get('entity_id');
        $property = $request->request->get('property');
        $type = $request->request->get('type');
        $value = $request->request->get('value');

        $em = $this->get('doctrine.orm.entity_manager');
        $entity = $em->getRepository($entityChange)->find($entityId);
        if (!$entity) {
            return new Response('Unable to find Tile entity.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $method = 'set' . ucfirst(strtolower($property));
        try {
            $entity->$method($this->convertValue($value, $type));
            $em->persist($entity);
            $em->flush();
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new Response("The property '$property' was changed successfully.");
    }

    public function convertValue($value, $type)
    {
        switch ($type) {
            case 'bool':
                return ($value == 'true');
            default:
                return $value;
        }
    }

    public function getLinea()
    {
        return $this->container->getParameter('iux')['linea'];
    }

    public function getBackground()
    {
        $linea = $this->getLinea();
        return "/bundles/portal/images/iux/$linea/fondo/Graficadeapoyo_" . $linea . "_1360 x768.png";
    }
}
