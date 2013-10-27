<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Anho
 *
 * @ORM\Table(name="Anho")
 * @ORM\Entity
 */
class Anho
{
    /**
     * @var integer
     *
     * @ORM\Column(name="anho", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $anho;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inicio", type="date", nullable=false)
     */
    private $inicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="date", nullable=true)
     */
    private $fin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enCurso", type="boolean", nullable=false)
     */
    private $encurso;



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
     * Set inicio
     *
     * @param \DateTime $inicio
     * @return Anho
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;
        $this->anho = $inicio->format("Y");
    
        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime 
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return Anho
     */
    public function setFin($fin)
    {
        $this->fin = $fin;
    
        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set encurso
     *
     * @param boolean $encurso
     * @return Anho
     */
    public function setEncurso($encurso)
    {
        $this->encurso = $encurso;
    
        return $this;
    }

    /**
     * Get encurso
     *
     * @return boolean 
     */
    public function getEncurso()
    {
        return $this->encurso;
    }
}