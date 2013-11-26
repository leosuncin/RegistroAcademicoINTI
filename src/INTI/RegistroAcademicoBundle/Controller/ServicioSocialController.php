<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\ServicioSocial;
use INTI\RegistroAcademicoBundle\Entity\Proyecto;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
use INTI\RegistroAcademicoBundle\Entity\EncargadoProyecto;
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
            'entities' => $entities
            
        );
    }

	/*asignación de servicio social*/
	/**
     * Muestra el formulario de el servicio social.
     *
     * @Route("/asignar", name="asignarserviciosocial")
     * @Method("GET")
     * @Template("RegistroAcademicoBundle:ServicioSocial:asn.html.twig")
     */
    public function asignarAction()
    {
        $em = $this->getDoctrine()->getManager();
		$entities = $em->
			getRepository('RegistroAcademicoBundle:ServicioSocial')->findAll();
		$espec = $em->getRepository('RegistroAcademicoBundle:Especialidad')
			->findAll();
		$codespec=$em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')
			->findAll();
		$query=$em->createQuery('
			SELECT DISTINCT p.nombre,p.id,e.id,e.nombre 
			FROM RegistroAcademicoBundle:Proyecto p
			JOIN p.encargado e 
			WHERE e.rol = \'EI\'
		');
		$encargados = $query->getResult();
		$query=$em->createQuery('
			SELECT DISTINCT p.nombre,p.id,p.descripcion,e.id as idencargado,
			e.nombre as nomencargado
		   	FROM RegistroAcademicoBundle:Proyecto p
			JOIN p.encargado e 
			WHERE e.rol = \'EI\'
		');
		$proyint = $query->getResult();
        return array(
            'entities'		 => $entities,
			'especialidades' => $espec,
			'codespec'		 => $codespec,
			'proyint'		 => $proyint
        );
    }

	/*fin asignación de servicio social */


	/**
	 * Consultar alumnos en base a seccion
	 * y en base a anho 
	 **/
	 /**
     * @Route("/qalumn", name="consultar_alumnos")
     * @Method("POST")
     */
    public function consultarAlumnoAction(Request $request)
    {
		$alumno = new Alumno();
		$postData=$request->request->all();
		$alnie=$postData["alnie"];
		if(empty($alnie))
		{
		$respuesta = new JsonResponse(json_encode(
			array(
			'error'=>'nodato'
			)));
		$respuesta->headers->
			set("Content-Type", "application/json; charset=UTF-8");
		return $respuesta;
			
		}
		
        $em = $this->getDoctrine()->getManager();
		$query=$em->createQuery('
			SELECT a
			FROM RegistroAcademicoBundle:Alumno a
			WHERE a.nie = :nie
		');
		$query->setParameter(':nie',$alnie);
		try{
		$alumno = $query->getSingleResult();
		} catch (\Doctrine\Orm\NoResultException $e){
		$respuesta = new JsonResponse(json_encode(
			array(
			'error'=>'noencontrada'
			)));
		$respuesta->headers->
			set("Content-Type", "application/json; charset=UTF-8");
		return $respuesta;
		}
		$respuesta = new JsonResponse(json_encode(
			array(
			'nie'=>$alumno->getNie(),
			'apellido'=>$alumno->getPrimerapellido(),
			'apellido2'=>$alumno->getSegundoapellido(),
			'nombres'=>$alumno->getNombres(),
			'espe'=>$alumno->getCodigoEspecialidad()->getEspecialidad()->getNombre(),
			'anho'=>$alumno->getCodigoEspecialidad()->getAnho(),
			'seccion'=>$alumno->getCodigoEspecialidad()->getSeccion()
			)));
		$respuesta->headers->
			set("Content-Type", "application/json; charset=UTF-8");
		return $respuesta;
    }
	
	/**
	 * FinConsultar alumnos en base a seccion
	 * y en base a anho 
	 **/

	/**
	 * Asignar Servicio Social a Alumno
	 **/
	 /**
     * @Route("/asignarAl", name="realizar_asignacion")
     * @Method("POST")
     */
    public function asignarAlAction(Request $request)
    {
		$alumno = new Alumno();
		$proyecto = new Proyecto();
		$encargado = new EncargadoProyecto();
		$ss=new ServicioSocial();
        $em = $this->getDoctrine()->getManager();
		$postData=$request->request->all();
		$alnie=$postData["alnie"];
		$lugar=$postData["lugar"];
		if(strcmp($lugar,"in")==0)	
		{
			$query=$em->createQuery('
			SELECT en
			FROM RegistroAcademicoBundle:EncargadoProyecto en
			WHERE en.id = :idenc
				');
			$query->setParameter(':idenc',$postData["idencproy"]);
			$encargado=$query->getSingleResult();

			$query=$em->createQuery('
			SELECT en
			FROM RegistroAcademicoBundle:Alumno en
			WHERE en.nie = :alumno
				');
			$query->setParameter(':alumno',$postData["alnie"]);
			
			$alumno=$query->getSingleResult();

			$ss->setHorasRealizadas(0);
			$ss->setAlumno($alumno);
			$proyecto->setNombre($postData["lproy"]);
			$proyecto->setDescripcion($postData["iproy"]);
			$proyecto->setEncargado($encargado);
			$proyecto->setServicioSocial($ss);
            $em->persist($ss);
            $em->persist($proyecto);
			$em->flush();
		}
		else
		{
			$query=$em->createQuery('
			SELECT en
			FROM RegistroAcademicoBundle:Alumno en
			WHERE en.nie = :alumno
				');
			$query->setParameter(':alumno',$postData["alnie"]);
			$alumno=$query->getSingleResult();
			$encargado->setNombre($postData["encargado"]);
			$encargado->setRol("EX");
			$em->persist($encargado);
			$ss->setHorasRealizadas(0);
			$ss->setAlumno($alumno);
			$em->persist($ss);
			$proyecto->setNombre($postData["nproy"]);
			$proyecto->setDescripcion($postData["dproy"]);
			$proyecto->setEncargado($encargado);
			$proyecto->setServicioSocial($ss);
			$em->persist($proyecto);
			$em->flush();
		}

        $em = $this->getDoctrine()->getManager();
		$query=$em->createQuery('
			SELECT a
			FROM RegistroAcademicoBundle:Alumno a
			WHERE a.nie = :nie
		');
		$query->setParameter(':nie',$alnie);
		$alumno = $query->getSingleResult();
		$respuesta = new JsonResponse(json_encode(
			array(
			'exito'=>'exito',
			)));
		$respuesta->headers->
			set("Content-Type", "application/json; charset=UTF-8");
		return $respuesta;
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
