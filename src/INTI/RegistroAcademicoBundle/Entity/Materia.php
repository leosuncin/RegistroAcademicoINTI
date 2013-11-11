<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Materia
 *
 * @ORM\Table(name="Materia")
 * @ORM\Entity
 * @UniqueEntity(fields = "nombre", message = "El nombre de la materia ya esta registrado")
 */
class Materia
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
	 * @var integer
	 *
	 * @ORM\Column(name="codigo", type="integer", length=5, nullable=true)
	 */
	private $codigo;

	/**
	 * @var string
	 *
	 * @Assert\Length(
	 *      min = "5",
	 *      max = "60",
	 *      minMessage = "El nombre por lo menos debe tener {{ limit }} caracteres de largo",
	 *      maxMessage = "El nombre no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="nombre", type="string", length=60, nullable=false)
	 */
	private $nombre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="profesor", type="string", length=80, nullable=false)
	 */
	private $profesor;

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
	 * @return Materia
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
	 * Set profesor
	 *
	 * @param string $profesor
	 * @return Materia
	 */
	public function setProfesor($profesor)
	{
		$this->profesor = $profesor;

		return $this;
	}

	/**
	 * Get profesor
	 *
	 * @return string
	 */
	public function getProfesor()
	{
		return $this->profesor;
	}
	
	/**
	 * Set codigo
	 *
	 * @param integer $codigo
	 * @return Materia
	 */
	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;

		return $this;
	}

	/**
	 * Get codigo
	 *
	 * @return integer
	 */
	public function getCodigo()
	{
		return $this->codigo;
	}
}