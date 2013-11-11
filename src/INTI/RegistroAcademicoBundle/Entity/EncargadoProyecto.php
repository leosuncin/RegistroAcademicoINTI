<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EncargadoProyecto
 *
 * @ORM\Table(name="Encargado_proyecto")
 * @ORM\Entity
 */
class EncargadoProyecto
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
	 * @ORM\Column(name="nombre", type="string", length=80, nullable=false)
	 */
	private $nombre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="rol", type="string", length=20, nullable=true)
	 */
	private $rol;

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
	 * @return EncargadoProyecto
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
	 * Set rol
	 *
	 * @param string $rol
	 * @return EncargadoProyecto
	 */
	public function setRol($rol)
	{
		$this->rol = $rol;

		return $this;
	}

	/**
	 * Get rol
	 *
	 * @return string
	 */
	public function getRol()
	{
		return $this->rol;
	}

	public function __toString(){

		return $this->getNombre();
	}
}
