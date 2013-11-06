<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proyecto
 *
 * @ORM\Table(name="Proyecto")
 * @ORM\Entity
 */
class Proyecto
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
	 * @var string
	 *
	 * @ORM\Column(name="nombre", type="string", length=60, nullable=false)
	 */
	private $nombre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="descripcion", type="text", nullable=true)
	 */
	private $descripcion;

	/**
	 * @var \EncargadoProyecto
	 *
	 * @ORM\ManyToOne(targetEntity="EncargadoProyecto")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Encargado", referencedColumnName="id")
	 * })
	 */
	private $encargado;

	/**
	 * @var \ServicioSocial
	 *
	 * @ORM\ManyToOne(targetEntity="ServicioSocial")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Servicio_social", referencedColumnName="id")
	 * })
	 */
	private $servicioSocial;

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
	 * Set nombre
	 *
	 * @param string $nombre
	 * @return Proyecto
	 */
	public function setNombre($nombre)
	{
		$this->nombre = $nombre;

		return $this;
	}

	/**
	 * Get nombre
	 *
	 * @return string
	 */
	public function getNombre()
	{
		return $this->nombre;
	}

	/**
	 * Set descripcion
	 *
	 * @param string $descripcion
	 * @return Proyecto
	 */
	public function setDescripcion($descripcion)
	{
		$this->descripcion = $descripcion;

		return $this;
	}

	/**
	 * Get descripcion
	 *
	 * @return string
	 */
	public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	 * Set encargado
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\EncargadoProyecto $encargado
	 * @return Proyecto
	 */
	public function setEncargado(\INTI\RegistroAcademicoBundle\Entity\EncargadoProyecto $encargado = null)
	{
		$this->encargado = $encargado;

		return $this;
	}

	/**
	 * Get encargado
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\EncargadoProyecto
	 */
	public function getEncargado()
	{
		return $this->encargado;
	}

	/**
	 * Set servicioSocial
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\ServicioSocial $servicioSocial
	 * @return Proyecto
	 */
	public function setServicioSocial(\INTI\RegistroAcademicoBundle\Entity\ServicioSocial $servicioSocial = null)
	{
		$this->servicioSocial = $servicioSocial;

		return $this;
	}

	/**
	 * Get servicioSocial
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\ServicioSocial
	 */
	public function getServicioSocial()
	{
		return $this->servicioSocial;
	}
}
