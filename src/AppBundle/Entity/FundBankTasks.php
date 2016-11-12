<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Users;
use AppBundle\Entity\FundBanks;

/**
 * FundTasks
 *
 * @ORM\Table(name="fundbanktasks")
 * @ORM\Entity
 */
class FundBankTasks
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
     * @var FundBanks
     *
     * @ORM\ManyToOne(targetEntity="FundBanks", inversedBy="tasks")
     */
    private $fundbank;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     */
    private $user;

    /**
     * @var datetime
     *
     * @ORM\Column(type="datetime")
     */
    private $taskdate;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     */
    private $shortdescription;

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     */
    private $longdescription;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $finished;



    /**
     * Get id
     *
     * @return FundBankTasks
     */
    public function getId()
    {
        return $this->id;
    }

    public function getFundid()
    {
        return $this->getFundbank()->getFundid();
    }

    public function getFundname()
    {
        $this->getFundbank()->getFundname();
    }

    public function getBankid()
    {
        return $this->getFundbank()->getId();
    }

    public function getBankname()
    {
        return $this->getFundbank()->getBankname();
    }

    /**
     * Set fundbank
     *
     * @param FundBanks $fundbank
     *
     * @return FundBankTasks
     */
    public function setFundbank(FundBanks $fundbank = null)
    {
        $this->fundbank = $fundbank;

        return $this;
    }

    /**
     * Get fundbank
     *
     * @return FundBanks
     */
    public function getFundbank()
    {
        return $this->fundbank;
    }

    /**
     * Set user
     *
     * @param Users $user
     *
     * @return FundBankTasks
     */
    public function setUser(Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set taskdate
     *
     * @param DateTime $taskdate
     *
     * @return FundBankTasks
     */
    public function setTaskdate($taskdate)
    {
        $this->taskdate = $taskdate;

        return $this;
    }

    /**
     * Get taskdate
     *
     * @return DateTime
     */
    public function getTaskdate()
    {
        return $this->taskdate;
    }

    /**
     * Set shortdescription
     *
     * @param string $description
     *
     * @return FundBankTasks
     */
    public function setShortdescription($shortdescription)
    {
        $this->shortdescription = $shortdescription;

        return $this;
    }

    /**
     * Get shortdescription
     *
     * @return string
     */
    public function getShortdescription()
    {
        return $this->shortdescription;
    }

    /**
     * Set longdescription
     *
     * @param text $longdescription
     *
     * @return FundBankTasks
     */
    public function setLongdescription($longdescription)
    {
        $this->longdescription = $longdescription;

        return $this;
    }

    /**
     * Get longdescription
     *
     * @return text
     */
    public function getLongdescription()
    {
        return $this->longdescription;
    }

    /**
     * Set finished
     *
     * @param boolean $finished
     *
     * @return FundBankTasks
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return boolean
     */
    public function getFinished()
    {
        return $this->finished;
    }



    public function __toString()
    {
        return $this->getDescription();
    }
}
