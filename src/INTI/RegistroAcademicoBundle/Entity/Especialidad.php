<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Especialidad
 *
 * @ORM\Table(name="Especialidad")
 * @ORM\Entity
 */
class Especialidad
{
    /**
     * @var string
     *
     * @Assert\Length(
     *      min = "2",
     *      max = "5",
     *      minMessage = "El codigo de la especialidad por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El codigo de la especialidad no puede tener más de {{ limit }} caracteres de largo"
     * )
     *
     * @ORM\Column(name="codigo", type="string", length=5, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $codigo;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = "5",
     *      max = "100",
     *      minMessage = "El codigo de la especialidad por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El codigo de la especialidad no puede tener más de {{ limit }} caracteres de largo"
     * )
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;



    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Especialidad
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