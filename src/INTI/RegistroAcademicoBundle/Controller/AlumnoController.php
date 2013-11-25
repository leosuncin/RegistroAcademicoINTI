<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
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
	 * @Route("/", name="alumno_index", options={"expose"=true})
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$request = $this->getRequest();

		if($request->isXmlHttpRequest()) {
			$apellidos = $request->query->get('apellidos');
			$codigo = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->find($request->query->get('codigo', ''));
			$entities = $em->getRepository('RegistroAcademicoBundle:Alumno')->findByApellidos($apellidos.'%', $codigo);
			return $this->render(
				'RegistroAcademicoBundle:Alumno:indexAjax.html.twig',
				array(
					'entities' => $entities
				));;
		} else {
			$entities = $em->getRepository('RegistroAcademicoBundle:Alumno')->findAll();
			$especialidades = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
			return array(
				'entities' => $entities,
				'especialidades' => $especialidades,
				'title'    => 'Consultar alumnos'
			);
		}
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

			$encargado = $em->getRepository('RegistroAcademicoBundle:Encargado')->find($alumno->getEncargado()->getDui());
			if($encargado != null)
				$alumno->setEncargado($encargado);

			$em->persist($usuario);
			$em->persist($alumno);
			$em->flush();

			return $this->redirect($this->generateUrl('alumno_show', array('nie' => $alumno->getNie())));
		}

		return array(
			'alumno'    => $alumno,
			'aspirante' => $aspirante->getNie(),
			'form'      => $form->createView(),
			'title'     => 'Añadir un alumno'
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
		//$especialidades = $em->getRepository('RegistroAcademicoBundle:Especialidad')->findAll();
		//$codigoespecialidades = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
		
		return array(
			'entity' => $entity,
			//'especialidades' => $especialidades,
			//'codigoespecialidades' => $codigoespecialidades,
			'form'   => $form->createView(),
			'title'  => 'Añadir un alumno'
		);
	}

	/**
	 * Displays a form to create a new Alumno entity.
	 *
	 * @Route("/{aspirante}/inscribir", name="alumno_inscribir")
	 * @ParamConverter("aspirante", class="RegistroAcademicoBundle:Aspirante", options={"nie" = "aspirante"})
	 * @Method("GET")
	 * @Template()
	 */
	public function inscribirAction(Aspirante $aspirante)
	{
		$entity = new Alumno($aspirante);
		$form   = $this->createForm(new AlumnoType(), $entity);

		$em = $this->getDoctrine()->getManager();
		
		return array(
			'entity'    => $entity,
			'aspirante' => $aspirante->getNie(),
			'form'      => $form->createView(),
			'title'     => 'Añadir un alumno'
		);
	}

	/**
	 * Creates a new Alumno entity.
	 *
	 * @Route("/{aspirante}/matricular", name="alumno_matricular")
	 * @ParamConverter("aspirante", class="RegistroAcademicoBundle:Aspirante", options={"nie" = "aspirante"})
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Alumno:inscribir.html.twig")
	 */
	public function matricularAction(Request $request)
	{
		$alumno = new Alumno();
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

			$encargado = $em->getRepository('RegistroAcademicoBundle:Encargado')->find($alumno->getEncargado()->getDui());
			if($encargado != null)
				$alumno->setEncargado($encargado);

			$em->persist($usuario);
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
	 * Finds and displays a Alumno entity.
	 *
	 * @Route("/{nie}", name="alumno_show", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction(Alumno $entity)
	{
		return array(
			'entity' => $entity,
			'notas'  => $this->getDoctrine()->getManager()->getRepository('RegistroAcademicoBundle:Nota')->findByAlumno($entity),
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
	public function editAction(Alumno $entity)
	{
		$editForm = $this->createForm(new AlumnoType(), $entity);

		return array(
			'entity'    => $entity,
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
		$campos=Array("u.nie","u.primerapellido","u.segundoapellido","u.nombres", "n.nombre", "");
		$nombre_campos=Array("NIE", "Primer Apellido", "Segundo Apellido", "Nombres", "Especialidad", "Acciones");
		$order_field=$_REQUEST['order_field'];
		$especialidad=$_REQUEST['especialidad'];
		$sence=strtolower($_REQUEST['sence']);
		$n_result=$_REQUEST['n_result'];
		$parameters=Array();
		$condicion="";
		if(isset($_REQUEST['search']))
		if($_REQUEST['search']!=""){
			$search=$_REQUEST['search'];
			$condicion=" where CONCAT(CONCAT(CONCAT(CONCAT(u.nombres,' '),u.primerapellido),' '),u.segundoapellido) like :search or u.nie like :search2";
			$parameters['search']='%'.$search.'%';
			$parameters['search2']=$search.'%';
		}
		$cEspecialidad="";
		if(($especialidad!="todas")&&($especialidad!="")){
			if($condicion=="")	
				$cEspecialidad.=" where ";
			else
				$cEspecialidad.=" and ";
			$cEspecialidad.="n.codigo=:codigo";
			$parameters['codigo']=$especialidad;
		}
		$dql="SELECT COUNT(p) FROM RegistroAcademicoBundle:Alumno p JOIN p.nie u JOIN u.especialidad n".$condicion.$cEspecialidad;
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

		$query="select p, u from RegistroAcademicoBundle:Alumno p JOIN p.nie u JOIN u.especialidad n".$condicion.$cEspecialidad;
		if(($order_field!="")&&($sence!=""))
			$query.=" order by ".$order_field." ".$sence;

		//$text.= $query;
		$resultado=$em->createQuery($query);
		
		if(isset($_REQUEST['search']))
		if(($_REQUEST['search']!="")||($cEspecialidad!=""))
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
				$text.= "<td>".$result[$i]->getNie()->getEspecialidad()->getNombre()."</td>";
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
		return new Response($text);
	}
}
