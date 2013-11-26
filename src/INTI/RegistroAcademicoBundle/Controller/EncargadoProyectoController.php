<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\EncargadoProyecto;
use INTI\RegistroAcademicoBundle\Form\EncargadoProyectoType;

/**
 * EncargadoProyecto controller.
 *
 * @Route("/proyecto/encargado")
 */
class EncargadoProyectoController extends Controller
{

    /**
     * Lists all EncargadoProyecto entities.
     *
     * @Route("/", name="encargado_proyecto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RegistroAcademicoBundle:EncargadoProyecto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new EncargadoProyecto entity.
     *
     * @Route("/", name="encargado_proyecto_create")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:EncargadoProyecto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new EncargadoProyecto();
        $form = $this->createForm(new EncargadoProyectoType(),$entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Se inserto correctamente');
            return $this->redirect($this->generateUrl('encargado_proyecto_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'tittle'  => 'Añadir EncargadoProyecto',
        );
    }

   
    /**
     * Displays a form to create a new EncargadoProyecto entity.
     *
     * @Route("/new", name="encargado_proyecto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EncargadoProyecto();
        $form   = $this->createForm(new EncargadoProyectoType(),$entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EncargadoProyecto entity.
     *
     * @Route("/{id}", name="encargado_proyecto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:EncargadoProyecto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EncargadoProyecto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EncargadoProyecto entity.
     *
     * @Route("/{id}/edit", name="encargado_proyecto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:EncargadoProyecto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EncargadoProyecto entity.');
        }

        $editForm = $this->createForm(new EncargadoProyectoType(),$entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

  
    /**
     * Edits an existing EncargadoProyecto entity.
     *
     * @Route("/{id}", name="encargado_proyecto_update")
     * @Method("PUT")
     * @Template("RegistroAcademicoBundle:EncargadoProyecto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:EncargadoProyecto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EncargadoProyecto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EncargadoProyectoType(),$entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('encargado_proyecto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a EncargadoProyecto entity.
     *
     * @Route("/{id}", name="encargado_proyecto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RegistroAcademicoBundle:EncargadoProyecto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EncargadoProyecto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('encargado_proyecto'));
    }

    /**
     * Creates a form to delete a EncargadoProyecto entity by id.
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
       /* return $this->createFormBuilder()
            ->setAction($this->generateUrl('encargadoproyecto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;*/
    }
}
