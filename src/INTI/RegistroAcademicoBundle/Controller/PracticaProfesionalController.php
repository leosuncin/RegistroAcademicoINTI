<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\PracticaProfesional;
use INTI\RegistroAcademicoBundle\Form\PracticaProfesionalType;

/**
 * PracticaProfesional controller.
 *
 * @Route("/practicaprofesional")
 */
class PracticaProfesionalController extends Controller
{

    /**
     * Lists all PracticaProfesional entities.
     *
     * @Route("/", name="practicaprofesional")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RegistroAcademicoBundle:PracticaProfesional')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PracticaProfesional entity.
     *
     * @Route("/", name="practicaprofesional_create")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:PracticaProfesional:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PracticaProfesional();
        $form = $this->createForm(new PracticaProfesionalType(),$entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('practicaprofesional_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

  

    /**
     * Displays a form to create a new PracticaProfesional entity.
     *
     * @Route("/new", name="practicaprofesional_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PracticaProfesional();
        $form   = $this->createForm(new PracticaProfesionalType(),$entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PracticaProfesional entity.
     *
     * @Route("/{id}", name="practicaprofesional_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:PracticaProfesional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PracticaProfesional entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PracticaProfesional entity.
     *
     * @Route("/{id}/edit", name="practicaprofesional_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:PracticaProfesional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PracticaProfesional entity.');
        }

        $editForm = $this->createForm(new PracticaProfesionalType(),$entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    
    /**
     * Edits an existing PracticaProfesional entity.
     *
     * @Route("/{id}", name="practicaprofesional_update")
     * @Method("PUT")
     * @Template("RegistroAcademicoBundle:PracticaProfesional:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:PracticaProfesional')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PracticaProfesional entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createtForm(new PracticaProfesionalType(),$entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('practicaprofesional_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PracticaProfesional entity.
     *
     * @Route("/{id}", name="practicaprofesional_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RegistroAcademicoBundle:PracticaProfesional')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PracticaProfesional entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('practicaprofesional'));
    }

    /**
     * Creates a form to delete a PracticaProfesional entity by id.
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
