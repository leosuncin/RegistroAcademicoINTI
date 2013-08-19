<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Encargado
 *
 * @ORM\Table(name="Encargado")
 * @ORM\Entity
 */
class Encargado
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
     * @ORM\Column(name="Parentesco", type="string", length=12, nullable=false)
     */
    private $parentesco;

    /**
     * @var string
     *
     * @ORM\Column(name="DUI", type="string", length=10, nullable=false)
     */
    private $dui;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=8, nullable=false)
     */
    private $telefono;



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