<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
use INTI\RegistroAcademicoBundle\Form\AlumnoType;
use Symfony\Component\HttpFoundation\Response;

/**
 * alumnoAjax controller.
 *
 * @Route("/BuscarAspiranteEspecifico")
 */

class BuscarAspiranteEspecificoAjax extends Controller
{
	/**
     * Buscar un aspirante dado.
     *
     * @Route("/", name="BuscarAspiranteEspecificoAjax")
     * @Method("GET")
     */
    function searchAspirante()
    {
		$dql="SELECT p FROM RegistroAcademicoBundle:Aspirante p WHERE p.nie=:nie";
		$em = $this->getDoctrine()->getManager();
		$query=$em->createQuery($dql)->setParameter("nie", $_REQUEST['nie']);
		$text="";
		try{
			$aspirante = $query->getSingleResult();
			$text=$aspirante->getNombres()." ".$aspirante->getPrimerapellido()." ".$aspirante->getSegundoapellido();
			switch(strtolower($aspirante->getEstado())){
				case 'r':
					$text="<span style='color:#f00'>".$text." esta reprobado</span>";
				break;
				case 'p':
					$text="<span style='color:#f00'>".$text." esta pendiente de aprobacion</span>";
				break;
				case 'm':
					$text="<span style='color:#f00'>".$text." ya esta matriculado</span>";
				break;
			}
		} catch (\Doctrine\Orm\NoResultException $e) {
			$text = "No se ha seleccionado ningun aspirante valido";
		}	
        return new response($text);
    }
}