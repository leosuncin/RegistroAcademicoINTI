<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Profesor
 *
 * @ORM\Table(name="Profesor")
 * @ORM\Entity
 * @UniqueEntity(fields = "nombre", message = "El nombre ya esta registrado")
 */
class Profesor
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
	 * @Assert\Length(
	 *      min = "3",
	 *      max = "80",
	 *      minMessage = "El nombre por lo menos debe tener {{ limit }} caracteres de largo",
	 *      maxMessage = "El nombre no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="nombre", type="string", length=80, nullable=false)
	 */
	private $nombre;



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
	 * @return Profesor
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
}
