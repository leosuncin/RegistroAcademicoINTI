<?php

namespace INTI\RegistroAcademicoBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Periodo
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
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
}
