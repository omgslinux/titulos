<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Laws;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * LawType
 *
 * @ORM\Table(name="lawtype")
 * @ORM\Entity
 */
class LawType
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
     * @ORM\Column(type="string", length=32)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32)
     */
    private $longdesc;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Laws", mappedBy="lawtype")
     */
    private $laws;


    public function __construct()
    {
         $this->laws = new ArrayCollection();
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
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return LawType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get longdesc
     *
     * @return string
     */
    public function getLongDesc()
    {
        return $this->longdesc;
    }

    /**
     * Set longdesc
     *
     * @param string $longdesc
     *
     * @return LawType
     */
    public function setLongDesc($longdesc)
    {
        $this->longdesc = $longdesc;

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
     * @param Laws $law
     *
     * @return LawType
     */
    public function addLaw(Laws $law)
    {
        $this->laws->add($law);
        $law->setFund($this);

        return $this;
    }

    /**
     * Remove law
     *
     * @param Laws $law
     *
     * @return LawType
     */
    public function removeLaw(Laws $law)
    {
        $this->laws->removeElement($law);

        return $this;
    }




    public function __toString()
    {
        return $this->getType();
    }
}
