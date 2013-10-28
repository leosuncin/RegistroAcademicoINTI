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
 * GuardarAlumno controller for ajax.
 *
 * @Route("/GuardarAlumno")
 */
class GuardarAlumnoAjax extends Controller
{
    /**
     * Creates a new Alumno entity.
     *
     * @Route("/", name="GuardarAlumnoAjax")
     * @Method("GET")
     */
    function crearAlumno()
    {
		$dql="SELECT p FROM RegistroAcademicoBundle:Aspirante p WHERE p.id=:id";
		$em = $this->getDoctrine()->getManager();
		$query=$em->createQuery($dql)->setParameter("id", $_REQUEST['nAspirante'])->setMaxResults(1);
		try{
			$aspirante = $query->getSingleResult();
			if($aspirante->getEstado()=="A"){
				$entity  = new Alumno();
				$entity->setNie($_REQUEST['nie']);
				$entity->setCondicion($_REQUEST['cond']);
				
				$aspirante->setEstado('M');
				
				$entity->setAspirante($aspirante);

				$em->persist($entity->getAspirante());
				$em->persist($entity);

				$em->flush();

				return new response($this->generateUrl('alumno_show', array('nie' => $entity->getNie())));
			}else{
				return new response($aspirante->getEstado());
			}
		} catch (\Doctrine\Orm\NoResultException $e) {
			return new response("N");
		}
    }
}
