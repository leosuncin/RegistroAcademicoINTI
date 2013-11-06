<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use INTI\RegistroAcademicoBundle\Model\DocumentUploaded;
use INTI\RegistroAcademicoBundle\Form\DocumentType;

/**
 * @Route("/import")
 */
class ImportController extends Controller
{
	/**
	 * @Route("/notas")
	 * @Template()
	 */
	public function importNotasAction()
	{
		$document = new DocumentUploaded();
		$form = $this->container->get('form.factory')->create(new DocumentType(), $document);
		$request = $this->container->get('request');
		
		if ($request->getMethod() == 'POST') {
			if ($form->isValid()) {
				$document->processFile();
			}
		}
	}

	/**
	 * @Route("/alumnos")
	 * @Template()
	 */
	public function importAlumnosAction()
	{
	}
}
