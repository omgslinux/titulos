<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Cities;
use AppBundle\Entity\Provinces;
use AppBundle\Entity\InterestRates;

/**
 * InterestRates
 *
 * @ORM\Table(name="interestrates")
 * @ORM\Entity
 */
class InterestRates
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
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $interestdate;

    /**
     * @var decimal
     *
     * @ORM\Column(type="decimal", precision=5, scale=3)
     */
    private $euribor;

    /**
     * @var decimal
     *
     * @ORM\Column(type="decimal", precision=5, scale=3)
     */
    private $irph;

    /**
     * @var decimal
     *
     * @ORM\Column(type="decimal", precision=5, scale=3)
     */
    private $legalinterest;


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
     * Set interestdate
     *
     * @param string $interestdate
     *
     * @return InterestRates
     */
    public function setInterestDate($interestdate)
    {
        $this->interestdate = $interestdate;

        return $this;
    }

    /**
     * Get interestdate
     *
     * @return date
     */
    public function getInterestDate()
    {
        return $this->interestdate;
    }

    /**
     * Set euribor
     *
     * @param decimal $euribor
     *
     * @return InterestRates
     */
    public function setEuribor($euribor)
    {
        $this->euribor = $euribor;

        return $this;
    }

    /**
     * Get euribor
     *
     * @return InterestRates
     */
    public function getEuribor()
    {
        return $this->euribor;
    }

    /**
     * Set irph
     *
     * @param decimal $irph
     *
     * @return InterestRates
     */
    public function setIRPH($irph)
    {
        $this->irph = $irph;

        return $this;
    }

    /**
     * Get irph
     *
     * @return InterestRates
     */
    public function getIRPH()
    {
        return $this->irph;
    }

    /**
     * Set legalinterest
     *
     * @param decimal $legalinterest
     *
     * @return InterestRates
     */
    public function setLegalInterest($legalinterest)
    {
        $this->legalinterest = $legalinterest;

        return $this;
    }

    /**
     * Get legalinterest
     *
     * @return InterestRates
     */
    public function getLegalInterest()
    {
        return $this->legalinterest;
    }

    public function __toString()
    {
        return $this->getInterestDate();
    }
}
