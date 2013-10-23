<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AspectosPracticaProfesional
 *
 * @ORM\Table(name="Aspectos_practica_profesional")
 * @ORM\Entity
 */
class AspectosPracticaProfesional
{
    /**
     * @var string
     *
     * @ORM\Column(name="aspecto", type="string", length=80, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $aspecto;

    /**
     * @var string
     *
     * @ORM\Column(name="valoracion", type="string", length=2, nullable=true)
     */
    private $valoracion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;

    /**
     * @var \PracticaProfesional
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="PracticaProfesional")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="practica_profesional", referencedColumnName="id")
     * })
     */
    private $practicaProfesional;



    /**
     * Set aspecto
     *
     * @param string $aspecto
     * @return AspectosPracticaProfesional
     */
    public function setAspecto($aspecto)
    {
        $this->aspecto = $aspecto;
    
        return $this;
    }

    /**
     * Get aspecto
     *
     * @return string 
     */
    public function getAspecto()
    {
        return $this->aspecto;
    }

    /**
     * Set valoracion
     *
     * @param string $valoracion
     * @return AspectosPracticaProfesional
     */
    public function setValoracion($valoracion)
    {
        $this->valoracion = $valoracion;
    
        return $this;
    }

    /**
     * Get valoracion
     *
     * @return string 
     */
    public function getValoracion()
    {
        return $this->valoracion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return AspectosPracticaProfesional
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    
        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set practicaProfesional
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\PracticaProfesional $practicaProfesional
     * @return AspectosPracticaProfesional
     */
    public function setPracticaProfesional(\INTI\RegistroAcademicoBundle\Entity\PracticaProfesional $practicaProfesional)
    {
        $this->practicaProfesional = $practicaProfesional;
    
        return $this;
    }

    /**
     * Get practicaProfesional
     *
     * @return \INTI\RegistroAcademicoBundle\Entity\PracticaProfesional 
     */
    public function getPracticaProfesional()
    {
        return $this->practicaProfesional;
    }
}