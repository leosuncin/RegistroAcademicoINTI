<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
use INTI\RegistroAcademicoBundle\Entity\Usuario;
use INTI\RegistroAcademicoBundle\Form\AlumnoType;

/**
 * Alumno controller.
 *
 * @Route("/alumno")
 */
class AlumnoController extends Controller
{

	/**
	 * Lists all Alumno entities.
	 *
	 * @Route("/", name="alumno_index", options={"expose"=true})
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$request = $this->getRequest();

		if($this->getUser()->getRoles()[0] == 'ROLE_USER' && count($this->getUser()->getRoles()) == 1)
			return new RedirectResponse($this->generateUrl('alumno_show', array('nie' => $this->getUser()->getUsername())), 301);

		if($request->isXmlHttpRequest()) {
			$apellidos = $request->query->get('apellidos');
			$codigo = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->find($request->query->get('codigo', ''));
			$entities = $em->getRepository('RegistroAcademicoBundle:Alumno')->findByApellidos($apellidos.'%', $codigo);
			return $this->render(
				'RegistroAcademicoBundle:Alumno:indexAjax.html.twig',
				array(
					'entities' => $entities
				));;
		} else {
			$entities = $em->getRepository('RegistroAcademicoBundle:Alumno')->findAll();
			$especialidades = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
			return array(
				'entities' => $entities,
				'especialidades' => $especialidades,
				'title'    => 'Consultar alumnos'
			);
		}
	}

	/**
	 * Creates a new Alumno entity.
	 *
	 * @Route("/create", name="alumno_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Alumno:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$alumno  = new Alumno();
		$form = $this->createForm(new AlumnoType(), $alumno);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$factory  = $this->get('security.encoder_factory');

			$usuario = new Usuario();
			$encoder  = $factory->getEncoder($usuario);
			$usuario->setUsername($alumno->getNie());
			$password = $encoder->encodePassword($alumno->getNie()*2, $usuario->getSalt());
			$usuario->setPassword($password);
			$usuario->addRole('ROLE_USER');
			$alumno->setUsuario($usuario);

			$encargado = $em->getRepository('RegistroAcademicoBundle:Encargado')->find($alumno->getEncargado()->getDui());
			if($encargado != null)
				$alumno->setEncargado($encargado);

			$em->persist($usuario);
			$em->persist($alumno);
			$em->flush();

			return $this->redirect($this->generateUrl('alumno_show', array('nie' => $alumno->getNie())));
		}

		return array(
			'alumno'    => $alumno,
			'aspirante' => $aspirante->getNie(),
			'form'      => $form->createView(),
			'title'     => 'Añadir un alumno'
		);
	}

	/**
	 * Displays a form to create a new Alumno entity.
	 *
	 * @Route("/new", name="alumno_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new Alumno();
		$form   = $this->createForm(new AlumnoType(), $entity);

		$em = $this->getDoctrine()->getManager();
		//$especialidades = $em->getRepository('RegistroAcademicoBundle:Especialidad')->findAll();
		//$codigoespecialidades = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
		
		return array(
			'entity' => $entity,
			//'especialidades' => $especialidades,
			//'codigoespecialidades' => $codigoespecialidades,
			'form'   => $form->createView(),
			'title'  => 'Añadir un alumno'
		);
	}

	/**
	 * Displays a form to create a new Alumno entity.
	 *
	 * @Route("/{aspirante}/inscribir", name="alumno_inscribir")
	 * @ParamConverter("aspirante", class="RegistroAcademicoBundle:Aspirante", options={"nie" = "aspirante"})
	 * @Method("GET")
	 * @Template()
	 */
	public function inscribirAction(Aspirante $aspirante)
	{
		$entity = new Alumno($aspirante);
		$form   = $this->createForm(new AlumnoType(), $entity);

		$em = $this->getDoctrine()->getManager();
		
		return array(
			'entity'    => $entity,
			'aspirante' => $aspirante->getNie(),
			'form'      => $form->createView(),
			'title'     => 'Añadir un alumno'
		);
	}

	/**
	 * Creates a new Alumno entity.
	 *
	 * @Route("/{aspirante}/matricular", name="alumno_matricular")
	 * @ParamConverter("aspirante", class="RegistroAcademicoBundle:Aspirante", options={"nie" = "aspirante"})
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Alumno:inscribir.html.twig")
	 */
	public function matricularAction(Aspirante $aspirante, Request $request)
	{
		$alumno = new Alumno();
		$form = $this->createForm(new AlumnoType(), $alumno);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$factory  = $this->get('security.encoder_factory');

			$usuario = new Usuario();
			$encoder  = $factory->getEncoder($usuario);
			$usuario->setUsername($alumno->getNie());
			$password = $encoder->encodePassword($alumno->getNie()*2, $usuario->getSalt());
			$usuario->setPassword($password);
			$usuario->addRole('ROLE_USER');
			$alumno->setUsuario($usuario);

			$encargado = $em->getRepository('RegistroAcademicoBundle:Encargado')->find($alumno->getEncargado()->getDui());
			if($encargado != null)
				$alumno->setEncargado($encargado);

			$em->persist($usuario);
			$em->persist($alumno);
			$em->remove($aspirante);
			$em->flush();

			return $this->redirect($this->generateUrl('alumno_show', array('nie' => $alumno->getNie())));
		}

		return array(
			'alumno' => $alumno,
			'form'   => $form->createView(),
			'title'  => 'Añadir un alumno'
		);
	}

	/**
	 * Finds and displays a Alumno entity.
	 *
	 * @Route("/{nie}", name="alumno_show", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction(Alumno $entity)
	{
		return array(
			'entity' => $entity,
			'notas'  => $this->getDoctrine()->getManager()->getRepository('RegistroAcademicoBundle:Nota')->findByAlumno($entity),
			'title'  => 'Consultar alumno'
		);
	}

	/**
	 * Displays a form to edit an existing Alumno entity.
	 *
	 * @Route("/{nie}/edit", name="alumno_edit", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction(Alumno $entity)
	{
		$editForm = $this->createForm(new AlumnoType(), $entity);

		return array(
			'entity'    => $entity,
			'edit_form' => $editForm->createView(),
			'title'     => 'Modificar alumno'
		);
	}

	/**
	 * Edits an existing Alumno entity.
	 *
	 * @Route("/{nie}/update", name="alumno_update", requirements={"nie"="\d+"})
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:Alumno:edit.html.twig")
	 */
	public function updateAction(Request $request, Alumno $alumno)
	{
		$em = $this->getDoctrine()->getManager();

		$editForm = $this->createForm(new AlumnoType(), $alumno);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->persist($alumno);
			$em->flush();

			return $this->redirect($this->generateUrl('alumno_show', array('nie' => $nie)));
		}

		return array(
			'alumno'      => $alumno,
			'edit_form'   => $editForm->createView(),
			'title'       => 'Modificar alumno'
		);
	}

	/**
	 * Deletes a Alumo entity.
	 *
	 * @Route("/{nie}/del", name="alumno_erase")
	 * @Method("DELETE")
	 */
	public function deleteAction($nie)
	{
		$em = $this->getDoctrine()->getManager();

		$aspirante = $em->getRepository('RegistroAcademicoBundle:Alumno')->find($nie);

		if (!$aspirante) {
			throw $this->createNotFoundException('Unable to find Alumno entity.');
		}

		$em->remove($aspirante);
		$em->flush();
		return $this->redirect($this->generateUrl('alumno_index'));
	}

	/**
	 * Buscar por apellidos
	 * @Route("/ajax", name="alumno_ajax", options={"expose"=true})
	 * @Method("GET")
	 * @return JSON
	 */
	public function searchAction()
	{
		$em = $this->getDoctrine()->getManager();
		$request = $this->getRequest();
		$serializer = $this->get("jms_serializer");

		$alumnos = $em->getRepository('RegistroAcademicoBundle:Alumno')
		->findByApellido($request->query->get('apellidos').'%');

		return new Response($serializer->serialize($alumnos, 'json'), 200, array("Content-Type" => "application/json; charset=UTF-8"));
	}
}
