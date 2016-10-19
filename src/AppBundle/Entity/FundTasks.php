<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Users;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundTasks;

/**
 * FundTasks
 *
 * @ORM\Table(name="fundtasks")
 * @ORM\Entity
 */
class FundTasks
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
     * @var \Funds
     *
     * @ORM\ManyToOne(targetEntity="Funds")
     */
    private $fund;

    /**
     * @var \Users
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
     * @return \FundTasks
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fund
     *
     * @param \Funds $fund
     *
     * @return FundTasks
     */
    public function setFund($fund)
    {
        $this->fund = $fund;

        return $this;
    }

    /**
     * Get fund
     *
     * @return \Funds
     */
    public function getFund()
    {
        return $this->fund;
    }

    /**
     * Set user
     *
     * @param \Users $user
     *
     * @return FundTasks
     */
    public function setUser(\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Users
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
     * @return FundTasks
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
     * @return FundTasks
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
     * @return FundTasks
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
     * @return FundTasks
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
