<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Especialidad
 *
 * @ORM\Table(name="Especialidad")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields = "codigo",
 *     message = "Este código ya existe"
 * )
 */
class Especialidad
{
    /**
     * @var string
     *
     * @Assert\Length(
     *      min = "2",
     *      max = "5",
     *      minMessage = "El código de la especialidad por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El código de la especialidad no puede tener más de {{ limit }} caracteres de largo"
     * )
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z]*$/",
     *     message = "El código solo debe contener letras"
     * )
     * @ORM\Column(name="codigo", type="string", length=5, nullable=false, unique=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $codigo;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = "5",
     *      max = "100",
     *      minMessage = "El nombre de la especialidad por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El nombre de la especialidad no puede tener más de {{ limit }} caracteres de largo"
     * )
     * @Assert\Regex(
     *      pattern = "/^[A-Za-z]+(\s[A-Za-z]+)*$/",
	 *      message = "El nombre solo debe contener letras"
     * )
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Especialidad
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Especialidad
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