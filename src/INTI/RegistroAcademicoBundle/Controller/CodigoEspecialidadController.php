<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\CodigoEspecialidad;
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
	 * @Route("/", name="codigoespecialidad_index")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();

		return array(
			'entities' => $entities,
		);
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
	 * @Route("/{id}", name="codigoespecialidad_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find CodigoEspecialidad entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity'      => $entity,
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Displays a form to edit an existing CodigoEspecialidad entity.
	 *
	 * @Route("/{id}/edit", name="codigoespecialidad_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find CodigoEspecialidad entity.');
		}

		$editForm = $this->createForm(new CodigoEspecialidadType(), $entity);
		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Edits an existing CodigoEspecialidad entity.
	 *
	 * @Route("/{id}", name="codigoespecialidad_update")
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:CodigoEspecialidad:edit.html.twig")
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find CodigoEspecialidad entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createForm(new CodigoEspecialidadType(), $entity);
		$editForm->submit($request);

		if ($editForm->isValid()) {
			$em->persist($entity);
			$em->flush();
				$this->get('session')->getFlashBag()->add('notice', 'Se modifico correctamente');
			return $this->redirect($this->generateUrl('codigoespecialidad_edit', array('id' => $id)));
		}

		return array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}
	/**
	 * Deletes a CodigoEspecialidad entity.
	 *
	 * @Route("/{id}", name="codigoespecialidad_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, $id)
	{
		$form = $this->createDeleteForm($id);
		$form->submit($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find CodigoEspecialidad entity.');
			}

			$em->remove($entity);
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
     * Lists all CodigoEspecialidad entities.
     *
     * @Route("/ComboCodigoEspecialidad", name="ComboCodigoEspecialidadAjax")
     * @Method("GET")
     */
    public function indexComboAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
		$text="";
		for($i=0;$i<count($entities);$i++){
			$text.="<option value='".$entities[$i]->getCodigo()."'>".$entities[$i]->getCodigo()."</option>";
		}
        return new Response($text);
    }

    /**
     * Lists all Especialidad entities.
     *
     * @Route("/index", name="ComboEspecialidadAjax")
     * @Method("GET")
     */
    public function indexAjaxAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('RegistroAcademicoBundle:Especialidad')->findAll();
		$text="<option value='todas'>Todas</option>";
		for($i=0;$i<count($entities);$i++){
			$text.="<option value='".$entities[$i]->getCodigo()."'>".$entities[$i]->getNombre()."</option>";
		}
        return new Response($text);
    }
}
