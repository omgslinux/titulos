<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\FundBanks;
use AppBundle\Entity\Cities;

/**
 * Securities
 *
 * @ORM\Table(name="securities")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SecuritiesRepository")
 */
class Securities
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
     * @var FundBanks
     *
     * @ORM\ManyToOne(targetEntity="FundBanks")
     */
    private $fundbank;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $startdate;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @var Cities
     *
     * @ORM\ManyToOne(targetEntity="Cities")
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $volume;

    /**
     * @var int
     *
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $book;

    /**
     * @var int
     *
     * @ORM\Column(type="string", length=8,nullable=true)
     */
    private $folio;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8,nullable=true)
     */
    private $building;

    /**
     * @var int
     *
     * @ORM\Column(type="integer",nullable=true)
     */
    private $page;


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
     * Set fundbank
     *
     * @param FundBanks $fundbank
     *
     * @return Securities
     */
    public function setFundbank(FundBanks $fundbank = null)
    {
        $this->fundbank = $fundbank;

        return $this;
    }

    /**
     * Get fundbank
     *
     * @return FundBanks
     */
    public function getFundbank()
    {
        return $this->fundbank;
    }

    /**
     * Set startdate
     *
     * @param date $startdate
     *
     * @return Securities
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return date
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set amount
     *
     * @param decimal $amount
     *
     * @return Securities
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return decimal
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Securities
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set city
     *
     * @param Cities $city
     *
     * @return Securities
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
     * Set volume
     *
     * @param string $volume
     *
     * @return Securities
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return string
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set book
     *
     * @param string $book
     *
     * @return Securities
     */
    public function setBook($book)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return string
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set folio
     *
     * @param string $folio
     *
     * @return Securities
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio
     *
     * @return string
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set building
     *
     * @param string $building
     *
     * @return Securities
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * Set page
     *
     * @param integer $page
     *
     * @return Securities
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }
}
