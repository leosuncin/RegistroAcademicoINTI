<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Periodo
 *
 * @ORM\Table(name="Periodo")
 * @ORM\Entity
 */
class Periodo
{
	/**
	 * @var integer
	 *
	 *
	 * @ORM\Column(name="periodo", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 */
	private $periodo;

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
	 * @ORM\Column(name="en_curso", type="boolean", nullable=false)
	 */
	private $enCurso;

	/**
	 * @var \Anho
	 *
	 * @ORM\ManyToOne(targetEntity="Anho")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="Anho", referencedColumnName="anho")
	 * })
	 */
	private $anho;



	/**
	 * Get periodo
	 *
	 * @return integer
	 */
	public function getPeriodo()
	{
		return $this->periodo;
	}

	/**
	 * Set Periodo
	 *
	 * @param integer $periodo
	 * @return Periodo
	 */

	public function setPeriodo($periodo)
	{
		$this->periodo=$periodo;
		return $this;
	}

	/**
	 * Set inicio
	 *
	 * @param \DateTime $inicio
	 * @return Periodo
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
	 * @return Periodo
	 */
	public function setFin($fin)
	{
		if($fin > $this->inicio)
			$this->fin = null;
		else
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
	 * Set enCurso
	 *
	 * @param boolean $enCurso
	 * @return Periodo
	 */
	public function setEnCurso($enCurso)
	{
		$this->enCurso = $enCurso;

		return $this;
	}

	/**
	 * Get enCurso
	 *
	 * @return boolean
	 */
	public function getEnCurso()
	{
		return $this->enCurso;
	}

	/**
	 * Set anho
	 *
	 * @param \INTI\RegistroAcademicoBundle\Entity\Anho $anho
	 * @return Periodo
	 */
	public function setAnho(\INTI\RegistroAcademicoBundle\Entity\Anho $anho = null)
	{
		$this->anho = $anho;

		return $this;
	}

	/**
	 * Get anho
	 *
	 * @return \INTI\RegistroAcademicoBundle\Entity\Anho
	 */
	public function getAnho()
	{
		return $this->anho;
	}
}
