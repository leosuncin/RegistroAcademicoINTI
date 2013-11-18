<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use INTI\RegistroAcademicoBundle\Entity\Especialidad;
use INTI\RegistroAcademicoBundle\Form\EspecialidadType;
/**
 * Especialidad controller.
 *
 * @Route("/especialidad")
 */
class EspecialidadController extends Controller
{


	/**
	 * Lists all Especialidad entities.
	 *
	 * @Route("/", name="especialidad_index")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository('RegistroAcademicoBundle:Especialidad')->findAll();

		return array(
			'entities' => $entities,
		);
	}

	/**
	 * Creates a new Especialidad entity.
	 *
	 * @Route("/", name="especialidad_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Especialidad:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$entity  = new Especialidad();
		$form = $this->createForm(new EspecialidadType(), $entity);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
		 //  $em->persist($entity->getCodigo());

			$em->persist($entity);
			$em->flush();
			$this->get('session')->getFlashBag()->add('notice', 'Se inserto correctamente');
			return $this->redirect($this->generateUrl('especialidad_show', array('id' => $entity->getCodigo())));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
			'title'  => 'Añadir Especialidad'
		);
	}

	/**
	 * Displays a form to create a new Especialidad entity.
	 *
	 * @Route("/new", name="especialidad_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new Especialidad();
		$form   = $this->createForm(new EspecialidadType(), $entity);

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	/**
	 * Finds and displays a Especialidad entity.
	 *
	 * @Route("/{codigo}", name="especialidad_show", requirements={"codigo"="[A-Z]{2,5}"})
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction(Especialidad $especialidad)
	{
		$deleteForm = $this->createDeleteForm($especialidad->getCodigo());

		return array(
			'entity'      => $especialidad,
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Displays a form to edit an existing Especialidad entity.
	 *
	 * @Route("/{codigo}/edit", name="especialidad_edit", requirements={"codigo"="[A-Z]{2,5}"})
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction(Especialidad $especialidad)
	{
		$editForm = $this->createForm(new EspecialidadType(), $especialidad);
		$deleteForm = $this->createDeleteForm($especialidad->getCodigo());

		return array(
			'entity'      => $especialidad,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Edits an existing Especialidad entity.
	 *
	 * @Route("/{codigo}/update", name="especialidad_update", requirements={"codigo"="[A-Z]{2,5}"})
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:Especialidad:edit.html.twig")
	 */
	public function updateAction(Request $request, Especialidad $especialidad)
	{
		$em = $this->getDoctrine()->getManager();

		$deleteForm = $this->createDeleteForm($especialidad->getCodigo());
		$editForm = $this->createForm(new EspecialidadType(), $especialidad);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->persist($especialidad);
			$em->flush();
			$this->get('session')->getFlashBag()->add('notice', 'Se modifico correctamente');
			return $this->redirect($this->generateUrl('especialidad_edit', array('codigo' => $especialidad->getCodigo())));
		}

		return array(
			'entity'      => $especialidad,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Deletes a Especialidad entity.
	 *
	 * @Route("/{codigo}/del", name="especialidad_delete", requirements={"codigo"="[A-Z]{2,5}"})
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, Especialidad $especialidad)
	{
		$form = $this->createDeleteForm($especialidad->getCodigo());
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em->remove($especialidad);
			$em->flush();
		}
		$this->get('session')->getFlashBag()->add('notice', 'Se elimino correctamente');
		return $this->redirect($this->generateUrl('especialidad_index'));
	}

	/**
	 * Creates a form to delete a Especialidad entity by id.
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
	 * Lists all Especialidad entities.
	 *
	 * @Route("/ajax", name="ComboEspecialidadAjax")
	 * @Method("GET")
	 * @Template()
	 */
	public function especialidadesAction()
	{
		$em = $this->getDoctrine()->getManager();
		$especialidades = $em->getRepository('RegistroAcademicoBundle:Especialidad')->findAll();
		if($this->getRequest()->isXmlHttpRequest()) {
			$serializer = $this->get("jms_serializer");
			$respuesta = new Response($serializer->serialize($especialidades, "json"));
			$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
			return $respuesta;
		} else
	 		return array('especialidades' => $especialidades);
	}
}
