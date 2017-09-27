<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\BankCategory;

/**
 * BankCategory
 *
 * @ORM\Table(name="bankcategory")
 * @ORM\Entity
 */
class BankCategory
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
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Banks", mappedBy="category")
     */
    private $banks;



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
     * Set name
     *
     * @param string $name
     *
     * @return BankCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get banks
     *
     * @return ArrayCollection
     */
    public function getBanks()
    {
        return $this->banks;
    }

    /**
     * Add bank
     *
     * @param Banks $bank
     *
     * @return BankCategory
     */
    public function addBank(Banks $bank)
    {
        $this->banks->add($bank);
        $bank->setFund($this);

        return $this;
    }

    /**
     * Remove link
     *
     * @param Banks $bank
     *
     * @return BankCategory
     */
    public function removeBank(Banks $bank)
    {
        $this->banks->removeElement($bank);

        return $this;
    }



    public function __toString()
    {
        return $this->getName();
    }
}
