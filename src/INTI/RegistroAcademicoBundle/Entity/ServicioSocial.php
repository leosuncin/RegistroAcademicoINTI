<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServicioSocial
 *
 * @ORM\Table(name="Servicio_social")
 * @ORM\Entity
 */
class ServicioSocial
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var float
	 *
	 * @ORM\Column(name="horas_realizadas", type="float", nullable=false)
	 */
	private $horasRealizadas;

	/**
	 * @var \Alumno
	 *
	 * @ORM\ManyToOne(targetEntity="Alumno")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Alumno", referencedColumnName="NIE")
	 * })
	 */
	private $alumno;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set horasRealizadas
	 *
	 * @param float $horasRealizadas
	 * @return ServicioSocial
	 */
	public function setHorasRealizadas($horasRealizadas)
	{
		$this->horasRealizadas = $horasRealizadas;

		return $this;
	}

	/**
	 * Get horasRealizadas
	 *
	 * @return float
	 */
	public function getHorasRealizadas()
	{
		return $this->horasRealizadas;
	}

	/**
	 * Set alumno
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\Alumno $alumno
	 * @return ServicioSocial
	 */
	public function setAlumno(\INTI\RegistroAcademicoBundle\Entity\Alumno $alumno = null)
	{
		$this->alumno = $alumno;

		return $this;
	}

	/**
	 * Get alumno
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\Alumno
	 */
	public function getAlumno()
	{
		return $this->alumno;
	}
}
