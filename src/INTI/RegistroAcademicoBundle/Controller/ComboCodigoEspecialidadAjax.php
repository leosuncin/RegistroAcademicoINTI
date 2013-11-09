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
 * @Route("/ComboCodigoEspecialidad")
 */
class ComboCodigoEspecialidadAjax extends Controller
{
    /**
     * Lists all CodigoEspecialidad entities.
     *
     * @Route("/", name="ComboCodigoEspecialidadAjax")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findAll();
		$text="";
		for($i=0;$i<count($entities);$i++){
			$text.="<option value='".$entities[$i]->getCodigo()."'>".$entities[$i]->getCodigo()."</option>";
		}
        return new response($text);
    }
}
