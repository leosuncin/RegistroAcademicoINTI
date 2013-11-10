<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Materia;
use INTI\RegistroAcademicoBundle\Form\MateriaType;

/**
 * Materia controller.
 *
 * @Route("/materia")
 */
class MateriaController extends Controller
{

    /**
     * Lists all Materia entities.
     *
     * @Route("/", name="materia")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RegistroAcademicoBundle:Materia')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Materia entity.
     *
     * @Route("/", name="materia_create")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:Materia:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Materia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materia_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Materia entity.
    *
    * @param Materia $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Materia $entity)
    {
        $form = $this->createForm(new MateriaType(), $entity, array(
            'action' => $this->generateUrl('materia_create'),
            'method' => 'POST',
        ));

        

        return $form;
    }

    /**
     * Displays a form to create a new Materia entity.
     *
     * @Route("/new", name="materia_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Materia();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Materia entity.
     *
     * @Route("/{id}", name="materia_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Materia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encontro la materia seleccionada');
        }

        return array(
            'entity' => $entity,
            'title'  => 'Consultar Materia'
        );
    }

      /**
     * Displays a form to edit an existing Materia entity.
     *
     * @Route("/{id}/edit", name="materia_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Materia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('La materia especificada no existe');
        }

        $editForm = $this->createForm(new MateriaType(), $entity);

        return array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView(),
            'title'     => 'Modificar materia'
        );
    }

    /**
     * Edits an existing Materia entity.
     *
     * @Route("/{id}", name="materia_update")
     * @Method("PUT")
     * @Template("RegistroAcademicoBundle:Materia:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Materia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encontro la materia especificada.');
        }

        $editForm = $this->createForm(new MateriaType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('materia_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'title'       => 'Modificar Materia'
        );
    }

    /**
     * Deletes a Materia entity.
     * 
     * @Route("/{id}/del", name="materia_delete")
     * @Method("GET")
     */
    public function eraseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $materia = $em->getRepository('RegistroAcademicoBundle:Materia')->find($id);
        if (!$materia) {
            throw $this->createNotFoundException('No se encontro la materia seleccionada.');
        }
        $em->remove($materia);
        $em->flush();
        return $this->redirect($this->generateUrl('materia'));
    }
}
