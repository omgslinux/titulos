<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Funds;

/**
 * FundsExtra
 *
 * @ORM\Table(name="mortgagefunds")
 * @ORM\Entity
 */
class MortgageFunds
{
    /**
     * @var Funds
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Funds", inversedBy="mfund")
     */
    private $fund;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $openfund;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $numrecords;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $loansfirstpage;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $loanslastpage;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $fundpages;

    /**
     * @var binary
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $legible;

    /**
     * @var int
     *
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $brochure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $liqdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $extdate;

    /**
     * @var int
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $digitalizable;





    public function getDocpath()
    {
        return $this->getId()->getDocpath();
    }

    public function getFulldocpath()
    {
        return $this->getId()->getFulldocpath();
    }

    /**
     * Get id
     *
     * @return Funds
     */
    public function getId()
    {
        return $this->fund->getId();
    }

    public function getFundname()
    {
        return $this->fund->getFundname();
    }

    /**
     * Set fund
     *
     * @param Funds $fund
     *
     * @return FundsExtra
     */
    public function setFund(Funds $fund)
    {
        $this->fund = $fund;

        return $this;
    }

    /**
     * Set openfund
     *
     * @param boolean $openfund
     *
     * @return FundsExtra
     */
    public function setOpenfund($openfund)
    {
        $this->openfund = $openfund;

        return $this;
    }

    /**
     * Get openfund
     *
     * @return boolean
     */
    public function getOpenfund()
    {
        return $this->openfund;
    }

    /**
     * Set numrecords
     *
     * @param integer $numrecords
     *
     * @return FundsExtra
     */
    public function setNumrecords($numrecords)
    {
        $this->numrecords = $numrecords;

        return $this;
    }

    /**
     * Get numrecords
     *
     * @return int
     */
    public function getNumrecords()
    {
        return $this->numrecords;
    }

    /**
     * Set loansfirstpage
     *
     * @param integer $loansfirstpage
     *
     * @return Funds
     */
    public function setLoansfirstpage($loansfirstpage)
    {
        $this->loansfirstpage = $loansfirstpage;

        return $this;
    }

    /**
     * Get loansfirstpage
     *
     * @return int
     */
    public function getLoansfirstpage()
    {
        return $this->loansfirstpage;
    }

    /**
     * Set loanslastpage
     *
     * @param integer $loanslastpage
     *
     * @return Funds
     */
    public function setLoanslastpage($loanslastpage)
    {
        $this->loanslastpage = $loanslastpage;

        return $this;
    }

    /**
     * Get loanslastpage
     *
     * @return int
     */
    public function getLoanslastpage()
    {
        return $this->loanslastpage;
    }

    /**
     * Set fundpages
     *
     * @param integer $fundpages
     *
     * @return Funds
     */
    public function setFundpages($fundpages)
    {
        $this->fundpages = $fundpages;

        return $this;
    }

    /**
     * Get fundpages
     *
     * @return int
     */
    public function getFundpages()
    {
        return $this->fundpages;
    }

    /**
     * Set legible
     *
     * @param boolval $legible
     *
     * @return Funds
     */
    public function setLegible($legible)
    {
        $this->legible = $legible;

        return $this;
    }

    /**
     * Get legible
     *
     * @return boolval
     */
    public function getLegible()
    {
        return $this->legible;
    }

    /**
     * Set brochure
     *
     * @param boolval $brochure
     *
     * @return Funds
     */
    public function setBrochure($brochure)
    {
        $this->brochure = $brochure;

        return $this;
    }

    /**
     * Get brochure
     *
     * @return boolval
     */
    public function getBrochure()
    {
        return $this->brochure;
    }

    /**
     * Set liqdate
     *
     * @param \DateTime $liqdate
     *
     * @return Funds
     */
    public function setLiqdate($liqdate)
    {
        $this->liqdate = $liqdate;

        return $this;
    }

    /**
     * Get liqdate
     *
     * @return \DateTime
     */
    public function getLiqdate()
    {
        return $this->liqdate;
    }

    /**
     * Set extdate
     *
     * @param \DateTime $extdate
     *
     * @return Funds
     */
    public function setExtdate($extdate)
    {
        $this->extdate = $extdate;

        return $this;
    }

    /**
     * Get extdate
     *
     * @return \DateTime
     */
    public function getExtdate()
    {
        return $this->extdate;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Funds
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set digitalizable
     *
     * @param boolval $digitalizable
     *
     * @return Funds
     */
    public function setDigitalizable($digitalizable)
    {
        $this->digitalizable = $digitalizable;

        return $this;
    }

    /**
     * Get digitalizable
     *
     * @return boolval
     */
    public function getDigitalizable()
    {
        return $this->digitalizable;
    }
}
