<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\ServicioSocial;
use INTI\RegistroAcademicoBundle\Form\ServicioSocialType;

/**
 * ServicioSocial controller.
 *
 * @Route("/serviciosocial")
 */
class ServicioSocialController extends Controller
{
    

    /**
     * Lists all ServicioSocial entities.
     *
     * @Route("/", name="serviciosocial")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
       
        $entities = $em->getRepository('RegistroAcademicoBundle:ServicioSocial')->findAll();

        return array(
            'entities' => $entities,
            
        );
    }
    /**
     * Creates a new ServicioSocial entity.
     *
     * @Route("/", name="serviciosocial_create")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:ServicioSocial:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ServicioSocial();
        $form = $this->createForm(new ServicioSocialType,$entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Se inserto correctamente');
            return $this->redirect($this->generateUrl('serviciosocial_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'title'  => 'Añadir ServicioSocial',
        );
    }

 

    /**
     * Displays a form to create a new ServicioSocial entity.
     *
     * @Route("/new", name="serviciosocial_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ServicioSocial();
        $form   = $this->createForm(new ServicioSocialType(),$entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ServicioSocial entity.
     *
     * @Route("/{id}", name="serviciosocial_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:ServicioSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioSocial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ServicioSocial entity.
     *
     * @Route("/{id}/edit", name="serviciosocial_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:ServicioSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioSocial entity.');
        }

        $editForm = $this->createForm(new ServicioSocialType(),$entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    
    /**
     * Edits an existing ServicioSocial entity.
     *
     * @Route("/{id}", name="serviciosocial_update")
     * @Method("PUT")
     * @Template("RegistroAcademicoBundle:ServicioSocial:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:ServicioSocial')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ServicioSocial entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ServicioSocialType(),$entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('serviciosocial_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ServicioSocial entity.
     *
     * @Route("/{id}", name="serviciosocial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RegistroAcademicoBundle:ServicioSocial')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ServicioSocial entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('serviciosocial'));
    }

    /**
     * Creates a form to delete a ServicioSocial entity by id.
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
            ->setAction($this->generateUrl('serviciosocial_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;*/
    }
}
