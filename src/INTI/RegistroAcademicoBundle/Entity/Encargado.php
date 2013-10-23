<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Encargado
 *
 * @ORM\Table(name="Encargado")
 * @ORM\Entity
 */
class Encargado
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
     *      minMessage = "El nombre por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El nombre no puede tener más de {{ limit }} caracteres de largo"
     * )
     *
     * @ORM\Column(name="nombre", type="string", length=80, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Debe especificar un parentesco")
     *
     * @ORM\Column(name="parentesco", type="string", length=12, nullable=false)
     */
    private $parentesco;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^\d{8}$/",
     *     message="El telefono debe contener solo 8 números"
     * )
     *
     * @ORM\Column(name="telefono", type="string", length=8, nullable=false)
     */
    private $telefono;

    /**
     * Set dui
     *
     * @param string $dui
     * @return Encargado
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
     * Set nombre
     *
     * @param string $nombre
     * @return Encargado
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
     * Set parentesco
     *
     * @param string $parentesco
     * @return Encargado
     */
    public function setParentesco($parentesco)
    {
        $this->parentesco = $parentesco;
    
        return $this;
    }

    /**
     * Get parentesco
     *
     * @return string 
     */
    public function getParentesco()
    {
        return $this->parentesco;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Encargado
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
}