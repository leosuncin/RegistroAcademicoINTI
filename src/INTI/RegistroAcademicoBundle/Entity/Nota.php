<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use INTI\RegistroAcademicoBundle\Validator\Constraints as RegistroAcademicoAssert;

/**
 * Nota
 *
 * @ORM\Table(name="Nota")
 * @ORM\Entity
 */
class Nota
{
    /**
     * @var float
     *
     * @RegistroAcademicoAssert\Nota
     *
     * @ORM\Column(name="valor", type="float", nullable=false)
     */
    private $valor;

    /**
     * @var \Alumno
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Alumno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Alumno", referencedColumnName="NIE")
     * })
     */
    private $alumno;

    /**
     * @var \Materia
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Materia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Materia", referencedColumnName="id")
     * })
     */
    private $materia;

    /**
     * @var \Periodo
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Periodo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Periodo", referencedColumnName="periodo")
     * })
     */
    private $periodo;



    /**
     * Set valor
     *
     * @param float $valor
     * @return Nota
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set alumno
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\Alumno $alumno
     * @return Nota
     */
    public function setAlumno(\INTI\RegistroAcademicoBundle\Entity\Alumno $alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return \INTI\RegistroAcademicoBundle\Entity\Alumno
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set materia
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\Materia $materia
     * @return Nota
     */
    public function setMateria(\INTI\RegistroAcademicoBundle\Entity\Materia $materia)
    {
        $this->materia = $materia;

        return $this;
    }

    /**
     * Get materia
     *
     * @return \INTI\RegistroAcademicoBundle\Entity\Materia
     */
    public function getMateria()
    {
        return $this->materia;
    }

    /**
     * Set periodo
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\Periodo $periodo
     * @return Nota
     */
    public function setPeriodo(\INTI\RegistroAcademicoBundle\Entity\Periodo $periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return \INTI\RegistroAcademicoBundle\Entity\Periodo
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }
}