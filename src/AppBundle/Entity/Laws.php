<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Banks;
use AppBundle\Entity\Cities;
use AppBundle\Entity\LawType;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Laws
 *
 * @ORM\Table(name="laws")
 * @ORM\Entity
 */
class Laws
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
     * @ORM\Column(type="string", length=8)
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $lawdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $releasedate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $legalsincedate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     */
    private $shortname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $longname;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=128)
     */
    private $boe;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $contents;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $analysis;

    /**
     * @var LawTypes
     *
     * @ORM\ManyToOne(targetEntity="LawType", inversedBy="laws")
     */
    private $lawtype;



    public function __construct()
    {
        //$this->setReleaseDate('1980-01-01');
        //$this->setLawdate('1980-01-01');
        //$this->setLegalSinceDate('1980-01-01');
        $this->setBOE('http://boe.es/buscar/doc.php?id=BOE');
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
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Laws
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get lawdate
     *
     * @return \DateTime
     */
    public function getLawdate()
    {
        if (empty($this->lawdate)) {
            $this->lawdate = new \DateTime('1980-01-01');
        }
        return $this->lawdate;
    }

    /**
     * Set lawdate
     *
     * @param \DateTime $lawdate
     *
     * @return Laws
     */
    public function setLawdate($lawdate)
    {
        $this->lawdate = $lawdate;

        return $this;
    }

    /**
     * Get releasedate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
      if (empty($this->releasedate)) {
          $this->releasedate = new \DateTime('1980-01-01');
      }
        return $this->releasedate;
    }

    /**
     * Set releasedate
     *
     * @param \DateTime $releasedate
     *
     * @return Laws
     */
    public function setReleaseDate($releasedate)
    {
        $this->releasedate = $releasedate;

        return $this;
    }

    /**
     * Get legalsincedate
     *
     * @return \DateTime
     */
    public function getLegalSinceDate()
    {
      if (empty($this->legalsincedate)) {
          $this->legalsincedate = new \DateTime('1980-01-01');
      }
        return $this->legalsincedate;
    }

    /**
     * Set legalsincedate
     *
     * @param \DateTime $legalsincedate
     *
     * @return Laws
     */
    public function setLegalSinceDate($legalsincedate)
    {
        $this->legalsincedate = $legalsincedate;

        return $this;
    }

    /**
     * Set shortname
     *
     * @param string $shortname
     *
     * @return Laws
     */
    public function setShortname($shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * Get shortname
     *
     * @return string
     */
    public function getShortname()
    {
        return $this->shortname . ' ';
    }

    /**
     * Set longname
     *
     * @param string $longname
     *
     * @return Laws
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    /**
     * Get longname
     *
     * @return string
     */
    public function getLongname()
    {
        return $this->longname;
    }

    /**
     * Set notes
     *
     * @param text $notes
     *
     * @return Laws
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
     * Set boe
     *
     * @param text $boe
     *
     * @return Laws
     */
    public function setBOE($boe)
    {
        $this->boe = $boe;

        return $this;
    }

    /**
     * Get boe
     *
     * @return text
     */
    public function getBOE()
    {
        return $this->boe;
    }

    /**
     * Set contents
     *
     * @param text $contents
     *
     * @return Laws
     */
    public function setContents($contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get contents
     *
     * @return text
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Set analysis
     *
     * @param text $analysis
     *
     * @return Laws
     */
    public function setAnalysis($analysis)
    {
        $this->analysis = $analysis;

        return $this;
    }

    /**
     * Get analysis
     *
     * @return text
     */
    public function getAnalysis()
    {
        return $this->analysis;
    }

    /**
     * Set lawtype
     *
     * @param LawType $lawtype
     *
     * @return Laws
     */
    public function setLawtype(LawType $lawtype = null)
    {
        $this->lawtype = $lawtype;

        return $this;
    }

    /**
     * Get lawtype
     *
     * @return Laws
     */
    public function getLawtype()
    {
        return $this->lawtype;
    }



    public function __toString()
    {
        //return $this->getShortname();
        //return $this->getNumber() . '/'. $d->format("d");
        return $this->getNumber() . '/'. $this->getLawdate()->format('Y') . ' de ' . $this->getLawdate()->format('d'). ' de ' . $this->getLawdate()->format('F');
    }
}
