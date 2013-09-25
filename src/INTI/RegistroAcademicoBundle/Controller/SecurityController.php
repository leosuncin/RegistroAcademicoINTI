<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
 
        // obtiene el error de inicio de sesión si lo hay
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            // último nombre de usuario ingresado
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'title'         => "Acceso al sistema"
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
     * @Route("/admin/user/{username}/edit", name="update_password")
     * @Template()
     */
    public function changePwdAction($username)
    {
        $em = $this->getDoctrine()->getManager()->getRepository("RegistroAcademicoBundle:Usuario");
		 $usuario = $em->find($username);
		 $request = $this->getRequest();
		 $form = $this->createFormBuilder()
        ->add('old_password', 'password',
			array('label' => 'Contraseña actual',
			'attr' => array('placeholder' => 'Escriba su contraseña actual')))
        ->add('new_password', 'password',
			array('label' => 'Nueva contraseña',
			'attr' => array('placeholder' => 'Escriba su nueva contraseña')))
        ->add('confirm_password', 'password',
			array('label' => 'Confirmar contraseña',
			'attr' => array('placeholder' => 'Repita su nueva contraseña')))
        ->add('username', 'hidden', array('attr' => array('value' => $username)))
        ->getForm();
        if($request->isMethod('POST')){
			$form->submit($request);
			$data = $form->getData();
			$factory  = $this->get('security.encoder_factory');
            $encoder  = $factory->getEncoder($usuario);
            $password_enc = $encoder->encodePassword($data['old_password'], $usuario->getSalt());
			if($usuario->getPassword() == $password_enc)
				if($data['new_password'] == $data['confirm_password'])
					$usuario->setPassword($encoder->encodePassword($data['new_password'], $usuario->getSalt()));
		}else{
			 return array('form' => $form->createView(),
			 'usuario' => $usuario,
			 'title' => 'Cambiar contraseña'
			 );
		 }
    }
}
