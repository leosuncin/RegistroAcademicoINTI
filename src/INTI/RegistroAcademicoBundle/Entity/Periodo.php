<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Periodo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Periodo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idPeriodo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="NumPeriodo", type="integer")
     */
    private $numPeriodo;

    /**
     * @var integer
     *
     * @ORM\Column(name="AnhoCorriente", type="integer")
     */
    private $anhoCorriente;

    /**
     * @var integer
     *
     * @ORM\Column(name="EstaAbierto", type="integer")
     */
    private $estaAbierto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FechaInicio", type="date")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FechaFin", type="date")
     */
    private $fechaFin;


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
     * Set numPeriodo
     *
     * @param integer $numPeriodo
     * @return Periodo
     */
    public function setNumPeriodo($numPeriodo)
    {
        $this->numPeriodo = $numPeriodo;
    
        return $this;
    }

    /**
     * Get numPeriodo
     *
     * @return integer 
     */
    public function getNumPeriodo()
    {
        return $this->numPeriodo;
    }

    /**
     * Set anhoCorriente
     *
     * @param integer $anhoCorriente
     * @return Periodo
     */
    public function setAnhoCorriente($anhoCorriente)
    {
        $this->anhoCorriente = $anhoCorriente;
    
        return $this;
    }

    /**
     * Get anhoCorriente
     *
     * @return integer 
     */
    public function getAnhoCorriente()
    {
        return $this->anhoCorriente;
    }

    /**
     * Set estaAbierto
     *
     * @param integer $estaAbierto
     * @return Periodo
     */
    public function setEstaAbierto($estaAbierto)
    {
        $this->estaAbierto = $estaAbierto;
    
        return $this;
    }

    /**
     * Get estaAbierto
     *
     * @return integer 
     */
    public function getEstaAbierto()
    {
        return $this->estaAbierto;
    }

    /**
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return Periodo
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    
        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     * @return Periodo
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    
        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime 
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }
}
