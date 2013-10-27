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
     * @var \Profesor
     *
     * @ORM\ManyToOne(targetEntity="Profesor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Profesor", referencedColumnName="id")
     * })
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
     * @param \INTI\RegistroAcademicoBundle\Entity\Profesor $profesor
     * @return Materia
     */
    public function setProfesor(\INTI\RegistroAcademicoBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;
    
        return $this;
    }

    /**
     * Get profesor
     *
     * @return \INTI\RegistroAcademicoBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }
}