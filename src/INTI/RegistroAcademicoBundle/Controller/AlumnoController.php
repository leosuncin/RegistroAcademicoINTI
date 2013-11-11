<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
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
     * @Route("/", name="alumno_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RegistroAcademicoBundle:Alumno')->findAll();
		$especialidades = $em->getRepository('RegistroAcademicoBundle:Especialidad')->findAll();
        return array(
            'entities' => $entities,
			'especialidades' => $especialidades,
            'title'    => 'Consultar alumnos'
        );
    }
    /**
     * Creates a new Alumno entity.
     *
     * @Route("/", name="alumno_create")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:Alumno:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Alumno();
        $form = $this->createForm(new AlumnoType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity->getAspirante());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_show', array('nie' => $entity->getNie())));
        }
		
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'title'  => 'Añadir un alumno'
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
		$especialidades = $em->getRepository('RegistroAcademicoBundle:Especialidad')->findAll();
		$codigoespecialidades = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
		
        return array(
            'entity' => $entity,
			'especialidades' => $especialidades,
			'codigoespecialidades' => $codigoespecialidades,
            'form'   => $form->createView(),
            'title'  => 'Añadir un alumno'
        );
    }

    /**
     * Finds and displays a Alumno entity.
     *
     * @Route("/{nie}", name="alumno_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($nie)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Alumno')->find($nie);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        return array(
            'entity' => $entity,
            'title'  => 'Consultar alumno'
        );
    }

    /**
     * Displays a form to edit an existing Alumno entity.
     *
     * @Route("/{nie}/edit", name="alumno_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($nie)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Alumno')->find($nie);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

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
     * @Route("/{nie}", name="alumno_update")
     * @Method("PUT")
     * @Template("RegistroAcademicoBundle:Alumno:edit.html.twig")
     */
    public function updateAction(Request $request, $nie)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:Alumno')->find($nie);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }

        $editForm = $this->createForm(new AlumnoType(), $entity);
        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('alumno_show', array('nie' => $nie)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'title'       => 'Modificar alumno'
        );
    }

    /**
     * Deletes a Alumno entity.
     * 
     * @Route("/{nie}/del", name="alumno_erase")
     * @Method("GET")
     */
    public function eraseAction($nie)
    {
        $em = $this->getDoctrine()->getManager();
        $alumno = $em->getRepository('RegistroAcademicoBundle:Alumno')->find($nie);
        if (!$alumno) {
            throw $this->createNotFoundException('Unable to find Alumno entity.');
        }
        $em->remove($alumno);
        $em->flush();
        return $this->redirect($this->generateUrl('alumno_index'));
    }
}
