<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
use INTI\RegistroAcademicoBundle\Entity\Encargado;
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
	 * @Route("/", name="aspirante_index", options={"expose"=true})
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$request = $this->getRequest();

		if($request->isXmlHttpRequest()) {
			$aspirantes = $em->getRepository('RegistroAcademicoBundle:Aspirante')
                                ->findByApellidos($request->query->get('apellido').'%');
			return $this->render(
				'RegistroAcademicoBundle:Aspirante:indexAjax.html.twig',
				array(
					'aspirantes' => $aspirantes
				));
		} else {
			$aspirantes = $em->getRepository('RegistroAcademicoBundle:Aspirante')->findAll();
			return array(
				'aspirantes' => $aspirantes,
				'title'      => 'Consultar aspirantes'
			);
		}
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
			$encargado_exist = $em->getRepository('RegistroAcademicoBundle:Encargado')->find($aspirante->getEncargado()->getDui());
			if($encargado_exist)
				$aspirante->setEncargado($encargado_exist);
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
	 * Muestra todos los DUI que concuerdan con el patrón
	 * 
	 * @Route("/encargado", name="encargado_index", options={"expose"=true})
	 */
	public function encargadoIndexAction($dui)
	{
		$serializer = $this->get("jms_serializer");
        $request = $this->getRequest();
        if($request->isXmlHttpRequest())
            $duis = $this->getDoctrine()
                ->getRepository('RegistroAcademicoBundle:Encargado')
                ->getDUIs($dui);
        else
            $duis = $this->getDoctrine()
                ->getRepository('RegistroAcademicoBundle:Encargado')
                ->getAllDUI($dui);
		return new Response($serializer->serialize($duis, 'json'), 200, array("Content-Type" => "application/json; charset=UTF-8"));
	}

	/**
	 * Return Encargado Aspirante
	 *
	 * @Route("/encargado/{dui}", name="encargado_show", requirements={"dui"="\d{8}-\d"}, options={"expose"=true})
	 * @Method("GET")
	 */
	public function encargadoShowAction(Encargado $encargado)
	{
		$serializer = $this->get("jms_serializer");
		return new Response($serializer->serialize($encargado, 'json'), 200, array("Content-Type" => "application/json; charset=UTF-8"));
	}

    /**
     * List Aspirantes Aprobados entities.
     *
     * @Route("/buscarAjax", name="BuscarAspiranteAjax")
     * @Method("GET")
     */
    function listAspiranteSelectAction() {
        $search = $_REQUEST['searchValue'];
        $parameters = Array(
            'nombres' => "%" . $search . "%",
            'nie' => $search . "%",
        );
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT p FROM RegistroAcademicoBundle:Aspirante p JOIN p.especialidad u WHERE CONCAT(CONCAT(CONCAT(CONCAT(p.nombres,' '),p.primerApellido),' '),p.segundoApellido) LIKE :nombres or p.nie LIKE :nie";
        if (($_REQUEST['esp'] != "todas") && ($_REQUEST['esp'] != "")) {
            $parameters['especialidad'] = $_REQUEST['esp'];
            $dql.=" AND u.codigo=:especialidad";
        }
        $query = $em->createQuery($dql)->setParameters($parameters);
        try {
            $aspirante = $query->getResult();
            $text = "<br><table class='table table-hover'>";
            $text.="<tr class='header'><th>NIE</th><th>Nombre Completo</th><th>Especialidad</th><th>Opciones</th></tr>";
            if (count($aspirante) > 0) {
                for ($i = 0; $i < count($aspirante) and $i < 10; $i++) {
                    $text.="<tr class='aspirante'><td class='n_nie' value='" . $aspirante[$i]->getNie() . "'>" . str_ireplace($search, '<span style="color:#00f">' . $search . '</span>', $aspirante[$i]->getNie()) . "</td>";
                    $text.="<td class='aspName'>" . str_ireplace($search, '<span style="color:#00f">' . $search . '</span>', $aspirante[$i]->getNombres() . " " . $aspirante[$i]->getPrimerapellido() . " " . $aspirante[$i]->getSegundoapellido()) . "</td>";
                    $text.="<td>" . $aspirante[$i]->getEspecialidad()->getNombre();
                    $text.="<input type='hidden' class='uH' value='" . substr(strtoupper($aspirante[$i]->getPrimerapellido()), 0, 1) . substr(strtolower($aspirante[$i]->getSegundoapellido()), 0, 1) . $aspirante[$i]->getNie() . "'>";
                    $text.="<input type='hidden' class='pH' value='" . substr(md5($aspirante[$i]->getNie()), 0, 8) . "'></td>";
                    $text.='<td><div class="btn-group btn-group-horizontal">';
                    $text.="<a class='btn btn-info' href='../aspirante/" . $aspirante[$i]->getNie() . "'><span class='icon-eye-open icon-white'></span></a>";
                    $text.="<a class='btn btn-info' href='../aspirante/" . $aspirante[$i]->getNie() . "/edit'><span class='icon-edit icon-white'></span></a></div></td></tr>";
                }
            } else {
                $text.="<tr><td colspan='4'>No se encuentran aspirantes que coincidan con el criterio de busqueda</td></tr>";
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
    function searchAspiranteAction() {
        $dql = "SELECT p FROM RegistroAcademicoBundle:Aspirante p WHERE p.nie=:nie";
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql)->setParameter("nie", $_REQUEST['nie']);
        $text = "";
        try {
            $aspirante = $query->getSingleResult();
            $text = $aspirante->getNombres() . " " . $aspirante->getPrimerapellido() . " " . $aspirante->getSegundoapellido();
            $text.="<input type='hidden' id='userNameH' value='" . substr(strtoupper($aspirante->getPrimerapellido()), 0, 1) . substr(strtolower($aspirante->getSegundoapellido()), 0, 1) . $aspirante->getNie() . "'>";
            $text.="<input type='hidden' id='passwordH' value='" . substr(md5($aspirante->getNie()), 0, 8) . "'>";
        } catch (\Doctrine\Orm\NoResultException $e) {
            $text = "No se ha seleccionado ningun aspirante valido";
        }
        return new Response($text);
    }
}
