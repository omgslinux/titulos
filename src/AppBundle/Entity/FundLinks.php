<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundLinks;

/**
 * FundLinks
 *
 * @ORM\Table(name="fundlinks", indexes={@ORM\Index(name="fk_fundlinks_1_idx", columns={"id"}) })
 * @ORM\Entity
 */
class FundLinks
{
    /**
     * @var \Funds
     *
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\ManyToOne(targetEntity="Funds")
     */
    private $fund;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="URL", type="string", length=100, nullable=false)
     */
    private $url;


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
     * @param string $url
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

}
