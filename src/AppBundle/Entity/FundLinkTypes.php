<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Slugger;
use AppBundle\Entity\FundLinkTypes;

/**
 * FundLinkTypes
 *
 * @ORM\Table(name="fundlinktypes")
 * @ORM\Entity
 */
class FundLinkTypes
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
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $internal;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $linktype;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="FundLinks", mappedBy="linktype")
     */
    private $links;



    /**
     * Get id
     *
     * @return FundLinkTypes
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set internal
     *
     * @param integer $internal
     *
     * @return FundLinkTypes
     */
    public function setInternal($internal)
    {
        $this->internal = $internal;

        return $this;
    }

    /**
     * Get internal
     *
     * @return FundLinkTypes
     */
    public function getInternal()
    {
        return $this->internal;
    }

    /**
     * Set linktype
     *
     * @param string $type
     *
     * @return FundLinkTypes
     */
    public function setLinktype($linktype)
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
     * Get links
     *
     * @return ArrayCollection
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Add link
     *
     * @param FundLinks $link
     *
     * @return FundLinkTypes
     */
    public function addLink(FundLinks $link)
    {
        $this->links->add($link);
        $fundlink->setFund($this);

        return $this;
    }

    /**
     * Remove link
     *
     * @param FundLinks $link
     *
     * @return FundLinkTypes
     */
    public function removeLink(FundLinks $link)
    {
        $this->links->removeElement($link);

        return $this;
    }


    public function getSlugger()
    {
        return Slugger::getSlug($this->getLinktype(), '_');
    }

    public function __toString()
    {
        return $this->getLinktype();
    }
}
