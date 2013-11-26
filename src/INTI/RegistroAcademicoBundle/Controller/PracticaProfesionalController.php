<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\PracticaProfesional;
use INTI\RegistroAcademicoBundle\Form\PracticaProfesionalType;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
use Doctrine\ORM\Tools\Pagination\Paginator;
use INTI\RegistroAcademicoBundle\Form\AlumnoType;

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
     * List Aspirantes Aprobados entities.
     *
     * @Route("/search1", name="practicaprofesional_search1")
     * @Method("GET")
     */
    function listAlumnoSelect()
    {
        $search=$_REQUEST['searchValue'];
        $parameters=Array(
               'nombres'=>"%".$search."%",
                'nie'=>$search."%",
            );
        $em = $this->getDoctrine()->getManager();
        $dql="SELECT p FROM RegistroAcademicoBundle:PracticaProfesional p JOIN p.alumno u WHERE CONCAT(CONCAT(CONCAT(CONCAT(u.nombres,' '),u.primerApellido),' '),u.segundoApellido) LIKE :nombres or u.nie LIKE :nie";
      

        $query=$em->createQuery($dql)->setParameters($parameters);;
        try{
            $alumno = $query->getResult();
            $text="<br><table class='table table-hover'>";
            $text.="<tr class='header'><th>NIE</th><th>Nombre Completo</th></tr>";
            if(count($alumno)>0){
                for($i=0;$i<count($alumno) and $i<10;$i++){
                    $text.="<tr class='alumno'><td class='n_nie' value='".$alumno[$i]->getAlumno()->getNie()."'>".str_ireplace($search, '<span style="color:#00f">'.$search.'</span>', $alumno[$i]->getAlumno()->getNie())."</td>";
                    $text.="<td class='aspName' value='".$alumno[$i]->getAlumno()->getNombres()." ".$alumno[$i]->getAlumno()->getPrimerapellido()."'>".str_ireplace($search, '<span style="color:#00f">'.$search.'</span>', $alumno[$i]->getAlumno()->getNombres()." ".$alumno[$i]->getAlumno()->getPrimerapellido()." ".$alumno[$i]->getAlumno()->getSegundoapellido())."</td>";
                    $text.="<td class='empresa' value='".$alumno[$i]->getEmpresa()->getNombre()."'></td>";
                    $text.="<td class='direccion' value='".$alumno[$i]->getEmpresa()->getDireccion()."'></td>";
                    $text.="<td class='telefono' value='".$alumno[$i]->getEmpresa()->getTelefono()."'></td>"; 
                    $text.="<td class='id' value='".$alumno[$i]->getId()."'></td>";
                    $text.="<td class='contacto' value='".$alumno[$i]->getEmpresa()->getContacto()."'></td>";
                    $text.='<td><div class="btn-group btn-group-horizontal">';
                   
                }
            }else{
                $text.="<tr><td colspan='4'>No se encuentran alumnos que coincidan con el criterio de busqueda</td></tr>";
            }                             
            $text.="</table>";
        } catch (\Doctrine\Orm\NoResultException $e) {
            $text = "<table class='table table-hover'><tr><td>No se encuentra el alumno</td></tr></table>";
        }   
        return new response($text);
    }

	/**
	 * @Route("/evaluacion", name="practicaprofesional_evaluacion")
	 * @Method("GET")
	 *
	 */
	public function evaluacionAction(){

		$em = $this->getDoctrine()->getManager();

		$entities = $em->getRepository('RegistroAcademicoBundle:PracticaProfesional')->findAll();

		return $this->render('RegistroAcademicoBundle:PracticaProfesional:estadistic.html.twig',array(
		    'entities' => $entities,
		    'title'    => 'Evaluacion practicaprofesional'
		));
	   // return $this->render('RegistroAcademicoBundle:PracticaProfesional:estadistic.html.twig');

	}

    /**
     * Update Empleados Responsabilities entity.
     *
     * @Route("/practicapro", name="practicapro_update")
     * @Method("GET")
     */
    public function updatePracticaProfesional()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RegistroAcademicoBundle:PracticaProfesional')->find($_REQUEST['id']);

        if (!$entity) {
            throw $this->createNotFoundException('No se encontro el alumno seleccionado');
        }

        
        $evaluacion=$_REQUEST['campoNota'];
        
        $entity->setEvaluacion(floatval($evaluacion));
        
        $em->persist($entity);
        $em->flush();

        return new Response($this->generateUrl('practicaprofesional_show', array('id' => $_REQUEST['id'])));
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
        $editForm = $this->createForm(new PracticaProfesionalType(),$entity);
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