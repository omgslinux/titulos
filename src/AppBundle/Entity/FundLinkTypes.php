<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Util\Slugger;

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
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $linktype;


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

    public function getSlugger()
    {
        return Slugger::getSlug($this->getLinktype() , '_');
    }

    public function __toString()
    {
        return $this->getLinktype();
    }
}
