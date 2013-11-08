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
 * BuscarAspirante controller.
 *
 * @Route("/BuscarAspirante")
 */

class BuscarAspiranteAjax extends Controller
{
	/**
     * List Aspirantes Aprobados entities.
     *
     * @Route("/", name="BuscarAspiranteAjax")
     * @Method("GET")
     */
    function listAspiranteSelect()
    {
		$search=$_REQUEST['searchValue'];
		$parameters=Array(
				'nombres'=>"%".$search."%",
				'nie'=>$search."%",
			);
        $em = $this->getDoctrine()->getManager();
		$dql="SELECT p FROM RegistroAcademicoBundle:Aspirante p JOIN p.especialidad u WHERE p.estado='A' AND CONCAT(CONCAT(CONCAT(CONCAT(p.nombres,' '),p.primerapellido),' '),p.segundoapellido) LIKE :nombres or p.nie LIKE :nie AND p.estado='A'";
		if(($_REQUEST['esp']!="todas")&&($_REQUEST['esp']!="")){
			$parameters['especialidad']=$_REQUEST['esp'];
			$dql.=" AND u.codigo=:especialidad";
		}
		$query=$em->createQuery($dql)->setParameters($parameters);
		try{
			$aspirante = $query->getResult();
			$text="<br><table class='table table-hover'>";
			$text.="<tr class='header'><th>NIE</th><th>Nombre Completo</th><th>Especialidad</th><th>Opciones</th></tr>";
			if(count($aspirante)>0){
				for($i=0;$i<count($aspirante) and $i<10;$i++){
					$text.="<tr class='aspirante'><td class='n_nie' value='".$aspirante[$i]->getNie()."'>".str_ireplace($search, '<span style="color:#00f">'.$search.'</span>', $aspirante[$i]->getNie())."</td>";
					$text.="<td class='aspName'>".str_ireplace($search, '<span style="color:#00f">'.$search.'</span>', $aspirante[$i]->getNombres()." ".$aspirante[$i]->getPrimerapellido()." ".$aspirante[$i]->getSegundoapellido())."</td>";
					$text.="<td>".$aspirante[$i]->getEspecialidad()->getNombre();
					$text.="<input type='hidden' class='uH' value='".substr(strtoupper($aspirante[$i]->getPrimerapellido()), 0, 1).substr(strtolower($aspirante[$i]->getSegundoapellido()), 0, 1).$aspirante[$i]->getNie()."'>";
					$text.="<input type='hidden' class='pH' value='".substr(md5($aspirante[$i]->getNie()), 0, 8)."'></td>";
					$text.='<td><div class="btn-group btn-group-horizontal">';
					$text.="<a class='btn btn-info' href='../aspirante/".$aspirante[$i]->getNie()."'><span class='icon-eye-open icon-white'></span></a>";
                    $text.="<a class='btn btn-info' href='../aspirante/".$aspirante[$i]->getNie()."/edit'><span class='icon-edit icon-white'></span></a></div></td></tr>";
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