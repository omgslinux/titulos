<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Banks;
use AppBundle\Entity\Cities;

/**
 * Banks
 *
 * @ORM\Table(name="banks")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BankRepository")
 */
class Banks
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16,nullable=false)
     */
    private $acronym;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var \Cities
     *
     * @ORM\ManyToOne(targetEntity="Cities")
     */
    private $city;



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
     * @return Banks
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get acronym
     *
     * @return string
     */
    public function getAcronym()
    {
        return $this->acronym;
    }

    /**
     * Set acronym
     *
     * @param string $acronym
     *
     * @return Banks
     */
    public function setAcronym($acronym)
    {
        $this->acronym = $acronym;

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
     * Set address
     *
     * @param string $address
     *
     * @return Banks
     */
    public function setAdress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param \Cities $city
     *
     * @return Banks
     */
    public function setCity(\Cities $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Cities
     */
    public function getCity()
    {
        return $this->city;
    }


    public function __toString()
    {
        return $this->getName();
    }

}
