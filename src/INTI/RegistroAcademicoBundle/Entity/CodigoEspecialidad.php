<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CodigoEspecialidad
 *
 * @ORM\Table(name="Codigo_especialidad")
 * @ORM\Entity
 * @UniqueEntity(fields = "codigo", message = "El código ya esta registrado")
 */
class CodigoEspecialidad
{
    /**
     * @var string
     *
     * @Assert\Length(
     *      min = "3",
     *      max = "5",
     *      minMessage = "El código por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El código no puede tener más de {{ limit }} caracteres de largo"
     * )
     *
     * @ORM\Column(name="codigo", type="string", length=5, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $codigo;

    /**
     * @var integer
     *
     * @Assert\Range(
     *      min = "1",
     *      max = "4",
     *      minMessage = "El año no debe ser menor que {{ limit }}",
     *      maxMessage = "El año no debe ser mayor que {{ limit }}"
     * )
     *
     * @ORM\Column(name="anho", type="integer", nullable=false)
     */
    private $anho;

    /**
     * @var string
     *
     * @Assert\Choice(
     *     choices = {"A", "B", "C", "D", "E", "F"},
     *     message = "Escoja una sección valida"
     * )
     *
     * @ORM\Column(name="seccion", type="string", length=1, nullable=false)
     */
    private $seccion;

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
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set anho
     *
     * @param integer $anho
     * @return CodigoEspecialidad
     */
    public function setAnho($anho)
    {
        $this->anho = $anho;
    
        return $this;
    }

    /**
     * Get anho
     *
     * @return integer 
     */
    public function getAnho()
    {
        return $this->anho;
    }

    /**
     * Set seccion
     *
     * @param string $seccion
     * @return CodigoEspecialidad
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;
    
        return $this;
    }

    /**
     * Get seccion
     *
     * @return string 
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set especialidad
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\Especialidad $especialidad
     * @return CodigoEspecialidad
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