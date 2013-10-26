<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
use INTI\RegistroAcademicoBundle\Form\AlumnoType;


/**
 * Alumno controller for ajax.
 *
 * @Route("/alumnoAjaxs")
 */
class AlumnoForAjax extends Controller
{
    /**
     * Creates a new Alumno entity.
     *
     * @Route("/", name="alumnoInsertAjax")
     * @Method("GET")
     */
    function crearAlumno()
    {
		$em = $this->getDoctrine()->getManager();
        $aspirante = $em->getRepository('RegistroAcademicoBundle:Aspirante')->find($_REQUEST['nAspirante']);
		
		$entity  = new Alumno();
		$entity->setNie($_REQUEST['nie']);
		$entity->setCondicion($_REQUEST['cond']);
		
		$aspirante->setEstado('M');
		
		$entity->setAspirante($aspirante);

		$em->persist($entity->getAspirante());
        $em->persist($entity);

        $em->flush();

        return new response($this->generateUrl('alumno_show', array('nie' => $entity->getNie())));
    }
}
