<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
use INTI\RegistroAcademicoBundle\Entity\Usuario;
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
	 * @Route("/create", name="alumno_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Alumno:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$alumno  = new Alumno();
		$form = $this->createForm(new AlumnoType(), $alumno);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$factory  = $this->get('security.encoder_factory');

			$usuario = new Usuario();
			$encoder  = $factory->getEncoder($usuario);
			$usuario->setUsername($alumno->getNie());
			$password = $encoder->encodePassword($alumno->getNie()*2, $usuario->getSalt());
			$usuario->setPassword($password);
			$alumno->setUsuario($usuario);

			$em->persist($alumno->getAspirante());
			$em->persist($alumno->getUsuario());
			$em->persist($alumno);
			$em->flush();

			return $this->redirect($this->generateUrl('alumno_show', array('nie' => $alumno->getNie())));
		}

		return array(
			'alumno' => $alumno,
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
	 * @Route("/{nie}", name="alumno_show", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction(Alumno $alumno)
	{
		return array(
			'alumno' => $alumno,
			'title'  => 'Consultar alumno'
		);
	}

	/**
	 * Displays a form to edit an existing Alumno entity.
	 *
	 * @Route("/{nie}/edit", name="alumno_edit", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction(Alumno $alumno)
	{
		$editForm = $this->createForm(new AlumnoType(), $alumno);

		return array(
			'alumno'    => $alumno,
			'edit_form' => $editForm->createView(),
			'title'     => 'Modificar alumno'
		);
	}

	/**
	 * Edits an existing Alumno entity.
	 *
	 * @Route("/{nie}/update", name="alumno_update", requirements={"nie"="\d+"})
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:Alumno:edit.html.twig")
	 */
	public function updateAction(Request $request, Alumno $alumno)
	{
		$em = $this->getDoctrine()->getManager();

		$editForm = $this->createForm(new AlumnoType(), $alumno);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->persist($alumno);
			$em->flush();

			return $this->redirect($this->generateUrl('alumno_show', array('nie' => $nie)));
		}

		return array(
			'alumno'      => $alumno,
			'edit_form'   => $editForm->createView(),
			'title'       => 'Modificar alumno'
		);
	}

	/**
	 * Deletes a Alumo entity.
	 *
	 * @Route("/{nie}/del", name="alumno_erase")
	 * @Method("DELETE")
	 */
	public function deleteAction($nie)
	{
		$em = $this->getDoctrine()->getManager();

		$aspirante = $em->getRepository('RegistroAcademicoBundle:Alumno')->find($nie);

		if (!$aspirante) {
			throw $this->createNotFoundException('Unable to find Alumno entity.');
		}

		$em->remove($aspirante);
		$em->flush();
		return $this->redirect($this->generateUrl('alumno_index'));
	}

	/**
	 * Creates a new Alumno entity.
	 *
	 * @Route("/GuardarAlumno", name="GuardarAlumnoAjax")
	 * @Method("GET")
	 */
	function crearAlumno()
	{
		set_time_limit(0);
		$dql="SELECT p FROM RegistroAcademicoBundle:Aspirante p WHERE p.nie=:nie";
		$em = $this->getDoctrine()->getManager();
		$query=$em->createQuery($dql)->setParameter("nie", $_REQUEST['nie'])->setMaxResults(1);
		try{
				$aspirante = $query->getSingleResult();
				$alumno = $em->getRepository('RegistroAcademicoBundle:Alumno')->find($_REQUEST['nie']);
				if (!$alumno) {
					$user = $em->getRepository('RegistroAcademicoBundle:Usuario')->find($_REQUEST['username']);
					if(!$user){
						$dql2="SELECT p FROM RegistroAcademicoBundle:CodigoEspecialidad p WHERE p.codigo=:codigo";
						$query2=$em->createQuery($dql2)->setParameter("codigo", $_REQUEST['cod_esp'])->setMaxResults(1);
						$codigoEspecialidad = $query2->getSingleResult();
						$usuario = new Usuario();
						$usuario->setUsername($_REQUEST['username']);
						$usuario->setPassword($_REQUEST['password']);
						$factory  = $this->get('security.encoder_factory');
						$encoder  = $factory->getEncoder($usuario);
						$password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
						$usuario->setPassword($password);
						$usuario->addRole("ROLE_USER");
						
						$entity = new Alumno();
						$entity->setCondicion($_REQUEST['cond']);
						$entity->setNie($aspirante);
						$entity->setUsuario($usuario);
						$entity->setCodigoEspecialidad($codigoEspecialidad);
						$em->persist($entity->getUsuario());
						$em->persist($entity);
						$em->flush();
						
						return new Response($this->generateUrl('alumno_show', array('nie' => $entity->getNie()->getNie())));
					}else
						return new Response("U");
				}else
					return new Response("M");
		} catch (\Doctrine\Orm\NoResultException $e) {
			return new Response("N");
		}
	}

	/**
	 * Genera tabla de index.
	 *
	 * @Route("/ajax", name="IndexAlumnoAjax")
	 * @Method("GET")
	 */
	function generateTableAction()
	{
		/*
			Parametros:
			order_field, sence, n_result, search_field, search, actual, anterior, especialidad
		*/
		$entity='Alumno';
		$nombre_campos=Array("NIE", "Nombre", "Especialidad", "Acciones");
		$order_field=$_REQUEST['order_field'];
		$especialidad=$_REQUEST['especialidad'];
		$sence=strtolower($_REQUEST['sence']);
		$campos=Array("p.nie ".$sence, "p.primerApellido ".$sence.", p.segundoApellido ".$sence.", p.nombres ".$sence, "n.nombre ".$sence);
		$n_result=$_REQUEST['n_result'];
		$parameters=Array();
		$cEspecialidad="";
		if(($especialidad!="todas")&&($especialidad!="")){
			$cEspecialidad.=" where n.codigo=:codigo";
			$parameters['codigo']=$especialidad;
		}
		$condicion="";
		if(isset($_REQUEST['search']))
		if($_REQUEST['search']!=""){
			if($cEspecialidad=="")	
				$condicion.=" where ";
			else
				$condicion.=" and ";
			$search=$_REQUEST['search'];
			$condicion.="CONCAT(CONCAT(CONCAT(CONCAT(p.primerApellido,' '),p.segundoApellido),' '),p.nombres) like :search or p.nie like :search2";
			$parameters['search']='%'.$search.'%';
			$parameters['search2']=$search.'%';
		}
		$dql="SELECT COUNT(p) FROM RegistroAcademicoBundle:Alumno p JOIN p.especialidad n".$cEspecialidad.$condicion;
		$em = $this->getDoctrine()->getManager();
		$query=$em->createQuery($dql);
		if(isset($_REQUEST['search']))
		if(($_REQUEST['search']!="")||($cEspecialidad!=""))
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

		$query="select p, n from RegistroAcademicoBundle:Alumno p JOIN p.especialidad n".$cEspecialidad.$condicion;
		$query.=" order by ".$campos[$order_field];

		//$text.= $query;
		$resultado=$em->createQuery($query);
		
		if(isset($_REQUEST['search']))
		if(($_REQUEST['search']!="")||($cEspecialidad!=""))
			$resultado->setParameters($parameters);
			
		$resultado->setMaxResults($n_result)->setFirstResult($init);
		$result=$resultado->getResult();
		
		$text= "<table class='table table-hover'>\n<tr class='header'>";
		for($i=0;$i<count($campos);$i++){
			if($i==$order_field){
				if($sence=="asc"){
					$text.= "<th class='".$i."'>".$nombre_campos[$i]." <i class='icon-chevron-up icon-white'></i></th>";
				}else{
					$text.= "<th class='".$i."'>".$nombre_campos[$i]." <i class='icon-chevron-down icon-white'></i></th>";
				}
			}else{
				$text.= "<th class='".$i."'>".$nombre_campos[$i]."</th>";
			}
		}
		$text.= "<th class='control'></th></tr>\n";
		if($result!=false){
			for($i=0;$i<count($result);$i++){
				$text.= "<tr>";
				$text.= "<td>".$result[$i]->getNie()."</td>";
				$text.= "<td>".$result[$i]->getPrimerapellido()." ".$result[$i]->getSegundoapellido().", ".$result[$i]->getNombres()."</td>";
				$text.= "<td>".$result[$i]->getEspecialidad()->getNombre()."</td>";
				$text.='<td><div class="btn-group btn-group-horizontal">';
				$text.="<a class='btn btn-info' href='../alumno/".$result[$i]->getNie()."'><span class='icon-eye-open icon-white'></span></a>";
                $text.="<a class='btn btn-info' href='../alumno/".$result[$i]->getNie()."/edit'><span class='icon-edit icon-white'></span></a></div></td></tr>";
			}
		}else{
			$text.="<tr><td colspan='4'>No hay alumnos que concuerden con la busqueda</td></tr>";
		}
		$text.= "</table>";
		//$text.= $query;
		
		//Generating the pager for the table
		$text.= "<table class='pager' id='paginador' style='width:95%'><tr>";
		$text.= "<td style='text-align:left'>Total: ".$n_filas." resultados.</td>";
		if($n_filas==0) $actual=0;
		$text.= "<td style='text-align:right'>Pagina ".$actual." de ".$n_paginas."  ";
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
		$text.= "</td></tr></table>";
		return new Response($text);
	}
}
