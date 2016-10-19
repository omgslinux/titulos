<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Funds;
use AppBundle\Entity\Banks;
use AppBundle\Entity\LoanTypes;

/**
 * FundBanks
 *
 * @ORM\Table(name="fundbanks")
 * @ORM\Entity
 */
class FundBanks
{
    /**
     * @var \Funds
     *
     * @ORM\Id
     * @ORM\Column(name="fund_id")
     * @ORM\ManyToOne(targetEntity="Funds")
     */
    private $fund;

    /**
     * @var \Banks
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Banks")
     */
    private $bank;

    /**
     * @var \LoanTypes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="LoanTypes")
     */
    private $loantype;

    /**
    * @var count
    *
    * @ORM\Column(type="integer",nullable=false)
    */
    private $count;


    /**
     * Set fund
     *
     * @param \Funds $fund
     *
     * @return FundBanks
     */
    public function setFund(\Funds $fund = null)
    {
        $this->fund = $fund;

        return $this;
    }

    /**
     * Get fund
     *
     * @return \FundBanks
     */
    public function getFund()
    {
        return $this->fund;
    }

    /**
     * Set bank
     *
     * @param \Banks $bank
     *
     * @return FundBanks
     */
    public function setBank(\Banks $bank = null)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get bank
     *
     * @return \Banks
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set loantype
     *
     * @param \LoanTypes $loantype
     *
     * @return FundLinks
     */
    public function setLoantype(\LoanTypes $loantype = null)
    {
        $this->loantype = $loantype;

        return $this;
    }

    /**
     * Get loantype
     *
     * @return \LoanTypes
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
