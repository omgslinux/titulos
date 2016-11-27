<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Funds;
use AppBundle\Util\Slugger;

/**
 * FundLinks
 *
 * @ORM\Table(name="fundlinks")
 * @ORM\Entity
 */
class FundLinks
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
     * @ORM\ManyToOne(targetEntity="Funds", inversedBy="links")
     */
    private $fund;

    /**
     * @var FundLinkTypes
     *
     * @ORM\ManyToOne(targetEntity="FundLinkTypes", inversedBy="links")
     */
    private $linktype;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var url
     *
     * @ORM\Column(name="URL", type="string", length=256, nullable=false)
     */
    private $url;


    /**
     * Get id
     *
     * @return FundLinks
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
     * @return FundLinks
     */
    public function setFund(Funds $fund)
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

    /**
     * Set linktype
     *
     * @param FundLinkTypes $linktype
     *
     * @return FundLinks
     */
    public function setLinktype(FundLinkTypes $linktype)
    {
        $this->linktype = $linktype;

        return $this;
    }

    /**
     * Get linktype
     *
     * @return FundLinkTypes
     */
    public function getLinktype()
    {
        return $this->linktype;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return FundLinks
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set url
     *
     * @param url $url
     *
     * @return FundLinks
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }




    public function __toString()
    {
        return $this->getDescription();
    }

    public function getFundid()
    {
        return $this->fund->getId();
    }

    public function getLinktypeid()
    {
        return $this->getLinktype()->getId();
    }

    public function getFundname()
    {
        return $this->getFund()->getFundname();
    }

    public function getSlugger($slugger = false)
    {
        if ($slugger===false) {
            $slugger = $this->getFundname();
        }
        return Slugger::getSlug($slugger, '_');
    }

    public function getFullSlugger()
    {
        return $this->getFund()->getFullSlugger() . '/' . $this->getSlugger();
    }


    public function getDocpath($linktype = 1)
    {
        return $this->getFund()->getFullSlugger() . '/' . $linktype;
    }

    public function getFulldocpath($linktype = false, $filename = false)
    {
        if ($linktype===false) {
            $linktype=$this->getLinktypeid();
        }
        // $suffix='_' . strtolower($this->getFundbank()->getLoanTypeAbbreviation());
        switch ($linktype) {
            case '6':
                // unclean csv
                $extension='.pdf.csv';
                break;
            case '7':
                # clean csv
                $extension='.csv';
                break;
            default:
                # code...
                $extension='.pdf';
                $suffix='';
                break;
        }
        $filename = $this->getSlugger($filename);// . $suffix;
        return $this->getDocpath($linktype) . '/' . $filename . $extension;
    }

    /*
    * Funciones específicas para linktypes
    */
    public function getBrochurepath()
    {
        return $this->getDocpath(2);
    }

    public function getFullbrochurepath()
    {
        return $this->getFulldocpath(2);
    }

    public function getAnnexlistpath()
    {
        return $this->getDocpath(3);
    }

    public function getFullannexlistpath()
    {
        return $this->getFulldocpath(3);
    }

    public function getLiqregpath()
    {
        return $this->getDocpath(4);
    }

    public function getFullliqregpath()
    {
        return $this->getFulldocpath(4);
    }

    public function getExtregpath()
    {
        return $this->getDocpath(5);
    }

    public function getFullextegpath()
    {
        return $this->getFulldocpath(5);
    }

    public function getUncleancsvpath()
    {
        return $this->getDocpath(6);
    }

    public function getFulluncleancsvpath()
    {
        return $this->getFulldocpath(6, $this->getLoadFilename());
    }

    public function getCleancsvpath()
    {
        return $this->getDocpath(7);
    }

    public function getFullcleancsvpath($filename)
    {
        return $this->getFulldocpath(7, $filename);
    }

    public function getFactspath()
    {
        return $this->getDocpath(8);
    }

    public function getFullfactspath()
    {
        return $this->getFulldocpath(8);
    }
}
