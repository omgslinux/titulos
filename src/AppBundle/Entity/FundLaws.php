<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Laws;
use AppBundle\Entity\Funds;

/**
 * FundLaws
 *
 * @ORM\Table(name="fundlaws")
 * @ORM\Entity
 */
class FundLaws
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
     * @var Laws
     *
     * @ORM\ManyToOne(targetEntity="Laws")
     */
    private $law;

    /**
     * @var Fund
     *
     * @ORM\ManyToOne(targetEntity="Funds", inversedBy="laws")
     */
    private $fund;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $notes;


    public function __construct(Funds $fund = null)
    {
        $this->fund = $fund;
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
     * Set law
     *
     * @param Laws $law
     *
     * @return FundLaws
     */
    public function setLaw(Laws $law)
    {
        $this->law = $law;

        return $this;
    }

    /**
     * Get law
     *
     * @return Laws
     */
    public function getLaw()
    {
        return $this->law;
    }

    /**
     * Set fund
     *
     * @param Funds $fund
     *
     * @return FundLaws
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
     * Set notes
     *
     * @param string $notes
     *
     * @return FundLaws
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return FundLaws
     */
    public function getNotes()
    {
        return $this->notes;
    }

    public function __toString()
    {
        return $this->getLaw()->getShortname();
    }
}
