<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Provinces
 *
 * @ORM\Table(name="provinces")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProvincesRepository")
 */
class Provinces
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
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
    * @var ArrayCollection
    *
    * @ORM\OneToMany(targetEntity="Cities", mappedBy="province")
    */
    private $cities;


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
     * @return Provinces
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
     * Get cities
     *
     * @return ArrayCollection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Add city
     *
     * @param Cities $city
     *
     * @return Provinces
     */
    public function addCity(Cities $city)
    {
        $this->cities->add($city);
        $city->setProvince($this);

        return $this;
    }



    public function __toString()
    {
        return $this->getName();
    }
}
