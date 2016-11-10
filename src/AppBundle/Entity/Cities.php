<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Cities;
use AppBundle\Entity\Provinces;

/**
 * Cities
 *
 * @ORM\Table(name="cities")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CitiesRepository")
 */
class Cities
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
    private $city;

    /**
    * @var Provincies
    *
    * @ORM\ManyToOne(targetEntity="Provinces")
    */
    private $province;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Securities", mappedBy="city")
     */
    private $securities;


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
     * Set city
     *
     * @param string $city
     *
     * @return Cities
     */
    public function setCity($city)
    {
        $this->name = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set province
     *
     * @param Provinces $province
     *
     * @return Cities
     */
    public function setProvince(Provinces $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return Provinces
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Get securities
     *
     * @return ArrayCollection
     */
    public function getSecurities()
    {
        return $this->securities;
    }

    /**
     * Add security
     *
     * @param Securities $security
     *
     * @return Cities
     */
    public function addSecurity(Securities $security)
    {
        $this->securities->add($security);
        $security->setCity($this);

        return $this;
    }


    public function __toString()
    {
        return $this->getCity();
    }
}
