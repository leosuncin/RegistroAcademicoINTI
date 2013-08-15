<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Route("/export")
 */

class ExportController extends Controller
{
    /**
     * @Route("/test")
     */
    public function exportAction()
    {
        $dompdf = $this->get("slik_dompdf");
    	$dompdf->getpdf($this->renderView("RegistroAcademicoBundle:Export:export.html.twig", array('author' => 'test')));
    	$response = new Response();
    	$response->setContent($dompdf->output());
    	$response->headers->set("Content-Type", "application/pdf; charset=UTF-8");
    	return $response;
    }

    /**
     * @Route("/nuevo_ingreso", name="solicitud_nuevo_ingreso")
     */
    public function nuevoIngresoAction()
    {
    	$dompdf = $this->get("slik_dompdf");
    	$dompdf->getpdf($this->renderView("RegistroAcademicoBundle:Export:solicitudNuevoIngreso.html.twig", array('title' => 'Solicitud de nuevo ingreso', 'author' => 'test')));
    	$response = new Response();
    	// $response->setContent($dompdf->stream("solicitud_nuevo_ingreso.pdf"));
    	$response->setContent($dompdf->output());
    	$response->headers->set("Content-Type", "application/pdf; charset=UTF-8");
    	return $response;
    }
    /**
     * @Route("/nuevo_ingreso.html")
     */
    public function nuevoIngresoHtmlAction()
    {
    	return $this->render("RegistroAcademicoBundle:Export:solicitudNuevoIngreso.html.twig", array('title' => 'Solicitud de nuevo ingreso', 'author' => 'test'));
    }
}