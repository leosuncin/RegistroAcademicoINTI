<?php

namespace INTI\RegistroAcademicoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use INTI\RegistroAcademicoBundle\Entity\Alumno;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;
use INTI\RegistroAcademicoBundle\Entity\Usuario;
use INTI\RegistroAcademicoBundle\Form\AlumnoType;


/**
 * GuardarAlumno controller for ajax.
 *
 * @Route("/GuardarAlumno")
 */
class GuardarAlumnoAjax extends Controller
{
    /**
     * Creates a new Alumno entity.
     *
     * @Route("/", name="GuardarAlumnoAjax")
     * @Method("GET")
     */
    function crearAlumno()
    {
		$dql="SELECT p FROM RegistroAcademicoBundle:Aspirante p WHERE p.nie=:nie";
		$em = $this->getDoctrine()->getManager();
		$query=$em->createQuery($dql)->setParameter("nie", $_REQUEST['nie'])->setMaxResults(1);
		try{
			$aspirante = $query->getSingleResult();
			if($aspirante->getEstado()=="A"){
				$dql2="SELECT p FROM RegistroAcademicoBundle:CodigoEspecialidad p WHERE p.codigo=:codigo";
				$query2=$em->createQuery($dql2)->setParameter("codigo", $_REQUEST['cod_esp'])->setMaxResults(1);
				$codigoEspecialidad = $query2->getSingleResult();
				$usuario = new Usuario();
				$usuario->setUsername($_REQUEST['username']);
				$usuario->setPassword($_REQUEST['password']);
				$factory  = $this->get('security.encoder_factory');
				$encoder  = $factory->getEncoder($usuario);
				$password = $encoder->encodePassword($usuario->getPassword(), $usuario->getSalt());
				$usuario->setPassword($password);
				$usuario->addRole("ROLE_USER");
				
				$entity = new Alumno();
				$entity->setCondicion($_REQUEST['cond']);
				$aspirante->setEstado('M');
				$entity->setNie($aspirante);
				$entity->setUsuario($usuario);
				$entity->setCodigoEspecialidad($codigoEspecialidad);
				$em->persist($entity->getUsuario());
				$em->persist($entity->getNIE());
				$em->persist($entity);

				$em->flush();

				return new response($this->generateUrl('alumno_show', array('nie' => $entity->getNie()->getNie())));
			}else{
				return new response($aspirante->getEstado());
			}
		} catch (\Doctrine\Orm\NoResultException $e) {
			return new response("N");
		}
    }
}
