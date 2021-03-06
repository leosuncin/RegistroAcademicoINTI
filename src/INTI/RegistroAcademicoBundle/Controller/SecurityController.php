<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use INTI\RegistroAcademicoBundle\Entity\Usuario;
use INTI\RegistroAcademicoBundle\Form\UsuarioType;

class SecurityController extends Controller
{
	/**
	 * @Route("/login", name="login")
	 * @Template()
	 */
	public function loginAction()
	{
		$request = $this->getRequest();
		$session = $request->getSession();
		$session->set('_locale', 'es_SV');
 
		// obtiene el error de inicio de sesión si lo hay
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
		}

		return array(
			// último nombre de usuario ingresado
			'last_username' => $session->get(SecurityContext::LAST_USERNAME),
			'error'			=> $error,
			'title'			=> "Acceso al sistema"
		);
	}

	/**
	 * @Route("/login_check", name="login_check")
	 * @Method("POST")
	 */
	public function loginCheckAction()
	{
	}

	/**
	 * @Route("/logout", name="logout")
	 */
	public function logoutAction()
	{
	}

	/**
	 * @Route("/usuario/{username}/update", name="update_password")
	 * @ParamConverter("usuario", class="RegistroAcademicoBundle:Usuario")
	 * @Template()
	 */
	public function changePwdAction(Usuario $usuario)
	{
		$request = $this->getRequest();
		if ($this->getUser()->getUsername() != $usuario->getUsername() && !$this->get('security.context')->isGranted('ROLE_ADMIN')) {
			throw new AccessDeniedException();
		}
		$em = $this->getDoctrine()->getManager();
		$constraints = array(
				new Assert\NotBlank(),
				new Assert\Length(array('min' => 8,
					'max' => 60,
					'minMessage' => 'La contraseña del usuario por lo menos debe tener {{ limit }} caracteres de largo',
					'maxMessage' => 'La contraseña del usuario no puede tener más de {{ limit }} caracteres de largo')),
				new Assert\Regex(array('pattern' => '/(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d){8,60}.+$)/',
					'message' => 'La contraseña debe contener por lo menos una letra en mayúscula, una letra en minúscula y un numero cualquiera para ser segura'
					)));
		$form = $this->createFormBuilder()
		->add('old_password', 'password',
			array('label'     => 'Contraseña actual',
				'max_length'  => 60,
				'attr'        => array('placeholder' => 'Escriba su contraseña actual'),
				'constraints' => $constraints
			 ))
		->add('new_password', 'repeated',
			array('type'          => 'password',
				'invalid_message' => 'Debe confirmar la nueva contraseña',
				'max_length'      => 60,
				'required'        => true,
				'first_options'   => array(
					'label' => 'Nueva contraseña',
					'attr'  => array('placeholder' => 'Escriba su nueva contraseña')),
				'second_options'  => array(
					'label' => 'Repetir contraseña',
					'attr'  => array('placeholder' => 'Repita su nueva contraseña')),
				'constraints'     => $constraints
			))
		->getForm();

		if($request->isMethod('POST')) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$data = $form->getData();
				$factory  = $this->get('security.encoder_factory');
				$encoder  = $factory->getEncoder($usuario);
				$password_enc = $encoder->encodePassword($data['old_password'], $usuario->getSalt());
				if($usuario->getPassword() == $password_enc) {
					$usuario->setPassword($encoder->encodePassword($data['new_password'], $usuario->getSalt()));
					$em->persist($usuario);
					$em->flush();
					$this->get('session')->getFlashBag()->add('confirm', 'Se cambio la contraseña del usuario');
					return new RedirectResponse(
						$this->generateUrl(
							'user_info', array(
								'username' => $usuario->getUsername()), 301));
				} else {
					$this->get('session')->getFlashBag()->add('errores', 'La contraseña actual no concuerda');
				}
			}
		}
		return array('form' => $form->createView(),
			'usuario' => $usuario,
			'title'   => 'Cambiar contraseña'
		);
	}

	/**
	 * @Route("/usuario/{username}", name="user_info")
	 * @ParamConverter("usuario", class="RegistroAcademicoBundle:Usuario")
	 */
	public function showUserInfoAction(Usuario $usuario)
	{
		$role = $usuario->getRoles();
		$em = $this->getDoctrine()->getManager();

		if ($role[0] == 'ROLE_USER') {
			$response = new RedirectResponse($this->generateUrl('alumno_show', array('nie' => $usuario->getUsername())), 301);
		} else {
			$query = $em->createQuery("SELECT e FROM RegistroAcademicoBundle:Empleado e WHERE e.usuario = :username")
			->setParameter('username', $usuario->getUsername());
			$empleado = $query->getSingleResult();
			$response = new RedirectResponse($this->generateUrl('empleado_show', array('id' => $empleado->getDui())), 301);
		}
		//$response->prepare($response);
		return $response->send();
	}
}
