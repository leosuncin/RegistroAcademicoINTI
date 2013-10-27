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
     * @ORM\Column(name="primerApellido", type="string", length=15, nullable=false)
     */
    private $primerapellido;

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
     * @ORM\Column(name="segundoApellido", type="string", length=15, nullable=true)
     */
    private $segundoapellido;

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
     * @ORM\Column(name="fechaNac", type="date", nullable=false)
     */
    private $fechanac;

    /**
     * @var string
     *
     * @Assert\Length(
     *      max = "40",
     *      maxMessage = "La dirección no puede tener más de {{ limit }} caracteres de largo"
     * )
     *
     * @ORM\Column(name="lugarNac", type="string", length=40, nullable=false)
     */
    private $lugarnac;

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
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1, nullable=false)
     */
    private $estado;

    /**
     * @var \Especialidad
     *
     * @ORM\ManyToOne(targetEntity="Especialidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Especialidad", referencedColumnName="codigo")
     * })
     */
    private $especialidad;

    /**
     * @var \Encargado
     *
     * @ORM\ManyToOne(targetEntity="Encargado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Encargado", referencedColumnName="DUI")
     * })
     */
    private $encargado;

    function __construct() {
        $ahora = new DateTime("now");
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
     * Set primerapellido
     *
     * @param string $primerapellido
     * @return Aspirante
     */
    public function setPrimerapellido($primerapellido)
    {
        $this->primerapellido = $primerapellido;

        return $this;
    }

    /**
     * Get primerapellido
     *
     * @return string
     */
    public function getPrimerapellido()
    {
        return $this->primerapellido;
    }

    /**
     * Set segundoapellido
     *
     * @param string $segundoapellido
     * @return Aspirante
     */
    public function setSegundoapellido($segundoapellido)
    {
        $this->segundoapellido = $segundoapellido;

        return $this;
    }

    /**
     * Get segundoapellido
     *
     * @return string
     */
    public function getSegundoapellido()
    {
        return $this->segundoapellido;
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
     * Set fechanac
     *
     * @param \DateTime $fechanac
     * @return Aspirante
     */
    public function setFechanac($fechanac)
    {
        $this->fechanac = $fechanac;

        return $this;
    }

    /**
     * Get fechanac
     *
     * @return \DateTime
     */
    public function getFechanac()
    {
        return $this->fechanac;
    }

    /**
     * Set lugarnac
     *
     * @param string $lugarnac
     * @return Aspirante
     */
    public function setLugarnac($lugarnac)
    {
        $this->lugarnac = $lugarnac;

        return $this;
    }

    /**
     * Get lugarnac
     *
     * @return string
     */
    public function getLugarnac()
    {
        return $this->lugarnac;
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
     * Set estado
     *
     * @param string $estado
     * @return Aspirante
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
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
}
