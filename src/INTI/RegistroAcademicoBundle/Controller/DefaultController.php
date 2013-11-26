<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
	/**
	 * @Route("/", name="index")
	 * @Template()
	 */
	public function indexAction()
	{
		$user = $this->getUser();
		if($user->getRoles()[0] == 'ROLE_USER')
			return new RedirectResponse($this->generateUrl('alumno_show', array('nie' => $user->getUsername())), 301);
		return array('title' => 'Pagina principal');
	}
}
