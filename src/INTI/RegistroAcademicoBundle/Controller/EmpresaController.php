<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Empresa;
use INTI\RegistroAcademicoBundle\Form\EmpresaType;

/**
 * Empresa controller.
 *
 * @Route("/empresa")
 */
class EmpresaController extends Controller
{

	/**
	 * Lists all Empresa entities.
	 *
	 * @Route("/", name="empresa_index")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository('RegistroAcademicoBundle:Empresa')->findAll();

		return array(
			'entities' => $entities,
			'title'    => 'Consultar empresas'
		);
	}

	/**
	 * Creates a new Empresa entity.
	 *
	 * @Route("/create", name="empresa_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Empresa:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$entity = new Empresa();
		$form = $this->createForm(new EmpresaType(),$entity);
		$form->submit($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			$this->get('session')->getFlashBag()->add('notice', 'Se inserto correctamente');
			return $this->redirect($this->generateUrl('empresa_show', array('id' => $entity->getId())));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
			'title'  => 'Añadir una empresa'
		);
	}


	/**
	 * Displays a form to create a new Empresa entity.
	 *
	 * @Route("/new", name="empresa_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new Empresa();
		$form   = $this->createForm(new EmpresaType(),$entity);

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
			'title'  => 'Añadir una empresa'
		);
	}

	/**
	 * Finds and displays a Empresa entity.
	 *
	 * @Route("/{id}", name="empresa_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Empresa')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Empresa entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity'      => $entity,
			'delete_form' => $deleteForm->createView(),
			'title'       => 'Consultar empresa'
		);
	}

	/**
	 * Displays a form to edit an existing Empresa entity.
	 *
	 * @Route("/{id}/edit", name="empresa_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Empresa')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Empresa entity.');
		}

		$editForm = $this->createForm(new EmpresaType(),$entity);
		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
			'title'       => 'Modificar empresa'
		);
	}

	

	/**
	 * Edits an existing Empresa entity.
	 *
	 * @Route("/{id}/update", name="empresa_update")
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:Empresa:edit.html.twig")
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Empresa')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Empresa entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createForm(new EmpresaType(),$entity);
		$editForm->submit($request);

		if ($editForm->isValid()) {
			$em->flush();
			$this->get('session')->getFlashBag()->add('notice', 'Se modifico correctamente');
			return $this->redirect($this->generateUrl('empresa_show', array('id' => $id)));
		}

		return array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
			'title'       => 'Modificar empresa'
		);
	}
	/**
	 * Deletes a Empresa entity.
	 *
	 * @Route("/{id}/del", name="empresa_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, $id)
	{
		$form = $this->createDeleteForm($id);
		$form->submit($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('RegistroAcademicoBundle:Empresa')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Empresa entity.');
			}

			$em->remove($entity);
			$em->flush();
		}
$this->get('session')->getFlashBag()->add('notice', 'Se elimino correctamente');
		return $this->redirect($this->generateUrl('empresa_index'));
	}

	/**
	* Creates a form to delete a Empresa entity by id.
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
}
