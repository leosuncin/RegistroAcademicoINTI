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
     * @var string
     *
     * @ORM\Column(name="NIE", type="string", length=6, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $nie;
	
	 /**
     * @var string
     *
     * @ORM\Column(name="condicion", type="string", length=2, nullable=false)
     */
    private $condicion;

    /**
     * @var \Aspirante
     *
     * @ORM\OneToOne(targetEntity="Aspirante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Aspirante", referencedColumnName="id")
     * })
     */
    private $aspirante;



    /**
     * Set nie
     *
     * @param string $nie
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
     * @return string 
     */
    public function getNie()
    {
        return $this->nie;
    }
	
	/**
     * Set condicion
     *
     * @param string $condicion
     * @return Alumno
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;

        return $this;
    }

    /**
     * Get condicion
     *
     * @return string
     */
    public function getCondicion()
    {
        return $this->condicion;
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