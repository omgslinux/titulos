<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Gestoras;
use AppBundle\Entity\MortgageFunds;
use AppBundle\Entity\FundTypes;

/**
 * Funds
 *
 * @ORM\Table(name="funds", indexes={@ORM\Index(name="fk_funds_1_idx", columns={"gestoras_id"}), @ORM\Index(name="fk_funds_2_idx", columns={"fundtype_id"}) })
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
     * @var \Gestoras
     *
     * @ORM\ManyToOne(targetEntity="Gestoras")
     */
    private $gestoras;

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
     * @ORM\Column(name="constdate", type="datetime")
     */
    private $constdate;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $amount;



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
     * Set gestoras
     *
     * @param \AppBundle\Entity\Gestoras $gestoras
     *
     * @return Funds
     */
    public function setGestoras(\AppBundle\Entity\Gestoras $gestoras = null)
    {
        $this->gestoras = $gestoras;

        return $this;
    }

    /**
     * Get gestoras
     *
     * @return \AppBundle\Entity\Gestoras
     */
    public function getGestora()
    {
        return $this->gestoras;
    }

    /**
     * Set fundtype
     *
     * @param \AppBundle\Entity\FundTypes $fundtype
     *
     * @return Funds
     */
    public function setFundtype(\AppBundle\Entity\FundTypes $fundtype = null)
    {
        $this->fundtype = $fundtype;

        return $this;
    }

    /**
     * Get fundtype
     *
     * @return \AppBundle\Entity\FundTypes
     */
    public function getFundtype()
    {
        return $this->fundtype;
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
     * @return \AppBundle\Entity\MortgageFunds
     */
    public function getNumrecords()
    {
        return MortgageFunds::numrecords();
    }


    /**
     * Get paginicio
     *
     * @return \AppBundle\Entities\MortgageFunds
     */
    public function getPaginicio()
    {
        return $this->paginicio;
    }

    /**
     * Get pagfin
     *
     * @return \AppBundle\Entity\MortgageFunds
     */
    public function getPagfin()
    {
        return $this->pagfin;
    }

    /**
     * Get legible
     *
     * @return \AppBundle\Entity\MortgageFunds
     */
    public function getLegible()
    {
        return $this->legible;
    }

    /**
     * Get folleto
     *
     * @return \AppBundle\Entity\MortgageFunds
     */
    public function getFolleto()
    {
        return $this->folleto;
    }

    /**
     * Get liqdate
     *
     * @return \AppBundle\Entity\MortgageFunds
     */
    public function getLiqdate()
    {
        return $this->liqdate;
    }

    /**
     * Get extdate
     *
     * @return \AppBundle\Entity\MortgageFunds
     */
    public function getExtdate()
    {
        return $this->extdate;
    }

    /**
     * Get digitalizable
     *
     * @return \AppBundle\Entity\MortgageFunds
     */
    public function getDigitalizable()
    {
        return $this->digitalizable;
    }

    public function __toString()
    {
        return $this->getFundname();
    }
}
