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
 * @Route("/ajax")
 */

class AspiranteForAjax extends Controller
{
	/**
     * Lists Aspirantes seleccionados entities.
     *
     * @Route("/", name="aspiranteAjax")
     * @Method("GET")
     */
    function listAspiranteSelect()
    {
		$search=$_REQUEST['searchValue'];
		$parameters=Array(
				'nombres'=>"%".$search."%",
				'id'=>$search."%",
			);
        $em = $this->getDoctrine()->getManager();
		$dql="SELECT p FROM RegistroAcademicoBundle:Aspirante p WHERE p.estado='A' AND CONCAT(CONCAT(CONCAT(CONCAT(p.nombres,' '),p.primerapellido),' '),p.segundoapellido) LIKE :nombres or p.id LIKE :id";
		if($_REQUEST['esp']!="todas"){
			$parameters['especialidad']=$_REQUEST['esp'];
			$dql.=" AND p.especialidad = :especialidad";
		}
		if($_REQUEST['anho']!=""){
			$parameters['especialidad']=$_REQUEST['esp'];
			$dql.=" AND p.especialidad=:especialidad";
		}
		$query=$em->createQuery($dql)
			->setParameters($parameters);
		try{
			$aspirante = $query->getResult();
			$text="<br><table class='table table-hover'>";
			$text.="<tr class='header'><th>N° Aspirante</th><th>Nombre Completo</th><th>Especialidad</th><th>Opciones</th></tr>";
			if(count($aspirante)>0){
				for($i=0;$i<count($aspirante) and $i<10;$i++){
					$text.="<tr class='aspirante'><td class='n_asp' value='".$aspirante[$i]->getId()."'>".str_ireplace($search, '<span style="color:#00f">'.$search.'</span>', $aspirante[$i]->getId())."</td>";
					$text.="<td>".str_ireplace($search, '<span style="color:#00f">'.$search.'</span>', $aspirante[$i]->getNombres()." ".$aspirante[$i]->getPrimerapellido()." ".$aspirante[$i]->getSegundoapellido())."</td>";
					$text.="<td>".$aspirante[$i]->getEspecialidad()->getNombre()."</td>";
					$text.='<td><div class="btn-group btn-group-horizontal">';
					$text.="<a class='btn btn-info' href='../aspirante/".$aspirante[$i]->getId()."'><span class='icon-eye-open icon-white'></span></a>";
                    $text.="<a class='btn btn-info' href='../aspirante/".$aspirante[$i]->getId()."/edit'><span class='icon-edit icon-white'></span></a></div></td></tr>";
				}
			}else{
				$text.="<tr><td colspan='4'>No se encuentra el aspirante</td></tr>";
			}
			$text.="</table>";
		} catch (\Doctrine\Orm\NoResultException $e) {
			$text = "<table class='table table-hover'><tr><td>No se encuentra el aspirante</td></tr></table>";
		}	
        return new response($text);
    }
}