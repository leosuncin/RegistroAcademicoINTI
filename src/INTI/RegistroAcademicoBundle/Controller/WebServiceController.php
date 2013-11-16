<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
		$encargado	= $repository->find($dui);
		if(!$encargado)
			return $this->createNotFoundException("No existe un encargado con DUI ".$dui);
		$respuesta = new Response($serializer->serialize($encargado, "json"));
		$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
		return $respuesta;
	}

	/**
	 * @Route("/user/{username}/exist")
	 * @Method("GET")
	 */
	public function usuarioExistAction($username)
	{
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery("SELECT u FROM RegistroAcademicoINTI:Usuario u WHERE u.username = :username")->setParameter('username', $username);
		$usuario = $query->getSingleResult();
		$content = array();
		if(!$usuario)
			$content = array("exist" => false);
		else
			$content = array("exist" => true);
		$respuesta = new Response(json_encode($content));
		$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
		return $respuesta;
	}

	/**
	 * @Route("/user/{username}/check")
	 * @Method("GET")
	 */
	public function usuarioCheckAction($username)
	{
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery("SELECT u FROM RegistroAcademicoINTI:Usuario u WHERE u.username = :username")->setParameter('username', $username);
		$usuario = $query->getSingleResult();
		$content = array();
		if(!$usuario)
			$content = array("exist" => false);
		else
			$content = array("exist" => true);
		$respuesta = new Response(json_encode($content));
		$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
		return $respuesta;
	}
}
