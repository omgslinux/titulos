<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\FundManagers;
use AppBundle\Entity\MortgageFunds;
use AppBundle\Entity\FundTypes;
use AppBundle\Entity\FundLaws;
use AppBundle\Entity\FundLinks;
use AppBundle\Util\Slugger;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $fundname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $fundlongname;

    /**
     * @var FundManagers
     *
     * @ORM\ManyToOne(targetEntity="FundManagers", inversedBy="funds")
     */
    private $fundmanager;

    /**
     * @var FundTypes
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
     * @var string
     *
     * @ORM\Column(type="string",length=64,nullable=true)
     */
    private $cnmvpdf;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToOne(targetEntity="MortgageFunds", mappedBy="fund")
     */
    private $mfund;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FundLinks", mappedBy="fund")
     */
    private $links;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FundBanks", mappedBy="fund")
     */
    private $banks;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FundLaws", mappedBy="fund")
     */
    private $laws;

    public function __construct()
    {
         $this->links = new ArrayCollection();
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
     * Set fundlongname
     *
     * @param string $fundlongname
     *
     * @return Funds
     */
    public function setFundlongname($fundlongname)
    {
        $this->fundlongname = $fundlongname;

        return $this;
    }

    /**
     * Get fundlongname
     *
     * @return string
     */
    public function getFundlongname()
    {
        return $this->fundlongname;
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

    /**
     * Set cnmvpdf
     *
     * @param string $cnmvpdf
     *
     * @return Funds
     */
    public function setCNMVPDF($cnmvpdf)
    {
        $this->cnmvpdf = $cnmvpdf;

        return $this;
    }

    /**
     * Get cnmvpdf
     *
     * @return string
     */
    public function getCNMVPDF()
    {
        return $this->cnmvpdf;
    }

    /**
     * Get mfund
     *
     * @return ArrayCollection
     */
    public function getMfund()
    {
        return $this->mfund;
    }

    /**
     * Add mfund
     *
     * @param MortgageFunds $mfund
     *
     * @return Funds
     */
    public function addMfund(MortgageFunds $mfund)
    {
        $this->mfund->add($mfund);
        $mfund->setFund($this);

        return $this;
    }

    /**
     * Remove fund
     *
     * @param MortgageFunds $fund
     *
     * @return Funds
     */
    public function removeFund(MortgageFunds $mfund)
    {
        $this->mfund->removeElement($mfund);

        return $this;
    }

    /**
     * Get links
     *
     * @return ArrayCollection
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Add links
     *
     * @param FundLinks $fundlink
     *
     * @return Funds
     */
    public function addLink(FundLinks $fundlink)
    {
        $this->links->add($fundlink);
        $fundlink->setFund($this);

        return $this;
    }

    /**
     * Remove links
     *
     * @param FundLinks $fundlink
     *
     * @return Funds
     */
    public function removeLink(FundLinks $fundlink)
    {
        $this->links->removeElement($fundlink);

        return $this;
    }

    /**
     * Get banks
     *
     * @return ArrayCollection
     */
    public function getBanks()
    {
        return $this->banks;
    }

    /**
     * Add banks
     *
     * @param FundBanks $bank
     *
     * @return Funds
     */
    public function addBank(FundBanks $fundbank)
    {
        $this->banks->add($fundbank);
        $fundbank->setFund($this);

        return $this;
    }

    /**
     * Remove banks
     *
     * @param FundBanks $fundbank
     *
     * @return Funds
     */
    public function removeBank(FundBanks $fundbank)
    {
        $this->banks->removeElement($fundbank);

        return $this;
    }

    /**
     * Get laws
     *
     * @return ArrayCollection
     */
    public function getLaws()
    {
        return $this->laws;
    }

    /**
     * Add law
     *
     * @param FundLaws $law
     *
     * @return Funds
     */
    public function addLaw(FundLaws $law)
    {
        $this->laws->add($law);
        $law->setFund($this);

        return $this;
    }

    /**
     * Remove law
     *
     * @param FundLaws $law
     *
     * @return Funds
     */
    public function removeLaw(FundLaws $law)
    {
        $this->laws->removeElement($law);

        return $this;
    }

    public function getCNMVLink()
    {
        return 'http://www.cnmv.es/Portal/Consultas/DatosEntidad.aspx?nif=' . $this->getNif();
    }

    public function getCNMVPDFLink()
    {
        if (!empty($this->getCNMVPDF())) {
            return 'http://www.cnmv.es/Portal/verDoc.axd?t={' . $this->getCNMVPDF() . '}';
        } else {
            return 'http://www.cnmv.es/Portal/Consultas/Folletos/AnotacionesCuenta.aspx?id=0&nif=' . $this->getNif();
        }
    }

    public function getSlugger()
    {
        return Slugger::getSlug($this->getFundname(), '_');
    }

    public function getFullSlugger()
    {
        // return Slugger::getSlug($this->getFundmanager(),'-'). '/'. Slugger::getSlug($this->getFundname(),'-');
        return $this->getFundmanager()->getSlugger(). '/'. $this->getSlugger();
    }

    public function getDocpath($linktype = 1)
    {
        return $this->getFullSlugger() . '/' . $linktype;
    }

    public function getFulldocpath($linktype = 1)
    {
        return $this->getDocpath($linktype) . '/' . $this->getSlugger() . '.pdf';
    }




    public function __toString()
    {
        return $this->getFundname();
    }
}
