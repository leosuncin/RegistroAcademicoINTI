<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Empleado;
use INTI\RegistroAcademicoBundle\Form\EmpleadoType;

/**
 * Empleado controller.
 *
 * @Route("/empleado")
 */
class EmpleadoController extends Controller
{

	/**
	 * Lists all Empleado entities.
	 *
	 * @Route("/", name="empleado_index")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository('RegistroAcademicoBundle:Empleado')->findAll();

		return array(
			'entities' => $entities,
			'title'    => 'Consultar empleados'
		);
	}

	/**
	 * Creates a new Empleado entity.
	 *
	 * @Route("/", name="empleado_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Empleado:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$entity  = new Empleado();
		$form = $this->createForm(new EmpleadoType(), $entity);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$usuario = $entity->getUsuario();
			$factory  = $this->get('security.encoder_factory');
			$encoder  = $factory->getEncoder($usuario);
			$password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
			$usuario->setPassword($password);
			$puesto = $entity->getPuesto();
			if($puesto == "director" || $puesto == "subdirector")
				$usuario->addRole("ROLE_ADMIN");
			else if($puesto == "encargado_reg_acad")
				$usuario->addRole("ROLE_ACADEMIC_ADMIN");
			else if($puesto == "secretaria_reg_acad")
			  $usuario->addRole("ROLE_ACADEMIC");
			else if($puesto == "encargado_serv_soc")
				$usuario->addRole("ROLE_SERV_SOC");
			else if($puesto == "encargado_serv_soc")
				$usuario->addRole("ROLE_PRAC_PROF");
			$em->persist($usuario);
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('empleado_show', array('id' => $entity->getDui())));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
			'title'  => 'Añadir empleado'
		);
	}

	/**
	 * Displays a form to create a new Empleado entity.
	 *
	 * @Route("/new", name="empleado_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new Empleado();
		$form   = $this->createForm(new EmpleadoType(), $entity);

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
			'title'  => 'Añadir empleado'
		);
	}

	/**
	 * Finds and displays a Empleado entity.
	 *
	 * @Route("/{id}", name="empleado_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Empleado')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Empleado entity.');
		}


		return array(
			'entity'      => $entity,
			'title'       => 'Consultar un empleado'
		);
	}

	/**
	 * Displays a form to edit an existing Empleado entity.
	 *
	 * @Route("/{id}/edit", name="empleado_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Empleado')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Empleado entity.');
		}

		$editForm = $this->createForm(new EmpleadoType(), $entity);

		return array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'title'       => 'Modificar la información de un empleado'
		);
	}

	/**
	 * Edits an existing Empleado entity.
	 *
	 * @Route("/{id}", name="empleado_update")
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:Empleado:edit.html.twig")
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Empleado')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Empleado entity.');
		}

		$editForm = $this->createForm(new EmpleadoType(), $entity);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('empleado_show', array('id' => $id)));
		}

		return array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'title'       => 'Modificar la información de un empleado'
		);
	}

	/**
	 * Deletes a Empleado entity.
	 *
	 * @Route("/{id}/del", name="empleado_erase")
	 * @Method("GET")
	 */
	public function eraseAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$empleado = $em->getRepository('RegistroAcademicoBundle:Empleado')->find($id);
		if (!$empleado) {
			throw $this->createNotFoundException('Unable to find Empleado entity.');
		}
		$em->remove($empleado);
		$em->flush();
		return $this->redirect($this->generateUrl('empleado_index'));
	}
}
