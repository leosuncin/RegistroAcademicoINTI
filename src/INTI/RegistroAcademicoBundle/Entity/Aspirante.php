<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Aspirante
 *
 * @ORM\Table(name="Aspirante")
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="class_name", type="string")
 * @ORM\DiscriminatorMap({"aspirante" = "Aspirante", "alumno" = "Alumno"})
 * @UniqueEntity(fields = "nie", message = "El NIE ya esta registrado")
 */
class Aspirante
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="NIE", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 */
	private $nie;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="foto", type="text", nullable=false)
	 */
	private $foto;

	/**
	 * @var string
	 *
	 * @Assert\Length(
	 *      min = "3",
	 *      max = "15",
	 *      minMessage = "El apellido por lo menos debe tener {{ limit }} caracteres de largo",
	 *      maxMessage = "El apellido no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="primer_apellido", type="string", length=15, nullable=false)
	 */
	private $primerApellido;

	/**
	 * @var string
	 *
	 * @Assert\Length(
	 *      min = "3",
	 *      max = "15",
	 *      minMessage = "El apellido por lo menos debe tener {{ limit }} caracteres de largo",
	 *      maxMessage = "El apellido no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="segundo_apellido", type="string", length=15, nullable=true)
	 */
	private $segundoApellido;

	/**
	 * @var string
	 *
	 * @Assert\Length(
	 *      min = "3",
	 *      max = "50",
	 *      minMessage = "Los nombres por lo menos debe tener {{ limit }} caracteres de largo",
	 *      maxMessage = "Los nombres no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="nombres", type="string", length=50, nullable=false)
	 */
	private $nombres;

	/**
	 * @var string
	 *
	 * @Assert\Length(
	 *      max = "100",
	 *      maxMessage = "La dirección no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="direccion", type="text", nullable=false)
	 */
	private $direccion;

	/**
	 * @var string
	 *
	 * @Assert\Regex(
	 *     pattern="/^\d{8}$/",
	 *     message="El telefono debe contener solo 8 números")
	 *
	 * @ORM\Column(name="telefono", type="string", length=8, nullable=false)
	 */
	private $telefono;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fecha_nac", type="date", nullable=false)
	 */
	private $fechaNac;

	/**
	 * @var string
	 *
	 * @Assert\Length(
	 *      max = "40",
	 *      maxMessage = "La dirección no puede tener más de {{ limit }} caracteres de largo"
	 * )
	 *
	 * @ORM\Column(name="lugar_nac", type="string", length=40, nullable=false)
	 */
	private $lugarNac;

	/**
	 * @var string
	 *
	 * @Assert\Choice(
	 *     choices = {"M", "F"},
	 *     message = "Escoja un sexo valido"
	 * )
	 *
	 * @ORM\Column(name="sexo", type="string", length=1, nullable=false)
	 */
	private $sexo;

	/**
	 * @var \Encargado
	 *
	 * @ORM\ManyToOne(targetEntity="Encargado")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Encargado", referencedColumnName="DUI")
	 * })
	 */
	private $encargado;

	/**
	 * @var \Especialidad
	 *
	 * @ORM\ManyToOne(targetEntity="Especialidad")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Especialidad", referencedColumnName="codigo")
	 * })
	 */
	private $especialidad;

	function __construct() {
		$ahora = new \DateTime("now");
		$this->nie = $ahora->format("U");
	}

	/**
	 * Set nie
	 *
	 * @param integer $nie
	 * @return Aspirante
	 */
	public function setNie($nie)
	{
		$this->nie = $nie;

		return $this;
	}

	/**
	 * Get nie
	 *
	 * @return integer
	 */
	public function getNie()
	{
		return $this->nie;
	}

	/**
	 * Set foto
	 *
	 * @param string $foto
	 * @return Aspirante
	 */
	public function setFoto($foto)
	{
		$this->foto = $foto;

		return $this;
	}

	/**
	 * Get foto
	 *
	 * @return string
	 */
	public function getFoto()
	{
		return $this->foto;
	}

	/**
	 * Set primerApellido
	 *
	 * @param string $primerApellido
	 * @return Aspirante
	 */
	public function setPrimerApellido($primerApellido)
	{
		$this->primerApellido = $primerApellido;

		return $this;
	}

	/**
	 * Get primerApellido
	 *
	 * @return string
	 */
	public function getPrimerApellido()
	{
		return $this->primerApellido;
	}

	/**
	 * Set segundoApellido
	 *
	 * @param string $segundoApellido
	 * @return Aspirante
	 */
	public function setSegundoApellido($segundoApellido)
	{
		$this->segundoApellido = $segundoApellido;

		return $this;
	}

	/**
	 * Get segundoApellido
	 *
	 * @return string
	 */
	public function getSegundoApellido()
	{
		return $this->segundoApellido;
	}

	/**
	 * Set nombres
	 *
	 * @param string $nombres
	 * @return Aspirante
	 */
	public function setNombres($nombres)
	{
		$this->nombres = $nombres;

		return $this;
	}

	/**
	 * Get nombres
	 *
	 * @return string
	 */
	public function getNombres()
	{
		return $this->nombres;
	}

	/**
	 * Set direccion
	 *
	 * @param string $direccion
	 * @return Aspirante
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
	 * Set telefono
	 *
	 * @param string $telefono
	 * @return Aspirante
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
	 * Set fechaNac
	 *
	 * @param \DateTime $fechaNac
	 * @return Aspirante
	 */
	public function setFechaNac($fechaNac)
	{
		$this->fechaNac = $fechaNac;

		return $this;
	}

	/**
	 * Get fechaNac
	 *
	 * @return \DateTime
	 */
	public function getFechaNac()
	{
		return $this->fechaNac;
	}

	/**
	 * Set lugarNac
	 *
	 * @param string $lugarNac
	 * @return Aspirante
	 */
	public function setLugarNac($lugarNac)
	{
		$this->lugarNac = $lugarNac;

		return $this;
	}

	/**
	 * Get lugarNac
	 *
	 * @return string
	 */
	public function getLugarNac()
	{
		return $this->lugarNac;
	}

	/**
	 * Set sexo
	 *
	 * @param string $sexo
	 * @return Aspirante
	 */
	public function setSexo($sexo)
	{
		$this->sexo = $sexo;

		return $this;
	}

	/**
	 * Get sexo
	 *
	 * @return string
	 */
	public function getSexo()
	{
		return $this->sexo;
	}

	/**
	 * Set encargado
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\Encargado $encargado
	 * @return Aspirante
	 */
	public function setEncargado(\INTI\RegistroAcademicoBundle\Entity\Encargado $encargado = null)
	{
		$this->encargado = $encargado;

		return $this;
	}

	/**
	 * Get encargado
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\Encargado
	 */
	public function getEncargado()
	{
		return $this->encargado;
	}

	/**
	 * Set especialidad
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\Especialidad $especialidad
	 * @return Aspirante
	 */
	public function setEspecialidad(\INTI\RegistroAcademicoBundle\Entity\Especialidad $especialidad = null)
	{
		$this->especialidad = $especialidad;

		return $this;
	}

	/**
	 * Get especialidad
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\Especialidad
	 */
	public function getEspecialidad()
	{
		return $this->especialidad;
	}

	public function __toString(){

		return (string)$this->getNie();
	}
}
