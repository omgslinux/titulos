<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FundsExtra
 *
 * @ORM\Table(name="mortgagefunds")
 * @ORM\Entity
 */
class MortgageFunds
{
    /**
     * @var \Funds
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Funds")
     */
    private $fund;

    /**
     * @var int
     *
     * @ORM\Column(name="numrecords", type="integer")
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
     * @var int
     *
     * @ORM\Column(name="digitalizable", type="boolean", nullable=true)
     */
    private $digitalizable;



    /**
     * Get id
     *
     * @return \Funds
     */
    public function getId()
    {
        return $this->id;
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
     * Set paginicio
     *
     * @param integer $paginicio
     *
     * @return Funds
     */
    public function setPaginicio($paginicio)
    {
        $this->paginicio = $paginicio;

        return $this;
    }

    /**
     * Get paginicio
     *
     * @return int
     */
    public function getPaginicio()
    {
        return $this->paginicio;
    }

    /**
     * Set pagfin
     *
     * @param integer $pagfin
     *
     * @return Funds
     */
    public function setPagfin($pagfin)
    {
        $this->pagfin = $pagfin;

        return $this;
    }

    /**
     * Get pagfin
     *
     * @return int
     */
    public function getPagfin()
    {
        return $this->pagfin;
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
     * Set folleto
     *
     * @param boolval $folleto
     *
     * @return Funds
     */
    public function setFolleto($folleto)
    {
        $this->folleto = $folleto;

        return $this;
    }

    /**
     * Get folleto
     *
     * @return boolval
     */
    public function getFolleto()
    {
        return $this->folleto;
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
