<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Periodo;
use INTI\RegistroAcademicoBundle\Entity\Anho;
use INTI\RegistroAcademicoBundle\Form\PeriodoType;
use INTI\RegistroAcademicoBundle\Form\AnhoType;

/**
 * Periodo controller.
 *
 * @Route("/periodo")
 */
class PeriodoController extends Controller {

	/**
	 * Lists all Periodo entities.
	 *
	 * @Route("/", name="periodo_index")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction() {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository("RegistroAcademicoBundle:Anho")->findBy(array("enCurso" => true));
		
		if ($entity) {
			$queryPeriodo = $em->createQuery('SELECT p FROM RegistroAcademicoBundle:Periodo p WHERE p.anho = :anho')
					->setParameter(':anho', $entity);
			$periodos = $queryPeriodo->getResult();
			if ($periodos) {
				return array(
					'entity'   => $entity,
					'periodos' => $periodos,
					'title'    => 'Consultar periodos escolares'
				);
			} else {
				return array(
					'entity' => $entity,
					'title' => 'Consultar periodos escolares'
				);
			}
		} else {
			return array('title' => 'Consultar periodos escolares');
		}
	}

	/**
	 * @Route("/start", name="anho_start")
	 * @Method("POST")
	 */
	public function startAnhoAction() {
		$anho = new Anho();
		$em = $this->getDoctrine()->getManager();

		$em->persist($anho);
		$em->flush();

		$respuesta = new JsonResponse(json_encode(array('current' => $anho->getAnho(), 'inicio' => $anho->getInicio()->format("d M Y"))));
		$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");

		return $respuesta;
	}

	/**
	 * @Route("/close", name="anho_close")
	 * @Method("POST")
	 */
	public function closeAnhoAction(Request $request) {
		$em = $this->getDoctrine()->getManager();
		$anho = $em->getRepository("RegistroAcademicoBundle:Anho")
				->findBy(array("anho" => 2013));
		if($anho){
			$anho->setFin(new \DateTime("NOW"));
			
//			  $em->persist($anho);
//			  $em->flush();
			
			$respuesta = new JsonResponse(json_encode(array('fin' => $anho->getFin())));
			$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
			
			return $respuesta;
		} else {
			$respuesta = new JsonResponse(json_encode(array('error' => 'El año ya esta cerrado')));
			$respuesta->headers->set("Content-Type", "application/json; charset=UTF-8");
			
			return $respuesta;
		}
	}

	/**
	 * Creates a new Periodo entity.
	 *
	 * @Route("/", name="periodo_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Periodo:new.html.twig")
	 */
	public function createAction(Request $request) {
		$entity = new Periodo();
		$form = $this->createCreateForm($entity);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('periodo_show', array('id' => $entity->getid())));
		}

		return array(
			'entity' => $entity,
			'form' => $form->createView(),
		);
	}

	/**
	 * Creates a form to create a Periodo entity.
	 *
	 * @param Periodo $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm(Periodo $entity) {
		$form = $this->createForm(new PeriodoType(), $entity, array(
			'action' => $this->generateUrl('periodo_create'),
			'method' => 'POST',
		));

		/* $form->add('submit', 'submit', array(
		  'label' => 'Iniciar Periodo',
		  'attr'=>array('class'=>'btn btn-primary')
		  ));
		 */

		return $form;
	}

	/**
	 * Displays a form to create a new Periodo entity.
	 *
	 * @Route("/new", name="periodo_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction() {
		$entity = new Periodo();
		$form = $this->createCreateForm($entity);

		return array(
			'entity' => $entity,
			'form' => $form->createView(),
		);
	}

//Metodos relacionados con el inicio de un nuevo año escolar

	/**
	 * Crea un formulario para iniciar un año escolar.
	 *
	 * @param Periodo $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function iniciarAnhoForm(Periodo $entity) {
		$form = $this->createForm(new AnhoType(), $entity, array(
			'action' => $this->generateUrl('anho_iniciar'),
			'method' => 'POST',
		));
		/*
		  $form->add('submit', 'submit', array(
		  'label' => 'Abrir',
		  'attr'=>array('class'=>'btn btn-primary')
		  ));
		 */

		 return $form;
	}

	/**
	 * Muestra un formulario para iniciar el año escolar.
	 *
	 * @Route("/iniciar_anho", name="iniciar_anho")
	 * @Method("GET")
	 * @Template()
	 */
	public function ini_anhoAction() {
		$entity = new Periodo();
		$form = $this->iniciarAnhoForm($entity);

		return array(
			'entity' => $entity,
			'form' => $form->createView(),
		);
	}

	/**
	 * Crea 5 periodos del año que se acaba de abrir
	 *
	 * @Route("/anho_ini", name="anho_iniciar")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Periodo:ini_anho.html.twig")
	 */
	public function anho_iniciarAction(Request $request) {
		$entity = new Periodo();

		$p1 = new Periodo();
		$p2 = new Periodo();
		$p3 = new Periodo();
		$p4 = new Periodo();
		$p5 = new Periodo();
		$r1 = new Periodo();

		$form = $this->iniciarAnhoForm($entity);
		$form->handleRequest($request);

		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
						'SELECT p
				FROM RegistroAcademicoBundle:Periodo p
				WHERE p.anhoCorriente = :anhoCorriente'
				)->setParameter('anhoCorriente', $entity->getAnhoCorriente());
		$periodos = $query->getResult();
		$yaingresados = count($periodos);
		if ($yaingresados > 4) {
			$this->get('session')->getFlashBag()->add('notice', 'Ya se ha iniciado el año Escolar');
			return $this->redirect($this->generateUrl('iniciar_anho'));
		} else {
			$p1->setNumPeriodo(1);
			$p1->setAnhoCorriente($entity->getAnhoCorriente());
			$p1->setEstaAbierto(2);

			$em->persist($p1);
			$em->flush();
			$p2->setNumPeriodo(2);
			$p2->setAnhoCorriente($entity->getAnhoCorriente());
			$p2->setEstaAbierto(2);

			$em->persist($p2);
			$em->flush();
			$p3->setNumPeriodo(3);
			$p3->setAnhoCorriente($entity->getAnhoCorriente());
			$p3->setEstaAbierto(2);

			$em->persist($p3);
			$p4->setNumPeriodo(4);
			$p4->setAnhoCorriente($entity->getAnhoCorriente());
			$p4->setEstaAbierto(2);

			$em->persist($p4);
			$em->flush();
			$p5->setNumPeriodo(5);
			$p5->setAnhoCorriente($entity->getAnhoCorriente());
			$p5->setEstaAbierto(2);

			$em->persist($p5);

			$em->flush();

			$this->get('session')->getFlashBag()->add('notice', 'Se ha iniciado el año Escolar con exito');
			return $this->redirect($this->generateUrl('periodo'));
		}
	}

//Fin metodos relacionados con el inicio de un año escolar

	/**
	 * Finds and displays a Periodo entity.
	 *
	 * @Route("/{id}", name="periodo_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Periodo')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Periodo entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity' => $entity,
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Displays a form to edit an existing Periodo entity.
	 *
	 * @Route("/{id}/edit", name="periodo_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Periodo')->find($id);
		$query = $em->createQuery(
				'SELECT p
				FROM RegistroAcademicoBundle:Periodo p
				WHERE p.estaAbierto = 1'
		);
//		$otroPerAbierto= $m:	
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Periodo entity.');
		}

		$editForm = $this->createEditForm($entity);
		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity' => $entity,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Creates a form to edit a Periodo entity.
	 *
	 * @param Periodo $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createEditForm(Periodo $entity) {
		$form = $this->createForm(new PeriodoType(), $entity, array(
			'action' => $this->generateUrl('periodo_update', array('id' => $entity->getId())),
			'method' => 'PUT',
		));

//		  $form->add('submit', 'submit', array('label' => 'Cambiar Estado'));

		return $form;
	}

	/**
	 * Edits an existing Periodo entity.
	 *
	 * @Route("/{id}", name="periodo_update")
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:Periodo:edit.html.twig")
	 */
	public function updateAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('RegistroAcademicoBundle:Periodo')->find($id);
		$query = $em->createQuery(
				'SELECT p
				FROM RegistroAcademicoBundle:Periodo p
				WHERE p.estaAbierto = 2'
		);
		$periodos = $query->getResult();
		$otroPeriodoAbierto = count($periodos);
		if ($otroPeriodoAbierto > 0) {
			$this->get('session')->getFlashBag()->add('notice', 'Ya hay un periodo abierto');

			return $this->redirect($this->generateUrl('periodo_edit', array('id' => $id)));
			//si es cierto solo se muestra un mensaje de error
		}
		$estadoInicial = $entity->getEstaAbierto();
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Periodo entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->flush();
			if ($estadoInicial != $entity->getEstaAbierto())
				$this->get('session')->getFlashBag()->add('notice', 'Se ha cambiado el estado del periodo');
			else
				$this->get('session')->getFlashBag()->add('notice', 'Ningún cambio');
			return $this->redirect($this->generateUrl('periodo_edit', array('id' => $id)));
		}

		return array(
			'entity' => $entity,
			'edit_form' => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Deletes a Periodo entity.
	 *
	 * @Route("/{id}", name="periodo_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, $id) {
		$form = $this->createDeleteForm($id);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('RegistroAcademicoBundle:Periodo')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Periodo entity.');
			}

			$em->remove($entity);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('periodo'));
	}

	/**
	 * Creates a form to delete a Periodo entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm($id) {
		return $this->createFormBuilder()
						->setAction($this->generateUrl('periodo_delete', array('id' => $id)))
						->setMethod('DELETE')
						->add('submit', 'submit', array('label' => 'Eliminar'))
						->getForm()
		;
	}

}
