<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alumno
 *
 * @ORM\Table(name="Alumno")
 * @ORM\Entity
 */
class Alumno
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
     * @var \Aspirante
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Aspirante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Aspirante", referencedColumnName="id")
     * })
     */
    private $aspirante;



    /**
     * Set nie
     *
     * @param integer $nie
     * @return Alumno
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
     * Set aspirante
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\Aspirante $aspirante
     * @return Alumno
     */
    public function setAspirante(\INTI\RegistroAcademicoBundle\Entity\Aspirante $aspirante)
    {
        $this->aspirante = $aspirante;
    
        return $this;
    }

    /**
     * Get aspirante
     *
     * @return \INTI\RegistroAcademicoBundle\Entity\Aspirante 
     */
    public function getAspirante()
    {
        return $this->aspirante;
    }
}