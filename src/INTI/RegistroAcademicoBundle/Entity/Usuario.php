<?php

namespace INTI\RegistroAcademicoBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuario
 *
 * @ORM\Table(name="Usuario")
 * @ORM\Entity
 */
class Usuario implements AdvancedUserInterface, \Serializable
{
    /**
     * @var string
	 *
	 * @Assert\Length(
     *     min = "6",
     *     max = "50",
     *     minMessage = "El nombre de usuario por lo menos debe tener {{ limit }} caracteres de largo",
     *     maxMessage = "El nombre de usuario no puede tener más de {{ limit }} caracteres de largo"
     * )
     * @Assert\Regex(
     *     pattern="/^[A-Za-z0-9_-]{6,50}$/",
     *     message="El nombre de usuario solo puede ser una combinación letras mayúscula y minúsculas, números, _, - sin espacios en blanco"
     * )
     *
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $username;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = "8",
     *      max = "60",
     *      minMessage = "La contraseña del usuario por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "La contraseña del usuario no puede tener más de {{ limit }} caracteres de largo"
     * )
     * @Assert\Regex(
     *     pattern="/(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d){8,60}.+$)/",
     *     message="La contraseña de usuario debe contener por lo menos una letra en mayúscula, una letra en minúscula y un numero para ser segura"
     * )
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="rol", type="array", nullable=false)
     */
    private $rol;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean", nullable=true)
     */
    private $locked;

    /**
     * @var integer
     *
     * @ORM\Column(name="intents", type="integer", nullable=true)
     */
    private $intents;

    function __construct() {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->rol = array();
        $this->enabled = true;
        $this->locked = false;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Usuario
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function addRole($role)
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->rol, true)) {
            array_push($this->rol, $role);
        }

        return $this;
    }

    /**
     * Set rol
     *
     * @param array $rol
     * @return Usuario
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return array
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->rol;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Usuario
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     * @return Usuario
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set intents
     *
     * @param integer $intents
     * @return Usuario
     */
    public function setIntents($intents)
    {
        $this->intents = $intents;

        return $this;
    }

    /**
     * Get intents
     *
     * @return integer
     */
    public function getIntents()
    {
        return $this->intents;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->username
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->username
        ) = unserialize($serialized);
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
            return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
            return !$this->locked;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
            return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
}
