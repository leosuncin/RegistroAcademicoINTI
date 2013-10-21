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
 * @Route("/expediente/especialidad")
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
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
         //  $em->persist($entity->getCodigo());
            
            $em->persist($entity);
            $em->flush();
			 $this->get('session')->getFlashBag()->add('notice', 'Se inserto correctamente');
            return $this->redirect($this->generateUrl('especialidad_index'));
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
     * @Route("/{id}", name="especialidad_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Especialidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Especialidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Especialidad entity.
     *
     * @Route("/{id}/edit", name="especialidad_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Especialidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Especialidad entity.');
        }

        $editForm = $this->createForm(new EspecialidadType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Especialidad entity.
     *
     * @Route("/{id}", name="especialidad_update")
     * @Method("PUT")
     * @Template("RegistroAcademicoBundle:Especialidad:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Especialidad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Especialidad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EspecialidadType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('especialidad_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Especialidad entity.
     *
     * @Route("/{id}", name="especialidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RegistroAcademicoBundle:Especialidad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Especialidad entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

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
}
