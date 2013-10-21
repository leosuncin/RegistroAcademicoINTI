<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Periodo;
use INTI\RegistroAcademicoBundle\Form\PeriodoType;
use INTI\RegistroAcademicoBundle\Form\AnhoType;

/**
 * Periodo controller.
 *
 * @Route("/periodo")
 */
class PeriodoController extends Controller
{

    /**
     * Lists all Periodo entities.
     *
     * @Route("/", name="periodo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository('RegistroAcademicoBundle:Periodo')->findBy(array(), array('id'=>'desc'));
//		$entities = $em->getRepository('RegistroAcademicoBundle:Periodo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Periodo entity.
     *
     * @Route("/", name="periodo_create")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:Periodo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Periodo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('periodo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


	
    /**
    * Creates a form to create a Periodo entity.
    *
    * @param Periodo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Periodo $entity)
    {
        $form = $this->createForm(new PeriodoType(), $entity, array(
            'action' => $this->generateUrl('periodo_create'),
            'method' => 'POST',
        ));

		/*$form->add('submit', 'submit', array(
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
    public function newAction()
    {
        $entity = new Periodo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
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
    private function iniciarAnhoForm(Periodo $entity)
    {
        $form = $this->createForm(new AnhoType(), $entity, array(
            'action' => $this->generateUrl('anho_iniciar'),
            'method' => 'POST',
        ));

		/*$form->add('submit', 'submit', array(
			'label' => 'Iniciar Periodo',
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


    public function ini_anhoAction()
    {
        $entity = new Periodo();
        $form   = $this->iniciarAnhoForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


/**
     * Creates a new Periodo entity.
     *
     * @Route("/", name="anho_iniciar")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:Periodo:ini_anho.html.twig")
     */
    public function anho_iniciarAction(Request $request)
    {
        $entity = new Periodo();

		$p1 = new Periodo();
		$p2 = new Periodo();
		$p3 = new Periodo();
		$p4 = new Periodo();
		$p5 = new Periodo();

        $form = $this->iniciarAnhoForm($entity);
        $form->handleRequest($request);
        
            $em = $this->getDoctrine()->getManager();
			$p1->setNumPeriodo(1);
			$p1->setAnhoCorriente($entity->getAnhoCorriente);
			$p1->setEstaAbierto(2);
//
			$p2->setNumPeriodo(2);
			$p2->setAnhoCorriente($entity->getAnhoCorriente);
			$p2->setEstaAbierto(2);
//
			$p3->setNumPeriodo(3);
			$p3->setAnhoCorriente($entity->getAnhoCorriente);
			$p3->setEstaAbierto(2);
//
			$p4->setNumPeriodo(4);
			$p4->setAnhoCorriente($entity->getAnhoCorriente);
			$p4->setEstaAbierto(2);
//
			$p5->setNumPeriodo(5);
			$p5->setAnhoCorriente($entity->getAnhoCorriente);
			$p5->setEstaAbierto(2);
//

            $em->persist($p1);
            $em->persist($p2);
            $em->persist($p3);
            $em->persist($p4);
            $em->persist($p5);
            //$em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('periodo'));

  /*      return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
   */
    }
  

//Fin metodos relacionados con el inicio de un año escolar


    /**
     * Finds and displays a Periodo entity.
     *
     * @Route("/{id}", name="periodo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Periodo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Periodo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
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
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Periodo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Periodo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
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
    private function createEditForm(Periodo $entity)
    {
        $form = $this->createForm(new PeriodoType(), $entity, array(
            'action' => $this->generateUrl('periodo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Periodo entity.
     *
     * @Route("/{id}", name="periodo_update")
     * @Method("PUT")
     * @Template("RegistroAcademicoBundle:Periodo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Periodo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Periodo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('periodo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Periodo entity.
     *
     * @Route("/{id}", name="periodo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
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
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('periodo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
