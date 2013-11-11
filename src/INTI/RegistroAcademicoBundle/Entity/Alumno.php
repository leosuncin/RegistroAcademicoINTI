<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Alumno
 *
 * @ORM\Table(name="Alumno")
 * @ORM\Entity
 */
class Alumno
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
	 * @var \Aspirante
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @ORM\OneToOne(targetEntity="Aspirante")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="NIE", referencedColumnName="NIE")
	 * })
	 */
	private $nie;

	/**
	 * @var \CodigoEspecialidad
	 *
	 * @ORM\ManyToOne(targetEntity="CodigoEspecialidad")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Codigo_especialidad", referencedColumnName="codigo")
	 * })
	 */
	private $codigoEspecialidad;

	/**
	 * @var \Usuario
	 *
	 * @ORM\ManyToOne(targetEntity="Usuario")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Usuario", referencedColumnName="username")
	 * })
	 */
	private $usuario;



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
	 * Set nie
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\Aspirante $nie
	 * @return Alumno
	 */
	public function setNie(\INTI\RegistroAcademicoBundle\Entity\Aspirante $nie)
	{
		$this->nie = $nie;
	
		return $this;
	}

	/**
	 * Get nie
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\Aspirante 
	 */
	public function getNie()
	{
		return $this->nie;
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
	
	public function __toString(){

		return (string)$this->nie;
	}
}