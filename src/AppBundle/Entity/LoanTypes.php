<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LoanTypes
 *
 * @ORM\Table(name="loan_types")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoanTypesRepository")
 */
class LoanTypes
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
     * @ORM\Column(name="LoanType", type="string", length=255, unique=true)
     */
    private $loanType;

    /**
     * @var string
     *
     * @ORM\Column(name="Abbreviation", type="string", length=255, nullable=true)
     */
    private $abbreviation;


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
     * Set loanType
     *
     * @param string $loanType
     *
     * @return LoanTypes
     */
    public function setLoanType($loanType)
    {
        $this->loanType = $loanType;

        return $this;
    }

    /**
     * Get loanType
     *
     * @return string
     */
    public function getLoanType()
    {
        return $this->loanType;
    }

    /**
     * Set abbreviation
     *
     * @param string $abbreviation
     *
     * @return LoanTypes
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * Get abbreviation
     *
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }
}

