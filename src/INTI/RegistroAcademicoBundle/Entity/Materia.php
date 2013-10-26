<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materia
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Materia
{
    /**
     * @var integer
     * @Assert\Length(
	 * min = "5",
	 * max = "5",
	 * minMessage = "El campo debe tener minimo {{limit}} enteros",
	 * maxMessage = "El campo debe tener un maximo de {{limit}} enteros")
     * @ORM\Column(name="idMateria", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMateria;

    /**
     * @var string
     * @Assert\Length(
     *      min = "5",
     *      max = "100",
     *      minMessage = "El nombre de la materia por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El nombre de la materia no puede tener más de {{ limit }} caracteres de largo"
     * )
     *
     * @ORM\Column(name="nombre", type="string", length=45)
     */
    private $nombre;
	
	/**
	* Set idMateria
	* @param integer $idMateria
	* @return Materia
	*/
	public function setIdMateria($idMateria){
	$this->idMateria=$idMateria;
	return $this;
	
	}
	
    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdMateria()
    {
        return $this->idMateria;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Materia
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }
}
