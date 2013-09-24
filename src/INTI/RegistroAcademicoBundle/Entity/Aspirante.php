<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aspirante
 *
 * @ORM\Table(name="Aspirante")
 * @ORM\Entity
 */
class Aspirante
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
     * @ORM\Column(name="foto", type="text", nullable=false)
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="primerApellido", type="string", length=15, nullable=false)
     */
    private $primerapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="segundoApellido", type="string", length=15, nullable=true)
     */
    private $segundoapellido;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=50, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=100, nullable=false)
     */
    private $direccion;

    /**
     * @var string
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
     * @ORM\Column(name="lugarNac", type="string", length=100, nullable=false)
     */
    private $lugarnac;

    /**
     * @var string
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
}
