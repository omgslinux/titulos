<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FundTypes
 *
 * @ORM\Table(name="fundtypes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FundTypesRepository")
 */
class FundTypes
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
     * @ORM\Column(name="fundtype", type="string", length=50)
     */
    private $fundtype;


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
     * Set fundtype
     *
     * @param string $fundtype
     *
     * @return FundTypes
     */
    public function setFundtype($fundtype)
    {
        $this->fundtype = $fundtype;

        return $this;
    }

    /**
     * Get fundtype
     *
     * @return string
     */
    public function getFundtype()
    {
        return $this->fundtype;
    }

    public function __toString()
    {
        return $this->getFundtype();
    }
}
