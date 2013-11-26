<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
use INTI\RegistroAcademicoBundle\Entity\Encargado;
use INTI\RegistroAcademicoBundle\Form\AspiranteType;

/**
 * Aspirante controller.
 *
 * @Route("/aspirante")
 */
class AspiranteController extends Controller
{

	/**
	 * Lists all Aspirante entities.
	 *
	 * @Route("/", name="aspirante_index", options={"expose"=true})
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$request = $this->getRequest();

		if($request->isXmlHttpRequest()) {
			$aspirantes = $em->getRepository('RegistroAcademicoBundle:Aspirante')
                                ->findByApellidos($request->query->get('apellido').'%');
			return $this->render(
				'RegistroAcademicoBundle:Aspirante:indexAjax.html.twig',
				array(
					'aspirantes' => $aspirantes
				));
		} else {
			$aspirantes = $em->getRepository('RegistroAcademicoBundle:Aspirante')->findAll();
			return array(
				'aspirantes' => $aspirantes,
				'title'      => 'Consultar aspirantes'
			);
		}
	}

	/**
	 * Creates a new Aspirante entity.
	 *
	 * @Route("/create", name="aspirante_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Aspirante:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$aspirante  = new Aspirante();
		$form = $this->createForm(new AspiranteType(), $aspirante);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$encargado_exist = $em->getRepository('RegistroAcademicoBundle:Encargado')->find($aspirante->getEncargado()->getDui());
			if($encargado_exist)
				$aspirante->setEncargado($encargado_exist);
			$em->persist($aspirante->getEspecialidad());
			$em->persist($aspirante->getEncargado());
			$em->persist($aspirante);
			$em->flush();

			return $this->redirect($this->generateUrl('aspirante_show', array('nie' => $aspirante->getNie())));
		}

		return array(
			'aspirante' => $aspirante,
			'form'   => $form->createView(),
			'title'  => 'Añadir un aspirante'
		);
	}

	/**
	 * Displays a form to create a new Aspirante entity.
	 *
	 * @Route("/new", name="aspirante_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$aspirante = new Aspirante();
		$form   = $this->createForm(new AspiranteType(), $aspirante);

		return array(
			'aspirante' => $aspirante,
			'form'   => $form->createView(),
			'title'  => 'Añadir un aspirante'
		);
	}

	/**
	 * Finds and displays a Aspirante entity.
	 *
	 * @Route("/{nie}", name="aspirante_show", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction(Aspirante $aspirante)
	{
		return array(
			'aspirante' => $aspirante,
			'title'  => 'Consultar aspirante'
		);
	}

	/**
	 * Displays a form to edit an existing Aspirante entity.
	 *
	 * @Route("/{nie}/edit", name="aspirante_edit", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction(Aspirante $aspirante)
	{
		$editForm = $this->createForm(new AspiranteType(), $aspirante);

		return array(
			'aspirante'    => $aspirante,
			'edit_form' => $editForm->createView(),
			'title'     => 'Modificar aspirante'
		);
	}

	/**
	 * Edits an existing Aspirante entity.
	 *
	 * @Route("/{nie}/update", name="aspirante_update", requirements={"nie"="\d+"})
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:Aspirante:edit.html.twig")
	 */
	public function updateAction(Request $request, Aspirante $aspirante)
	{
		$em = $this->getDoctrine()->getManager();
		$editForm = $this->createForm(new AspiranteType(), $aspirante);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->persist($aspirante->getEncargado());
			$em->persist($aspirante);
			$em->flush();

			return $this->redirect($this->generateUrl('aspirante_show', array('nie' => $aspirante->getNie())));
		}

		return array(
			'aspirante' => $aspirante,
			'edit_form' => $editForm->createView(),
			'title'     => 'Modificar aspirante'
		);
	}

	/**
	 * Deletes a Aspirante entity.
	 * 
	 * @Route("/{nie}/del", name="aspirante_erase", requirements={"nie"="\d+"})
	 * @Method("GET")
	 */
	public function eraseAction(Aspirante $aspirante)
	{
		$em = $this->getDoctrine()->getManager();
		$em->remove($empleado);
		$em->flush();
		return $this->redirect($this->generateUrl('aspirante_index'));
	}

	/**
	 * Return Encargado Aspirante
	 *
	 * @Route("/encargado/{dui}", name="encargado_show", requirements={"dui"="\d{8}-\d"}, options={"expose"=true})
	 * @Method("GET")
	 */
	public function encargadoShowAction(Encargado $encargado)
	{
		$serializer = $this->get("jms_serializer");
		return new Response($serializer->serialize($encargado, 'json'), 200, array("Content-Type" => "application/json; charset=UTF-8"));
	}

	/**
	 * Muestra todos los DUI que concuerdan con el patrón
	 * 
	 * @Route("/encargado/{dui}", name="encargado_index", options={"expose"=true})
	 */
	public function encargadoIndexAction($dui)
	{
		$serializer = $this->get("jms_serializer");
        $request = $this->getRequest();
        if($request->isXmlHttpRequest())
            $duis = $this->getDoctrine()
                ->getRepository('RegistroAcademicoBundle:Encargado')
                ->findDUI($dui);
        else
            $duis = $this->getDoctrine()
                ->getRepository('RegistroAcademicoBundle:Encargado')
                ->findAllDUI($dui);
		return new Response($serializer->serialize($duis, 'json'), 200, array("Content-Type" => "application/json; charset=UTF-8"));
	}
}
