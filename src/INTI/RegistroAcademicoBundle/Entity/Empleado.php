<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Empleado
 *
 * @ORM\Table(name="Empleado")
 * @ORM\Entity
 * @UniqueEntity(fields="dui", message="El DUI ya esta registrado")
 * @UniqueEntity(fields="isss", message="El ISSS ya esta registrado")
 * @UniqueEntity(fields="nit", message="El NIT ya esta registrado")
 * @UniqueEntity(fields="nup", message="El NUP ya esta registrado")
 */
class Empleado
{
    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^\d{8}-\d$/",
     *     message="El DUI debe contener solo números e incluir el guion medio"
     * )
     *
     * @ORM\Column(name="DUI", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $dui;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = "3",
     *      max = "80",
     *      minMessage = "Los nombres por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "Los nombres no puede tener más de {{ limit }} caracteres de largo"
     * )
     *
     * @ORM\Column(name="nombres", type="string", length=80, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = "3",
     *      max = "80",
     *      minMessage = "Los apellidos por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "Los apellidos no puede tener más de {{ limit }} caracteres de largo"
     * )
     *
     * @ORM\Column(name="apellidos", type="string", length=80, nullable=false)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @Assert\Choice(
     *     choices = {"director", "subdirector", "encargado_reg_acad", "encargado_serv_soc", "encargado_prac_prof", "secretaria_reg_acad"},
     *     message = "Asigne un puesto valido"
     * )
     *
     * @ORM\Column(name="puesto", type="string", length=60, nullable=false)
     */
    private $puesto;

    /**
     * @var string
     *
     * @ORM\Column(name="fotografia", type="blob", nullable=true)
     */
    private $fotografia;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^\d{9}$/",
     *     message="El ISSS debe contener 9 números"
     * )
     *
     * @ORM\Column(name="ISSS", type="string", length=9, nullable=false)
     */
    private $isss;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^\d{4}-\d{6}-\d{3}-\d$/",
     *     message="El NIT debe contener solo números en incluir los guiones medios"
     * )
     *
     * @ORM\Column(name="NIT", type="string", length=17, nullable=false)
     */
    private $nit;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^\d{12}$/",
     *     message="El NUP debe contener solo 12 números"
     * )
     *
     * @ORM\Column(name="NUP", type="string", length=12, nullable=false)
     */
    private $nup;

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
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Usuario", referencedColumnName="username")
     * })
     */
    private $usuario;

    /**
     * Set dui
     *
     * @param string $dui
     * @return Empleado
     */
    public function setDui($dui)
    {
        $this->dui = $dui;

        return $this;
    }

    /**
     * Get dui
     *
     * @return string
     */
    public function getDui()
    {
        return $this->dui;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Empleado
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Empleado
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set puesto
     *
     * @param string $puesto
     * @return Empleado
     */
    public function setPuesto($puesto)
    {
        $this->puesto = $puesto;

        return $this;
    }

    /**
     * Get puesto
     *
     * @return string
     */
    public function getPuesto()
    {
        return $this->puesto;
    }

    /**
     * Set fotografia
     *
     * @param string $fotografia
     * @return Empleado
     */
    public function setFotografia($fotografia)
    {
        $this->fotografia = $fotografia;

        return $this;
    }

    /**
     * Get fotografia
     *
     * @return string
     */
    public function getFotografia()
    {
        return $this->fotografia;
    }

    /**
     * Set isss
     *
     * @param string $isss
     * @return Empleado
     */
    public function setIsss($isss)
    {
        $this->isss = $isss;

        return $this;
    }

    /**
     * Get isss
     *
     * @return string
     */
    public function getIsss()
    {
        return $this->isss;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Empleado
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string
     */
    public function getNit()
    {
        return $this->nit;
    }

    /**
     * Set nup
     *
     * @param string $nup
     * @return Empleado
     */
    public function setNup($nup)
    {
        $this->nup = $nup;

        return $this;
    }

    /**
     * Get nup
     *
     * @return string
     */
    public function getNup()
    {
        return $this->nup;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Empleado
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
     * Set usuario
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\Usuario $usuario
     * @return Empleado
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
}
