<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Roles;

/**
 * Cities
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     */
    private $login;

    /**
     * @var fullname
     *
     * @ORM\Column(type="string", length=64)
     */
    private $fullname;

    /**
     * @var password
     *
     * @ORM\Column(type="string",length=64)
     */
    private $password;

    /**
     * @var email
     *
     * @ORM\Column(type="string",length=64)
     */
    private $email;

    /**
    * @var \Roles
    *
    * @ORM\ManyToOne(targetEntity="Roles")
    */
    private $rol;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Users
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     *
     * @return Users
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set password
     *
     * @param password $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param email $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set rol
     *
     * @param \Roles $rol
     *
     * @return Cities
     */
    public function setRol(\Roles $rol = null)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \Roles
     */
    public function getRol()
    {
        return $this->rol;
    }


    public function __toString()
    {
        return $this->getFullname();
    }
}
