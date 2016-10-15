<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Gestoras;
use AppBundle\Entity\MortgageFunds;

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
     * @ORM\Column(name="gestoras_id", type="integer")
     * @ORM\ManyToOne(targetEntity="Gestoras")
     * })
     */
    private $gestora;

    /**
     * @var \FundTypes
     *
     * @ORM\Column(name="fundtype_id", type="integer")
     * @ORM\ManyToOne(targetEntity="FundTypes")
     */
    private $fundtype;

    /**
     * @var \MortgageFunds
     *
     * @ORM\Column(name="numregistros", type="integer")
     * @ORM\OneToOne(targetEntity="MortgageFunds")
     */
    private $numrecords;

    /**
     * @var int
     *
     * @ORM\Column(name="paginicio", type="integer")
     */
    private $paginicio;

    /**
     * @var int
     *
     * @ORM\Column(name="pagfin", type="integer")
     */
    private $pagfin;

    /**
     * @var binary
     *
     * @ORM\Column(name="legible", type="boolean", nullable=true)
     */
    private $legible;

    /**
     * @var int
     *
     * @ORM\Column(name="folleto", type="boolean")
     */
    private $folleto;

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
     * @var \DateTime
     *
     * @ORM\Column(name="liqdate", type="datetime", nullable=true)
     */
    private $liqdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="extdate", type="datetime", nullable=true)
     */
    private $extdate;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var int
     *
     * @ORM\Column(name="digitalizable", type="smallint", nullable=true)
     */
    private $digitalizable;



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
     * Set gestora
     *
     * @param \AppBundle\Entity\Gestoras $gestora
     *
     * @return Funds
     */
    public function setGestora(\AppBundle\Entity\Gestoras $gestora = null)
    {
        $this->gestora = $gestora;

        return $this;
    }

    /**
     * Get gestora
     *
     * @return \AppBundle\Entity\Gestoras
     */
    public function getGestora()
    {
        return $this->gestora;
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
     * Set numrecords
     *
     * @param \AppBundle\Entity\MortgageFunds $numrecords
     *
     * @return Funds
     */
    public function setNumrecords(\AppBundle\Entity\MortgageFunds $numrecords = null)
    {
        $this->numrecords = $numrecords;

        return $this;
    }

    /**
     * Get numrecords
     *
     * @return \AppBundle\Entities\MortgageFunds
     */
    public function getNumrecords()
    {
        return $this->numrecords;
    }

    /**
     * Set paginicio
     *
     * @param \AppBundle\Entities\MortgageFunds $paginicio
     *
     * @return Funds
     */
    public function setPaginicio(\AppBundle\Entities\MortgageFunds $paginicio = null)
    {
        $this->paginicio = $paginicio;

        return $this;
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
     * Set pagfin
     *
     * @param \AppBundle\Entities\MortgageFunds $pagfin
     *
     * @return Funds
     */
    public function setPagfin(\AppBundle\Entities\MortgageFunds $pagfin = null)
    {
        $this->pagfin = $pagfin;

        return $this;
    }

    /**
     * Get pagfin
     *
     * @return \AppBundle\Entities\MortgageFunds
     */
    public function getPagfin()
    {
        return $this->pagfin;
    }

    /**
     * Set legible
     *
     * @param \AppBundle\Entities\MortgageFunds $legible
     *
     * @return Funds
     */
    public function setLegible(\AppBundle\Entities\MortgageFunds $legible = null)
    {
        $this->legible = $legible;

        return $this;
    }

    /**
     * Get legible
     *
     * @return \AppBundle\Entities\MortgageFunds
     */
    public function getLegible()
    {
        return $this->legible;
    }

    /**
     * Set folleto
     *
     * @param \AppBundle\Entities\MortgageFunds $folleto
     *
     * @return Funds
     */
    public function setFolleto(\AppBundle\Entities\MortgageFunds $folleto = null)
    {
        $this->folleto = $folleto;

        return $this;
    }

    /**
     * Get folleto
     *
     * @return \AppBundle\Entities\MortgageFunds
     */
    public function getFolleto()
    {
        return $this->folleto;
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
     * Set liqdate
     *
     * @param \AppBundle\Entities\MortgageFunds $liqdate
     *
     * @return Funds
     */
    public function setLiqdate(\AppBundle\Entities\MortgageFunds $liqdate = null)
    {
        $this->liqdate = $liqdate;

        return $this;
    }

    /**
     * Get liqdate
     *
     * @return \AppBundle\Entities\MortgageFunds
     */
    public function getLiqdate()
    {
        return $this->liqdate;
    }

    /**
     * Set extdate
     *
     * @param \AppBundle\Entities\MortgageFunds $extdate
     *
     * @return Funds
     */
    public function setExtdate(\AppBundle\Entities\MortgageFunds $extdate = null)
    {
        $this->extdate = $extdate;

        return $this;
    }

    /**
     * Get extdate
     *
     * @return \AppBundle\Entities\MortgageFunds
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
     * @param \AppBundle\Entities\MortgageFunds $digitalizable
     *
     * @return Funds
     */
    public function setDigitalizable(\AppBundle\Entities\MortgageFunds $digitalizable = null)
    {
        $this->digitalizable = $digitalizable;

        return $this;
    }

    /**
     * Get digitalizable
     *
     * @return \AppBundle\Entities\MortgageFunds
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
