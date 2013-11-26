<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INTI\RegistroAcademicoBundle\Entity\Materia;
use INTI\RegistroAcademicoBundle\Entity\CodigoEspecialidad;

class NotaController extends Controller
{
    /**
     * @Route("/expedientes", name="nota_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $empleado = $em->getRepository('RegistroAcademicoBundle:Empleado')->findByUsuario($this->getUser());
        $codigos = $em->getRepository('RegistroAcademicoBundle:CodigoEspecialidad')->findByResponsable($empleado);
        $materias = $em->getRepository('RegistroAcademicoBundle:Materia')->findAll();
        return array(
            'codigos' => $codigos,
            'materias' => $materias,
            'title' => 'Notas'
            );
    }

    /**
     * @Route("/{id}/{codigo}/new", name="nota_new")
     * @Template()
     */
    public function newAction(Materia $materia, CodigoEspecialidad $codigo)
    {
    }

    /**
     * @Route("/edit", name="nota_edit")
     * @Template()
     */
    public function editAction()
    {
    }

}
