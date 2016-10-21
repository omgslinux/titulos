<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Form\FundLinksType;

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
     * @return FundLinksType
     */
    public function setLinktype($type)
    {
        $this->linktype = $linktype;

        return $this;
    }

    /**
     * Get linktype
     *
     * @return FundLinksType
     */
    public function getLinkype()
    {
        return $this->linktype;
    }

    public function __toString()
    {
        return $this->getLinkype();
    }
}
