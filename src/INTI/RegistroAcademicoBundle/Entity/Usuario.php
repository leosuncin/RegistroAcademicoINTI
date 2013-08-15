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
     * @ORM\Column(name="username", type="string", length=50, nullable=false)
     *
     * @Assert\Length(
     *      min = "8",
     *      max = "50",
     *      minMessage = "El nombre de usuario por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "El nombre de usuario no puede tener más de {{ limit }} caracteres de largo"
     *      )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     *
     * @Assert\Length(
     *      min = "8",
     *      max = "60",
     *      minMessage = "La contraseña del usuario por lo menos debe tener {{ limit }} caracteres de largo",
     *      maxMessage = "La contraseña del usuario no puede tener más de {{ limit }} caracteres de largo"
     *      )
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
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
     * @ORM\Column(name="lock", type="boolean", nullable=false)
     */
    private $lock;

    function __construct() {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->rol = array();
        $this->enabled = true;
        $this->lock = false;
    }

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
            $this->rol[] = $role;
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
     * Set lock
     *
     * @param boolean $lock
     * @return Usuario
     */
    public function setLock($lock)
    {
        $this->lock = $lock;

        return $this;
    }

    /**
     * Get lock
     *
     * @return boolean
     */
    public function getLock()
    {
        return $this->lock;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->password = "";
        $this->enabled = false;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id
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
            return !$this->lock;
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

    /**
     * Verifica el cambio de contraseña para el usuario
     *
     * @Assert\False(message = "La contraseña anterior es incorrecta")
     *
     * @return boolean
     */
    // public function isCorrectPassword($new_password)
    // {
    //     return $this->password == $new_password;
    // }
}