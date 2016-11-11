<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Roles;
use AppBundle\Entity\Users;

/**
 * Roles
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity
 */
class Roles
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
    private $name;

    /**
    * @var description
    *
    * @ORM\Column(type="string",length=64)
    */
    private $description;

    /**
    * @var ArrayCollection
    *
    * @ORM\OneToMany(targetEntity="Users", mappedBy="rol")
    */
    private $users;

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
     * Set name
     *
     * @param string $name
     *
     * @return Roles
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Roles
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get users
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add user
     *
     * @param User $user
     *
     * @return Roles
     */
    public function addUser(Users $user)
    {
        $this->users->add($user);
        $user->setTask($this);

        return $this;
    }

    /**
     * Remove user
     *
     * @param Users $user
     *
     * @return Roles
     */
    public function removeUser(Users $user)
    {
        $this->users->removeElement($user);

        return $this;
    }



    public function __toString()
    {
        return $this->getName();
    }
}
