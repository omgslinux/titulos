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
     * @var \Funds
     *
     * @ORM\ManyToOne(targetEntity="Funds")
     */
    private $fund;

    /**
     * @var FundLinkTypes
     *
     * @ORM\ManyToOne(targetEntity="FundLinkTypes")
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
     * @ORM\Column(name="URL", type="string", length=100, nullable=false)
     */
    private $url;


    public function __construct(Funds $fund)
    {
        return $this->setFund($fund);
    }

    /**
     * Get id
     *
     * @return \FundLinks
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFundid()
    {
        return $this->fund->getId();
    }

    public function getFundname()
    {
        return $this->getFund()->getFundname();
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

    public function getSlugger()
    {
        return Slugger::getSlug($this->getDescription() ,'_');
    }

    public function getFullSlugger()
    {
        return $this->getFund()->getFullSlugger() . '/' . $this->getSlugger();
    }

}
