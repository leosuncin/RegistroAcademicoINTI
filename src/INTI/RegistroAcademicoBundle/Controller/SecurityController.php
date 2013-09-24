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
use INTI\RegistroAcademicoBundle\Form\LoginType;

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

        $form = $this->container->get('form.factory')->create(new LoginType());

        return array(
            // último nombre de usuario ingresado
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'title'         => "Acceso al sistema",
            'form'          => $form->createView()
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     * @Method("POST")
     */
    public function loginCheckAction()
    {
        //return new Response();
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        //return new Response();
    }

    /**
     * @Route("/admin/user", name="new_user")
     * @Template()
     */
    public function newUserAction()
    {
        $usuario = new Usuario();
        $form = $this->createForm(new UsuarioType, $usuario);
        return array('form' => $form->createView(), 'usuario' => $usuario, 'title' => 'Crear un nuevo usuario');
    }

    /**
     * @Route("/admin/user_create", name="create_user")
     * @Method("POST")
     * @Template("RegistroAcademicoBundle:Security:newUser.html.twig")
     */
    public function createUserAction(Request $request)
    {
        $usuario = new Usuario();
        $form    = $this->createForm(new UsuarioType, $usuario);
        $form->bind($request);
        if ($form->isValid()) {
            $em       = $this->getDoctrine()->getManager();
            $factory  = $this->get('security.encoder_factory');
            $encoder  = $factory->getEncoder($usuario);
            $password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
            $usuario->setPassword($password);
            $usuario->addRole("ROLE_USER");
            $em->persist($usuario);
            $em->flush();
            return $this->redirect(
                $this->generateUrl(
                    "index")
                );
        } else {
            return array(
                'form'    => $form->createView(), 
                'usuario' => $usuario, 
                'title'   => 'Crear un nuevo usuario'
                );
        }
        
    }

    /**
     * @Route("/admin/user/{username}/edit", name="change_user")
     * @Template()
     */
    public function updateUserAction($username)
    {
        $em = $this->getDoctrine()->getManager()->getRepository("RegistroAcademicoBundle:Usuario");
        $usuario = $em->find($username);
        $form = $this->createForm(new UsuarioType, $usuario);
        return array('form' => $form->createView(), 
            'usuario'       => $usuario, 
            'title'         => 'Cambiar contraseña del usuario'
            );
    }

    /**
     * @Route("/admin/user/edit", name="check_change_user")
     * @Template("RegistroAcademicoBundle:Security:updateUser.html.twig")
     */
    public function changeUserAction(Request $request)
    {
        $em          = $this->getDoctrine()->getManager()->getRepository("RegistroAcademicoBundle:Usuario");
        $factory     = $this->get('security.encoder_factory');
        $new_usuario = new Usuario();
        $form        = $this->createForm(new UsuarioType, $new_usuario);
        $form->submit($request);
        if ($form->isValid()) {
            $usuario  = $em->find($new_usuario->getUsername());
            $encoder  = $factory->getEncoder($new_usuario);
            $password = $encoder->encodePassword($new_usuario->getPassword(), $new_usuario->getSalt());
            if ($usuario->isCorrectPassword($password)) {
                $new_usuario->setPassword($password);
                $em->persist($usuario);
                $em->flush();
                return $this->redirect(
                    $this->generateUrl(
                        "index")
                    );
            }
        }
        return array(
            'form'    => $form->createView(), 
            'usuario' => $usuario, 
            'title'   => 'Cambiar contraseña del usuario'
            );
    }
}
