<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Empresa
 *
 * @ORM\Table(name="Empresa")
 * @ORM\Entity
 * @UniqueEntity(fields = "nombre", message = "El nombre de la empresa ya esta registrado")
 */
class Empresa
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
	 *      min = "5",
	 *      max = "100",
	 *      minMessage = "El nombre por lo menos debe tener {{ limit }} caracteres de largo",
	 *      maxMessage = "El nombre no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
	 */
	private $nombre;

	/**
	 * @var string
	 *
	 * @Assert\Length(
	 *      min = "3",
	 *      max = "80",
	 *      minMessage = "El nombre del contacto por lo menos debe tener {{ limit }} caracteres de largo",
	 *      maxMessage = "El nombre del contacto no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="contacto", type="string", length=80, nullable=false)
	 */
	private $contacto;

	/**
	 * @var string
	 *
	 * @Assert\Regex(
	 *     pattern = "/^\d{8}$/",
	 *     message = "El telefono debe contener solo 8 números"
	 * )
	 *
	 * @ORM\Column(name="telefono", type="string", length=8, nullable=false)
	 */
	private $telefono;

	/**
	 * @var string
	 *
	 * @Assert\NotBlank(message = "Debe especificar una dirección")
	 *
	 * @ORM\Column(name="direccion", type="text", nullable=false)
	 */
	private $direccion;

	/**
	 * @var string
	 *
	 * @Assert\Email(
	 *     message = "El correo '{{ value }}' no es una dirección valida"
	 * )
	 *
	 * @ORM\Column(name="email", type="string", length=40, nullable=true)
	 */
	private $email;

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
	 * @return Empresa
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
	 * Set contacto
	 *
	 * @param string $contacto
	 * @return Empresa
	 */
	public function setContacto($contacto)
	{
		$this->contacto = $contacto;

		return $this;
	}

	/**
	 * Get contacto
	 *
	 * @return string
	 */
	public function getContacto()
	{
		return $this->contacto;
	}

	/**
	 * Set telefono
	 *
	 * @param string $telefono
	 * @return Empresa
	 */
	public function setTelefono($telefono)
	{
		$this->telefono = $telefono;

		return $this;
	}

	/**
	 * Get telefono
	 *
	 * @return string
	 */
	public function getTelefono()
	{
		return $this->telefono;
	}

	/**
	 * Set direccion
	 *
	 * @param string $direccion
	 * @return Empresa
	 */
	public function setDireccion($direccion)
	{
		$this->direccion = $direccion;

		return $this;
	}

	/**
	 * Get direccion
	 *
	 * @return string
	 */
	public function getDireccion()
	{
		return $this->direccion;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return Empresa
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
}
