<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
	 * @Route("/notas", name="nota_import")
	 * @Template()
	 */
	public function importNotasAction(Request $request)
	{
		// $document = new DocumentUploaded();
		// $form = $this->createForm(new DocumentType(), $document);
		
		if ($request->getMethod() == 'POST') {
			// if ($form->isValid()) {
			// 	$document->processFile();
			// }
			$archivo = $request->files->get('archivo');
			if($archivo instanceof UploadedFile && $archivo->getError() == '0') {
				print_r($archivo);
			}else{
				print_r('Fallo');
			}
			die();
		}
		return array(
			// 'form' => $form->createView(),
			// 'document' => $document,
			'title' => 'Subir un documento'
		);
	}

	/**
	 * @Route("/alumnos")
	 * @Template()
	 */
	public function importAlumnosAction()
	{
	}
}
