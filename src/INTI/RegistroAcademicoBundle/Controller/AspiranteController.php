<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
use INTI\RegistroAcademicoBundle\Form\AspiranteType;

/**
 * Aspirante controller.
 *
 * @Route("/aspirante")
 */
class AspiranteController extends Controller
{

	/**
	 * Lists all Aspirante entities.
	 *
	 * @Route("/", name="aspirante_index")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();

		$aspirantes = $em->getRepository('RegistroAcademicoBundle:Aspirante')->findAll();

		return array(
			'aspirantes' => $aspirantes,
			'title'    => 'Consultar aspirantes'
		);
	}

	/**
	 * Creates a new Aspirante entity.
	 *
	 * @Route("/create", name="aspirante_create")
	 * @Method("POST")
	 * @Template("RegistroAcademicoBundle:Aspirante:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$aspirante  = new Aspirante();
		$form = $this->createForm(new AspiranteType(), $aspirante);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($aspirante->getEspecialidad());
			$em->persist($aspirante->getEncargado());
			$em->persist($aspirante);
			$em->flush();

			return $this->redirect($this->generateUrl('aspirante_show', array('nie' => $aspirante->getNie())));
		}

		return array(
			'aspirante' => $aspirante,
			'form'   => $form->createView(),
			'title'  => 'Añadir un aspirante'
		);
	}

	/**
	 * Displays a form to create a new Aspirante entity.
	 *
	 * @Route("/new", name="aspirante_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$aspirante = new Aspirante();
		$form   = $this->createForm(new AspiranteType(), $aspirante);

		return array(
			'aspirante' => $aspirante,
			'form'   => $form->createView(),
			'title'  => 'Añadir un aspirante'
		);
	}

	/**
	 * Finds and displays a Aspirante entity.
	 *
	 * @Route("/{nie}", name="aspirante_show", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction(Aspirante $aspirante)
	{
		return array(
			'aspirante' => $aspirante,
			'title'  => 'Consultar aspirante'
		);
	}

	/**
	 * Displays a form to edit an existing Aspirante entity.
	 *
	 * @Route("/{nie}/edit", name="aspirante_edit", requirements={"nie"="\d+"})
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction(Aspirante $aspirante)
	{
		$editForm = $this->createForm(new AspiranteType(), $aspirante);

		return array(
			'aspirante'    => $aspirante,
			'edit_form' => $editForm->createView(),
			'title'     => 'Modificar aspirante'
		);
	}

	/**
	 * Edits an existing Aspirante entity.
	 *
	 * @Route("/{nie}/update", name="aspirante_update", requirements={"nie"="\d+"})
	 * @Method("PUT")
	 * @Template("RegistroAcademicoBundle:Aspirante:edit.html.twig")
	 */
	public function updateAction(Request $request, Aspirante $aspirante)
	{
		$em = $this->getDoctrine()->getManager();
		$editForm = $this->createForm(new AspiranteType(), $aspirante);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->persist($aspirante->getEncargado());
			$em->persist($aspirante);
			$em->flush();

			return $this->redirect($this->generateUrl('aspirante_show', array('nie' => $aspirante->getNie())));
		}

		return array(
			'aspirante' => $aspirante,
			'edit_form' => $editForm->createView(),
			'title'     => 'Modificar aspirante'
		);
	}

	/**
	 * Deletes a Aspirante entity.
	 * 
	 * @Route("/{nie}/del", name="aspirante_erase", requirements={"nie"="\d+"})
	 * @Method("GET")
	 */
	public function eraseAction(Aspirante $aspirante)
	{
		$em = $this->getDoctrine()->getManager();
		$em->remove($empleado);
		$em->flush();
		return $this->redirect($this->generateUrl('aspirante_index'));
	}

	/**
     * List Aspirantes Aprobados entities.
     *
     * @Route("/buscarAjax", name="BuscarAspiranteAjax")
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
		$dql="SELECT p FROM RegistroAcademicoBundle:Aspirante p JOIN p.especialidad u WHERE p.estado='A' AND CONCAT(CONCAT(CONCAT(CONCAT(p.nombres,' '),p.primerapellido),' '),p.segundoapellido) LIKE :nombres or p.nie LIKE :nie";
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
					$text.="<td>".$aspirante[$i]->getEspecialidad()->getNombre()."</td>";
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
        return new Response($text);
    }

	/**
     * Buscar un aspirante dado.
     *
     * @Route("/buscar", name="BuscarAspiranteEspecificoAjax")
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
        return new Response($text);
    }
}
