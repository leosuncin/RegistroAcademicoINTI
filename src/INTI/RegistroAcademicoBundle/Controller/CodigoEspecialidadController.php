<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\CodigoEspecialidad;
use INTI\RegistroAcademicoBundle\Entity\Especialidad;
use INTI\RegistroAcademicoBundle\Form\CodigoEspecialidadType;

/**
 * Codigo Especialidad controller
 *
 * @Route("/especialidad/codigo")
 */
class CodigoEspecialidadController extends Controller
{
	/**
	 * Lists all Especialidad entities.
	 *
	 * @Route("/", name="codigoespecialidad_index", options={"expose"=true})
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		if($this->getRequest()->isXmlHttpRequest()) {
			$serializer = $this->get("jms_serializer");
			$especialidad = $em->getRepository('RegistroAcademicoBundle:Especialidad')->find($this->getRequest()->query->get('especialidad'));
			$entities = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findByEspecialidad($especialidad);
			return new Response($serializer->serialize($entities, 'json'), 200, array("Content-Type" => "application/json; charset=UTF-8"));
		} else {
			$entities = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
			return array(
				'entities' => $entities,
			);
		}

	}

	/**
	 * Creates a new Especialidad entity.
	 *
	 * @Route("/", name="codigoespecialidad_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:CodigoEspecialidad:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$entity  = new CodigoEspecialidad();
		$form = $this->createForm(new CodigoEspecialidadType(), $entity);
		$form->submit($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
		 //  $em->persist($entity->getCodigo());

			$em->persist($entity);
			$em->flush();
			$this->get('session')->getFlashBag()->add('notice', 'Se inserto correctamente');
			return $this->redirect($this->generateUrl('codigoespecialidad_show', array('id' => $entity->getCodigo())));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
			'title'  => 'Añadir Especialidad'
		);
	}

	/**
	 * Displays a form to create a new CodigoEspecialidad entity.
	 *
	 * @Route("/new", name="codigoespecialidad_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new CodigoEspecialidad();
		$form   = $this->createForm(new CodigoEspecialidadType(), $entity);

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	/**
	 * Finds and displays a CodigoEspecialidad entity.
	 *
	 * @Route("/{codigo}", name="codigoespecialidad_show", requirements={"codigo"="[A-Z]{1,3}\d[A-Z]"})
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction(CodigoEspecialidad $codigoEspecialidad)
	{
		$deleteForm = $this->createDeleteForm($codigoEspecialidad->getCodigo());

		return array(
			'entity'      => $codigoEspecialidad,
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Displays a form to edit an existing CodigoEspecialidad entity.
	 *
	 * @Route("/{codigo}/edit", name="codigoespecialidad_edit", requirements={"codigo"="[A-Z]{1,3}\d[A-Z]"})
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction(CodigoEspecialidad $codigoEspecialidad)
	{
		$editForm = $this->createForm(new CodigoEspecialidadType(), $codigoEspecialidad);
		$deleteForm = $this->createDeleteForm($codigoEspecialidad->getCodigo());

		return array(
			'entity'      => $codigoEspecialidad,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Edits an existing CodigoEspecialidad entity.
	 *
	 * @Route("/{codigo}/update", name="codigoespecialidad_update", requirements={"codigo"="[A-Z]{1,3}\d[A-Z]"})
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:CodigoEspecialidad:edit.html.twig")
	 */
	public function updateAction(Request $request, CodigoEspecialidad $codigoEspecialidad)
	{
		$em = $this->getDoctrine()->getManager();

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createForm(new CodigoEspecialidadType(), $codigoEspecialidad);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->persist($codigoEspecialidad);
			$em->flush();
			$this->get('session')->getFlashBag()->add('notice', 'Se modifico correctamente');
			return $this->redirect($this->generateUrl('codigoespecialidad_edit', array('codigo' => $codigoEspecialidad->getCodigo())));
		}

		return array(
			'entity'      => $codigoEspecialidad,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Deletes a CodigoEspecialidad entity.
	 *
	 * @Route("/{codigo}", name="codigoespecialidad_delete", requirements={"codigo"="[A-Z]{1,3}\d[A-Z]"})
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, CodigoEspecialidad $codigoEspecialidad)
	{
		$form = $this->createDeleteForm($codigoEspecialidad->getCodigo());
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->remove($codigoEspecialidad);
			$em->flush();
		}
		$this->get('session')->getFlashBag()->add('notice', 'Se elimino correctamente');
		return $this->redirect($this->generateUrl('codigoespecialidad_index'));
	}

	/**
	 * Creates a form to delete a CodigoEspecialidad entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm($id)
	{
		return $this->createFormBuilder(array('id' => $id))
			->add('id', 'hidden')
			->getForm()
		;
	}

	/**
	 * Lists all CodigoEspecialidad codes.
	 *
	 * @Route("/ajax", name="ComboCodigoEspecialidadAjax")
	 * @Method("GET")
	 * @Template()
	 */
	public function codigosAction()
	{
		$em = $this->getDoctrine()->getManager();
		$codigos = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
		if($this->getRequest()->isXmlHttpRequest()) {
			$serializer = $this->get("jms_serializer");
			$respuesta = new Response($serializer->serialize($codigos, "json"));
			$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
			return $respuesta;
		} else
	 		return array('codigos' => $codigos);
	}

	/**
	 * Lists all CodigoEspecialidad codes by Especialidad.
	 *
	 * @Route("/ajax/{codigo}", name="codigoespecialidad_codigobyespecialidad", requirements={"codigo"="[A-Z]{2,5}"})
	 * @Method("GET")
	 * @Template("RegistroAcademicoBundle:CodigoEspecialidad:codigos.html.twig")
	 */
	public function codigosByEspecialidadAction(Especialidad $especialidad)
	{
		$em = $this->getDoctrine()->getManager();
		$codigos = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findBy(array('especialidad' => $especialidad));
		if($this->getRequest()->isXmlHttpRequest()) {
			$serializer = $this->get("jms_serializer");
			$respuesta = new Response($serializer->serialize($codigos, "json"));
			$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
			return $respuesta;
		} else
	 		return array('codigos' => $codigos);
	}
}
