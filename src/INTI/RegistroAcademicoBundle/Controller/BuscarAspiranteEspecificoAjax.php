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
<<<<<<< HEAD
=======
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
>>>>>>> 6c4a563541d791036fa90d0d2e8bae23908eeeff
			$text.="<input type='hidden' id='userNameH' value='".substr(strtoupper($aspirante->getPrimerapellido()), 0, 1).substr(strtolower($aspirante->getSegundoapellido()), 0, 1).$aspirante->getNie()."'>";
			$text.="<input type='hidden' id='passwordH' value='".substr(md5($aspirante->getNie()), 0, 8)."'>";
		} catch (\Doctrine\Orm\NoResultException $e) {
			$text = "No se ha seleccionado ningun aspirante valido";
		}	
        return new response($text);
    }
}