<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Banks;
use AppBundle\Entity\Cities;
use AppBundle\Entity\FundBanks;
use AppBundle\Entity\BankCategory;
use AppBundle\Repository\BanksRepository;

/**
 * Banks
 *
 * @ORM\Table(name="banks")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BanksRepository")
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
     * @ORM\Column(type="string", length=4)
     */
    private $becode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    private $shortname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     */
    private $longname;

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
     * @var Cities
     *
     * @ORM\ManyToOne(targetEntity="Cities")
     */
    private $city;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FundBanks", mappedBy="bank")
     * @ORM\OrderBy({"bank" = "ASC"})
     */
    private $fundbanks;

    /**
     * @var BankCategory
     *
     * @ORM\ManyToOne(targetEntity="BankCategory", inversedBy="banks")
     */
    private $category;



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
     * Set shortname
     *
     * @param string $shortname
     *
     * @return Banks
     */
    public function setShortname($shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * Get shortname
     *
     * @return string
     */
    public function getShortname()
    {
        return $this->shortname;
    }


    /**
     * Set becode
     *
     * @param string $becode
     *
     * @return Banks
     */
    public function setBeCode($becode)
    {
        $this->becode = $becode;

        return $this;
    }

    /**
     * Get becode
     *
     * @return string
     */
    public function getBeCode()
    {
        return $this->becode;
    }

    /**
     * Set longname
     *
     * @param string $longname
     *
     * @return Banks
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    /**
     * Get longname
     *
     * @return string
     */
    public function getLongname()
    {
        return $this->longname;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Banks
     */
    public function setAddress($address)
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
     * @param Cities $city
     *
     * @return Banks
     */
    public function setCity(Cities $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return Cities
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get fundbanks
     *
     * @return ArrayCollection
     */
    public function getFundbanks()
    {
        return $this->fundbanks;
    }

    /**
     * Add fundbank
     *
     * @param FundBanks $fundbank
     *
     * @return Banks
     */
    public function addFundbank(FundBanks $fundbank)
    {
        $this->fundbanks->add($fundbank);
        $fundbank->setBank($this);

        return $this;
    }

    /**
     * Remove fundbank
     *
     * @param FundBanks $fundbank
     *
     * @return Banks
     */
    public function removeFundbank(FundBanks $fundbank)
    {
        $this->fundbanks->removeElement($fundbank);

        return $this;
    }

    /**
     * Get category
     *
     * @return BankCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category
     *
     * @param BankCategory $category
     *
     * @return Banks
     */
    public function setCategory(BankCategory $category)
    {
        $this->category = $category;

        return $this;
    }



    public function __toString()
    {
        return $this->getShortname() . ($this->becode?' (' . $this->becode . ')':null);
    }
}
