<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use AppBundle\Entity\Funds;
use AppBundle\Entity\Banks;
use AppBundle\Entity\LoanTypes;
use AppBundle\Util\Slugger;

/**
 * FundBanks
 *
 * @ORM\Table(name="fundbanks",uniqueConstraints={@UniqueConstraint(name="fundbankloan_unique", columns={"fund_id", "bank_id", "loantype_id"})})
 * @ORM\Entity
 */
class FundBanks
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
     * @var Funds
     *
     * @ORM\ManyToOne(targetEntity="Funds")
     */
    private $fund;

    /**
     * @var Banks
     *
     * @ORM\ManyToOne(targetEntity="Banks")
     * @ORM\OrderBy({"shortname" = "ASC"})
     */
    private $bank;

    /**
     * @var LoanTypes
     *
     * @ORM\ManyToOne(targetEntity="LoanTypes")
     */
    private $loantype;

    /**
    * @var count
    *
    * @ORM\Column(type="integer",nullable=false)
    */
    private $count;

    public function __construct(Funds $fund)
    {
        $this->setFund($fund);
    }

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
     * Set fund
     *
     * @param Funds $fund
     *
     * @return FundBanks
     */
    public function setFund(Funds $fund = null)
    {
        $this->fund = $fund;

        return $this;
    }

    /**
     * Get fund
     *
     * @return Funds
     */
    public function getFund()
    {
        return $this->fund;
    }

    public function getFundid()
    {
        return $this->getFund()->getId();
    }

    public function getFundname()
    {
        return $this->getFund()->getFundname();
    }

    public function getBankname()
    {
        return $this->getBank()->getShortname();
    }

    public function getBankfilename()
    {
        if ($this->getBank()->getAcronym() != 'X') {
            return $this->getBank()->getAcronym();
        } else {
            return $this->getBank()->getShortname();
        }
    }

    public function getLoadFilename()
    {
        return Slugger::getSlug($this->getBankfilename().'_'.$this->getLoanTypeAbbreviation());
    }

    public function getLoanTypeAbbreviation()
    {
        return $this->getLoantype()->getAbbreviation();
    }


    /**
     * Set bank
     *
     * @param Banks $bank
     *
     * @return FundBanks
     */
    public function setBank(Banks $bank = null)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get bank
     *
     * @return Banks
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set loantype
     *
     * @param LoanTypes $loantype
     *
     * @return FundLinks
     */
    public function setLoantype(LoanTypes $loantype = null)
    {
        $this->loantype = $loantype;

        return $this;
    }

    /**
     * Get loantype
     *
     * @return LoanTypes
     */
    public function getLoantype()
    {
        return $this->loantype;
    }



    /**
     * Set count
     *
     * @param integer $count
     *
     * @return FundBanks
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

}
