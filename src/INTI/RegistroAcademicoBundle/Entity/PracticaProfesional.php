<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use INTI\RegistroAcademicoBundle\Validator\Constraints as RegistroAcademicoAssert;

/**
 * PracticaProfesional
 *
 * @ORM\Table(name="Practica_profesional")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields = {"alumno", "empresa"},
 *     message = "Ya existe un registro de esta practica profesional"
 * )
 */
class PracticaProfesional
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
     * @Assert\Choice(
     *     choices = {"M", "V"},
     *     message = "Escoja un turno valido"
     * )
     *
     * @ORM\Column(name="horario", type="string", length=1, nullable=false)
     */
    private $horario;

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
     * @var float
     *
     * @RegistroAcademicoAssert\Nota
     *
     * @ORM\Column(name="evaluacion", type="float", nullable=true)
     */
    private $evaluacion;

    /**
     * @var \Alumno
     *
     * @ORM\ManyToOne(targetEntity="Alumno")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Alumno", referencedColumnName="NIE")
     * })
     */
    private $alumno;

    /**
     * @var \Empresa
     *
     * @ORM\ManyToOne(targetEntity="Empresa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Empresa", referencedColumnName="nombre")
     * })
     */
    private $empresa;

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
     * Set horario
     *
     * @param string $horario
     * @return PracticaProfesional
     */
    public function setHorario($horario)
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * Get horario
     *
     * @return string
     */
    public function getHorario()
    {
        return $this->horario;
    }

    /**
     * Set inicio
     *
     * @param \DateTime $inicio
     * @return PracticaProfesional
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

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
     * @return PracticaProfesional
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
     * Set evaluacion
     *
     * @param float $evaluacion
     * @return PracticaProfesional
     */
    public function setEvaluacion($evaluacion)
    {
        $this->evaluacion = $evaluacion;

        return $this;
    }

    /**
     * Get evaluacion
     *
     * @return float
     */
    public function getEvaluacion()
    {
        return $this->evaluacion;
    }

    /**
     * Set alumno
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\Alumno $alumno
     * @return PracticaProfesional
     */
    public function setAlumno(\INTI\RegistroAcademicoBundle\Entity\Alumno $alumno = null)
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
     * Set empresa
     *
     * @param \INTI\RegistroAcademicoBundle\Entity\Empresa $empresa
     * @return PracticaProfesional
     */
    public function setEmpresa(\INTI\RegistroAcademicoBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \INTI\RegistroAcademicoBundle\Entity\Empresa
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }
}
