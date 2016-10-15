<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var int
     *
     * @ORM\Column(name="fund_id", type="integer")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Funds")
     */
    private $fundId;

    /**
     * @var string
     *
     * @ORM\Column(name="credito", type="string", length=64)
     */
    private $credito;

    /**
     * @var int
     *
     * @ORM\Column(name="loantype_id", type="integer")
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LoanTypes")
     */
    private $loantypeId;

    /**
     * @var int
     *
     * @ORM\Column(name="bank_id", type="integer")
     */
    private $bankId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var int
     *
     * @ORM\Column(name="municipio_id", type="integer")
     */
    private $municipioId;

    /**
     * @var string
     *
     * @ORM\Column(name="loanamount", type="decimal", precision=10, scale=2)
     */
    private $loanamount;

    /**
     * @var int
     *
     * @ORM\Column(name="registration", type="integer", nullable=true)
     */
    private $registration;

    /**
     * @var int
     *
     * @ORM\Column(name="volume", type="integer", nullable=true)
     */
    private $volume;

    /**
     * @var int
     *
     * @ORM\Column(name="book", type="integer", nullable=true)
     */
    private $book;

    /**
     * @var int
     *
     * @ORM\Column(name="folio", type="integer", nullable=true)
     */
    private $folio;

    /**
     * @var string
     *
     * @ORM\Column(name="building", type="string", length=16, nullable=true)
     */
    private $building;

    /**
     * @var int
     *
     * @ORM\Column(name="page", type="integer")
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
     * Set fundId
     *
     * @param integer $fundId
     *
     * @return Securities
     */
    public function setFundId($fundId)
    {
        $this->fundId = $fundId;

        return $this;
    }

    /**
     * Get fundId
     *
     * @return int
     */
    public function getFundId()
    {
        return $this->fundId;
    }

    /**
     * Set credito
     *
     * @param string $credito
     *
     * @return Securities
     */
    public function setCredito($credito)
    {
        $this->credito = $credito;

        return $this;
    }

    /**
     * Get credito
     *
     * @return string
     */
    public function getCredito()
    {
        return $this->credito;
    }

    /**
     * Set loantypeId
     *
     * @param integer $loantypeId
     *
     * @return Securities
     */
    public function setLoantypeId($loantypeId)
    {
        $this->loantypeId = $loantypeId;

        return $this;
    }

    /**
     * Get loantypeId
     *
     * @return int
     */
    public function getLoantypeId()
    {
        return $this->loantypeId;
    }

    /**
     * Set bankId
     *
     * @param integer $bankId
     *
     * @return Securities
     */
    public function setBankId($bankId)
    {
        $this->bankId = $bankId;

        return $this;
    }

    /**
     * Get bankId
     *
     * @return int
     */
    public function getBankId()
    {
        return $this->bankId;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Securities
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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
     * Set municipioId
     *
     * @param integer $municipioId
     *
     * @return Securities
     */
    public function setMunicipioId($municipioId)
    {
        $this->municipioId = $municipioId;

        return $this;
    }

    /**
     * Get municipioId
     *
     * @return int
     */
    public function getMunicipioId()
    {
        return $this->municipioId;
    }

    /**
     * Set loanamount
     *
     * @param string $loanamount
     *
     * @return Securities
     */
    public function setLoanamount($loanamount)
    {
        $this->loanamount = $loanamount;

        return $this;
    }

    /**
     * Get loanamount
     *
     * @return string
     */
    public function getLoanamount()
    {
        return $this->loanamount;
    }

    /**
     * Set registration
     *
     * @param integer $registration
     *
     * @return Securities
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return int
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set volume
     *
     * @param integer $volume
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
     * @return int
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set book
     *
     * @param integer $book
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
     * @return int
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set folio
     *
     * @param integer $folio
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
     * @return int
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
