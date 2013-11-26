<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use INTI\RegistroAcademicoBundle\Entity\Aspirante;

/**
 * Alumno
 *
 * @ORM\Table(name="Alumno")
 * @ORM\Entity(repositoryClass="INTI\RegistroAcademicoBundle\Repository\AlumnoRepository")
 * @UniqueEntity(fields = "nie", message = "El NIE ya esta registrado")
 */
class Alumno extends Aspirante
{
	/**
	 * @var string
	 *
	 * @Assert\Choice(
	 *     choices = {"CC", "CM", "R", "RI", "NI"},
	 *     message = "Escoja una condición valida"
	 * )
	 *
	 * @ORM\Column(name="condicion", type="string", length=2, nullable=false)
	 */
	private $condicion;

	/**
	 * @var \CodigoEspecialidad
	 *
	 * @ORM\ManyToOne(targetEntity="CodigoEspecialidad",cascade={"persist"})
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Codigo_especialidad", referencedColumnName="codigo")
	 * })
	 */
	private $codigoEspecialidad;

	/**
	 * @var \Usuario
	 *
	 * @ORM\ManyToOne(targetEntity="Usuario",cascade={"persist"})
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Usuario", referencedColumnName="username")
	 * })
	 */
	private $usuario;

	public function __construct(Aspirante $aspirante = null) {
		if($aspirante !== null) {
			$this->foto            = $aspirante->getFoto();
			$this->primerApellido  = $aspirante->getPrimerapellido();
			$this->segundoApellido = $aspirante->getSegundoapellido();
			$this->nombres         = $aspirante->getNombres();
			$this->direccion       = $aspirante->getDireccion();
			$this->telefono        = $aspirante->getTelefono();
			$this->fechaNac        = $aspirante->getFechanac();
			$this->lugarNac        = $aspirante->getLugarnac();
			$this->sexo            = $aspirante->getSexo();
			$this->especialidad    = $aspirante->getEspecialidad();
			$this->encargado       = $aspirante->getEncargado();
		}
	}

	/**
	 * Set condicion
	 *
	 * @param string $condicion
	 * @return Alumno
	 */
	public function setCondicion($condicion)
	{
		$this->condicion = $condicion;
	
		return $this;
	}

	/**
	 * Get condicion
	 *
	 * @return string 
	 */
	public function getCondicion()
	{
		return $this->condicion;
	}

	/**
	 * Set codigoEspecialidad
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\CodigoEspecialidad $codigoEspecialidad
	 * @return Alumno
	 */
	public function setCodigoEspecialidad(\INTI\RegistroAcademicoBundle\Entity\CodigoEspecialidad $codigoEspecialidad = null)
	{
		$this->codigoEspecialidad = $codigoEspecialidad;
	
		return $this;
	}

	/**
	 * Get codigoEspecialidad
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\CodigoEspecialidad 
	 */
	public function getCodigoEspecialidad()
	{
		return $this->codigoEspecialidad;
	}

	/**
	 * Set usuario
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\Usuario $usuario
	 * @return Alumno
	 */
	public function setUsuario(\INTI\RegistroAcademicoBundle\Entity\Usuario $usuario = null)
	{
		$this->usuario = $usuario;
	
		return $this;
	}

	/**
	 * Get usuario
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\Usuario 
	 */
	public function getUsuario()
	{
		return $this->usuario;
	}

	public function __toString()
	{
		return (string) $this->nie;
	}
}