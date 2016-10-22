<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\FundManagers;
use AppBundle\Entity\MortgageFunds;
use AppBundle\Entity\FundTypes;
use AppBundle\Util\Slugger;

/**
 * Funds
 *
 * @ORM\Table(name="funds")
 * @ORM\Entity
 */
class Funds
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
     * @ORM\Column(name="fundname", type="string", length=100, nullable=false)
     */
    private $fundname;

    /**
     * @var \FundManagers
     *
     * @ORM\ManyToOne(targetEntity="FundManagers")
     */
    private $fundmanager;

    /**
     * @var \FundTypes
     *
     * @ORM\ManyToOne(targetEntity="FundTypes")
     */
    private $fundtype;

    /**
     * @var string
     *
     * @ORM\Column(name="nif", type="string", length=10, nullable=true)
     */
    private $nif;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="constdate", type="datetime",nullable=true)
     */
    private $constdate;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=16, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var text
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;



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
     * Set fundname
     *
     * @param string $fundname
     *
     * @return Funds
     */
    public function setFundname($fundname)
    {
        $this->fundname = $fundname;

        return $this;
    }

    /**
     * Get fundname
     *
     * @return string
     */
    public function getFundname()
    {
        return $this->fundname;
    }

    /**
     * Set fundmanager
     *
     * @param FundManagers $fundmanager
     *
     * @return Funds
     */
    public function setFundManager(FundManagers $fundmanager = null)
    {
        $this->fundmanager = $fundmanager;

        return $this;
    }

    /**
     * Get fundmanager
     *
     * @return FundManagers
     */
    public function getFundmanager()
    {
        return $this->fundmanager;
    }

    public function setFundManagerId($fundmanagerid)
    {
        $this->fundmanager = $fundmanagerid;
    }

    /**
     * Set fundtype
     *
     * @param FundTypes $fundtype
     *
     * @return Funds
     */
    public function setFundtype(FundTypes $fundtype = null)
    {
        $this->fundtype = $fundtype;

        return $this;
    }

    /**
     * Get fundtype
     *
     * @return FundTypes
     */
    public function getFundtype()
    {
        return $this->fundtype;
    }

    public function setFundTypeId($fundtypeid)
    {
        $this->fundtype = $fundtypeid;
    }

    /**
     * Set nif
     *
     * @param string $nif
     *
     * @return Funds
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * Get nif
     *
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * Set constdate
     *
     * @param \DateTime $constdate
     *
     * @return Funds
     */
    public function setConstdate($constdate)
    {
        $this->constdate = $constdate;

        return $this;
    }

    /**
     * Get constdate
     *
     * @return \DateTime
     */
    public function getConstdate()
    {
        return $this->constdate;
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
     * Get numrecords
     *
     * @return MortgageFunds
     */
    public function getNumrecords()
    {
        return MortgageFunds::numrecords();
    }


    /**
     * Get paginicio
     *
     * @return MortgageFunds
     */
    public function getPaginicio()
    {
        return $this->paginicio;
    }

    /**
     * Get pagfin
     *
     * @return MortgageFunds
     */
    public function getPagfin()
    {
        return $this->pagfin;
    }

    /**
     * Get legible
     *
     * @return MortgageFunds
     */
    public function getLegible()
    {
        return $this->legible;
    }

    /**
     * Get folleto
     *
     * @return MortgageFunds
     */
    public function getFolleto()
    {
        return $this->folleto;
    }

    /**
     * Get liqdate
     *
     * @return MortgageFunds
     */
    public function getLiqdate()
    {
        return $this->liqdate;
    }

    /**
     * Get extdate
     *
     * @return MortgageFunds
     */
    public function getExtdate()
    {
        return $this->extdate;
    }

    /**
     * Get digitalizable
     *
     * @return MortgageFunds
     */
    public function getDigitalizable()
    {
        return $this->digitalizable;
    }

    /**
     * Set notes
     *
     * @param text $notes
     *
     * @return Funds
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return text
     */
    public function getNotes()
    {
        return $this->notes;
    }

    public function getSlugger()
    {
        return Slugger::getSlug($this->getFundname(),'_');
    }

    public function getFullSlugger()
    {
        // return Slugger::getSlug($this->getFundmanager(),'-'). '/'. Slugger::getSlug($this->getFundname(),'-');
        return $this->getFundmanager()->getSlugger(). '/'. $this->getSlugger();
    }


    public function __toString()
    {
        return $this->getFundname();
    }
}
