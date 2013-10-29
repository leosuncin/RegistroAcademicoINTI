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
 * @Route("/IndexAlumno")
 */

class IndexAlumnoAjax extends Controller
{
	/**
     * Genera tabla de index.
     *
     * @Route("/", name="IndexAlumnoAjax")
     * @Method("GET")
     */
    function generateTable()
    {
		/*
			Parametros:
			order_field, sence, n_result, search_field, search, actual, anterior
		*/
		$entity='Alumno';
		$campos=Array("u.nie","u.primerapellido","u.segundoapellido","u.nombres", "");
		$nombre_campos=Array("NIE", "Primer Apellido", "Segundo Apellido", "Nombres", "Acciones");
		$order_field=$_REQUEST['order_field'];
		$sence=strtolower($_REQUEST['sence']);
		$n_result=$_REQUEST['n_result'];
		$parameters=Array();
		$condicion="";
		if(isset($_REQUEST['search']))
		if($_REQUEST['search']!=""){
			$search=$_REQUEST['search'];
			$condicion="where CONCAT(CONCAT(CONCAT(CONCAT(u.nombres,' '),u.primerapellido),' '),u.segundoapellido) like :search or u.nie like :search2";
			$parameters['search']='%'.$search.'%';
			$parameters['search2']=$search.'%';
		}
		$dql="SELECT COUNT(p) FROM RegistroAcademicoBundle:Alumno p JOIN p.nie u ".$condicion;
		$em = $this->getDoctrine()->getManager();
		$query=$em->createQuery($dql);
		if(isset($_REQUEST['search']))
		if($_REQUEST['search']!="")
			$query->setParameters($parameters);
		$n_filas=$query->getSingleScalarResult();
		$n_paginas=ceil($n_filas/$n_result);
		$init=0;
		if(isset($_REQUEST['actual'])){
			$init=$_REQUEST['actual'];
			switch($init){
				case "First":
					$init=0;
					$actual=1;
				break;
				case "Last":
					$init=(($n_paginas-1)*$n_result);
					$actual=$n_paginas;
				break;
				case ">>":
					$init=($_REQUEST['anterior'])*$n_result;
					$actual=$_REQUEST['anterior']+1;
				break;
				case "<<":
					$init=($_REQUEST['anterior']-2)*$n_result;
					$actual=$_REQUEST['anterior']-1;
				break;
				default:
					$actual=$init;
					$init=($init-1)*$n_result;
				break;
			}
		}else	$actual=1;

			$query="select p, u from RegistroAcademicoBundle:Alumno p JOIN p.nie u ";
			if($condicion!="")
				$query.=$condicion;
			if(($order_field!="")&&($sence!=""))
				$query.=" order by ".$order_field." ".$sence;

		//$text.= $query;
		$resultado=$em->createQuery($query);
		
		if(isset($_REQUEST['search']))
		if($_REQUEST['search']!="")
			$resultado->setParameters($parameters);
			
		$resultado->setMaxResults($n_result)->setFirstResult($init);
		$result=$resultado->getResult();
		
		$text= "<table class='table'>\n<tr class='header'>";
		for($i=0;$i<count($campos);$i++){
			if($campos[$i]==$order_field){
				if($sence=="asc"){
					$text.= "<th name='".$campos[$i]."'>".$nombre_campos[$i]." <i class='icon-chevron-up icon-white'></i></th>";
				}else{
					$text.= "<th name='".$campos[$i]."'>".$nombre_campos[$i]." <i class='icon-chevron-down icon-white'></i></th>";
				}
			}else{
				$text.= "<th name='".$campos[$i]."'>".$nombre_campos[$i]."</th>";
			}
		}
		$text.= "<th class='control'></th></tr>\n";
		if($result!=false){
			for($i=0;$i<count($result);$i++){
				$text.= "<tr>";
				$text.= "<td>".$result[$i]->getNie()->getNie()."</td>";
				$text.= "<td>".$result[$i]->getNie()->getPrimerapellido()."</td>";
				$text.= "<td>".$result[$i]->getNie()->getSegundoapellido()."</td>";
				$text.= "<td>".$result[$i]->getNie()->getNombres()."</td>";
				$text.='<td><div class="btn-group btn-group-horizontal">';
				$text.="<a class='btn btn-info' href='../alumno/".$result[$i]->getNie()->getNie()."'><span class='icon-eye-open icon-white'></span></a>";
                $text.="<a class='btn btn-info' href='../alumno/".$result[$i]->getNie()->getNie()."/edit'><span class='icon-edit icon-white'></span></a></div></td></tr>";
			}
		}
		$text.= "</table>";
		//$text.= $query;
		
		//Generating the pager for the table
		$text.= "<div class='pager' id='paginador'>";
		$text.= "<span class='total'>Total: ".$n_filas." results.</span> ";
		if($n_filas==0) $actual=0;
		$text.= "Page ".$actual." of ".$n_paginas."  ";
		if($n_paginas>5){
			if($actual<=3){
				if($actual!=1)
					$text.= '<input type="button" value="<<" class="pag">  ';
				for($i=1;$i<=5;$i++){
					if($i!=$actual)
						$text.= "<input type='button' value='".$i."' class='pag'> ";
					else
						$text.= "<input type='button' value='".$i."' class='actual'>  ";
				}
				$text.= "<input type='button' value='>>' class='pag'>  ";
				$text.= "<input type='button' value='Last' class='pag'>";
			}elseif($actual<=$n_paginas-2){
				$text.= "<input type='button' value='First' class='pag'>  ";
				$text.= '<input type="button" value="<<" class="pag">  ';
				for($i=$actual-2;$i<=$actual+2;$i++){
					if($i!=$actual)
						$text.= "<input type='button' value='".$i."' class='pag'>  ";
					else
						$text.= "<input type='button' value='".$i."' class='actual'>  ";
				}
				$text.= "<input type='button' value='>>' class='pag'>  ";
				$text.= "<input type='button' value='Last' class='pag'>";
			}else{
				$text.= "<input type='button' value='First' class='pag'>  ";
				$text.= '<input type="button" value="<<" class="pag"> ';
				for($i=$n_paginas-4;$i<=$n_paginas;$i++){
					if($i!=$actual)
						$text.= "<input type='button' value='".$i."' class='pag'>  ";
					else
						$text.= "<input type='button' value='".$i."' class='actual'>  ";
				}
				if($actual!=$n_paginas){
					$text.= "<input type='button' value='>>' class='pag'>  ";
				}
			}
		}else{
			for($i=1;$i<=$n_paginas;$i++){
				if($i!=$actual) 
					$text.= "<input type='button' value='".$i."' class='pag'>  ";
				else
					$text.= "<input type='button' value='".$i."' class='actual'>  ";
			}
		}
		$text.= "</div>";
		return new response($text);
	}
}