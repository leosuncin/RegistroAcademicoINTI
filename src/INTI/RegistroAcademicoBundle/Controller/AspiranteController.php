<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
use INTI\RegistroAcademicoBundle\Form\AspiranteType;

/**
 * Aspirante controller.
 *
 * @Route("/aspirante")
 */
class AspiranteController extends Controller
{

    /**
     * Lists all Aspirante entities.
     *
     * @Route("/", name="aspirante_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RegistroAcademicoBundle:Aspirante')->findAll();

        return array(
            'entities' => $entities,
            'title'    => 'Consultar aspirantes'
        );
    }
    /**
     * Creates a new Aspirante entity.
     *
     * @Route("/", name="aspirante_create")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:Aspirante:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Aspirante();
        $form = $this->createForm(new AspiranteType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity->getEspecialidad());
            $em->persist($entity->getEncargado());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aspirante_show', array('id' => $entity->getNie())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'title'  => 'Añadir un aspirante'
        );
    }

    /**
     * Displays a form to create a new Aspirante entity.
     *
     * @Route("/new", name="aspirante_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Aspirante();
        $form   = $this->createForm(new AspiranteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'title'  => 'Añadir un aspirante'
        );
    }

    /**
     * Finds and displays a Aspirante entity.
     *
     * @Route("/{id}", name="aspirante_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Aspirante')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aspirante entity.');
        }

        return array(
            'entity' => $entity,
            'title'  => 'Consultar aspirante'
        );
    }

    /**
     * Displays a form to edit an existing Aspirante entity.
     *
     * @Route("/{id}/edit", name="aspirante_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Aspirante')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aspirante entity.');
        }

        $editForm = $this->createForm(new AspiranteType(), $entity);

        return array(
            'entity'    => $entity,
            'edit_form' => $editForm->createView(),
            'title'     => 'Modificar aspirante'
        );
    }

    /**
     * Edits an existing Aspirante entity.
     *
     * @Route("/{id}", name="aspirante_update")
     * @Method("PUT")
     * @Template("RegistroAcademicoBundle:Aspirante:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Aspirante')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aspirante entity.');
        }

        $editForm = $this->createForm(new AspiranteType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aspirante_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'title'       => 'Modificar aspirante'
        );
    }

    /**
     * Deletes a Aspirante entity.
     * 
     * @Route("/{id}/del", name="aspirante_erase")
     * @Method("GET")
     */
    public function eraseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $empleado = $em->getRepository('RegistroAcademicoBundle:Aspirante')->find($id);
        if (!$empleado) {
            throw $this->createNotFoundException('Unable to find Aspirante entity.');
        }
        $em->remove($empleado);
        $em->flush();
        return $this->redirect($this->generateUrl('aspirante_index'));
    }
}
