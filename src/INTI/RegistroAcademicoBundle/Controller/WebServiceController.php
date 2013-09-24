<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/ws")
 */
class WebServiceController extends Controller
{
    /**
     * @Route("/encargado/{dui}", name="encargado_dui")
     * @Method("GET")
     */
    public function encargadoAction($dui)
    {
        $serializer = $this->get("jms_serializer");
    	$repository = $this->getDoctrine()->getManager()->getRepository("RegistroAcademicoBundle:Encargado");
    	$encargado  = $repository->find($dui);
    	if(!$encargado)
    		return $this->createNotFoundException("No existe un encargado con DUI ".$dui);
    	$respuesta  = new Response($serializer->serialize($encargado, "json"));
    	$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
    	return $respuesta;
    }

    /**
     * @Route("/test", name="ws_test")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     */
    public function testAction()
    {
    	$serializer = $this->get("jms_serializer");
    	$repository = $this->getDoctrine()->getManager()->getRepository("RegistroAcademicoBundle:Usuario");
    	$entities   = $repository->findAll();
    	$respuesta  = new Response($serializer->serialize($entities, "json"));
    	$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
    	return $respuesta;
    }
}
