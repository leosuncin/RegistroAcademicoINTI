<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use INTI\RegistroAcademicoBundle\Entity\Especialidad;
use INTI\RegistroAcademicoBundle\Form\EspecialidadType;
use Symfony\Component\HttpFoundation\Response;

/**
 * EspecialidadForAjax controller.
 *
 * @Route("/ComboEspecialidad")
 */
class ComboEspecialidadAjax extends Controller
{
    /**
     * Lists all Especialidad entities.
     *
     * @Route("/", name="ComboEspecialidadAjax")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('RegistroAcademicoBundle:Especialidad')->findAll();
		$text="<option value='todas'>Todas</option>";
		for($i=0;$i<count($entities);$i++){
			$text.="<option value='".$entities[$i]->getCodigo()."'>".$entities[$i]->getNombre()."</option>";
		}
        return new response($text);
    }
}
