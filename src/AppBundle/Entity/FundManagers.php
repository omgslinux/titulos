<?php
// src/AppBundle/Entity/FundManagers.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\FundManagers;
use AppBundle\Util\Slugger;

/**
* FundManagers
*
* @ORM\Table(name="fundmanagers")
* @ORM\Entity
*/
class FundManagers
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO") */
    protected $id;

    /**
    * @ORM\Column(type="string", length=32)
    */
    protected $shortname;

    /**
    * @ORM\Column(type="string", length=64)
    */
    protected $longname;

    /**
    * @ORM\Column(type="string", length=10)
    */
    protected $nif;

    /**
    * @ORM\Column(type="string")
    */
    protected $address;

    /**
    * @ORM\Column(type="decimal",precision=16,scale=2,nullable=true)
    */
    protected $capitalsocial;

    /**
    * @ORM\Column(type="date",nullable=true)
    */
    protected $regdate;

    /**
    * @ORM\Column(type="string")
    */
    protected $description;



    public function getId()
    {
        return $this->id;
    }

    public function getCNMVUrl()
    {
        return 'http://www.cnmv.es/Portal/Consultas/FTA/SGFT.aspx?nif=' . $this->getNif();
    }

    public function setShortname($shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    public function getShortname()
    {
        return $this->shortname;
    }

    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    public function getLongname()
    {
        return $this->longname;
    }

    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    public function getNif()
    {
        return $this->nif;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setCapitalsocial($capitalsocial)
    {
          $this->capitalsocial = $capitalsocial;

          return $this;
    }

    public function getCapitalsocial()
    {
        return $this->capitalsocial;

        return $this;
    }

    public function setRegdate($regdate)
    {
        $this->regdate = $regdate;

        return $this;
    }

    public function getRegdate()
    {
        return $this->regdate;
    }
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getSlugger()
    {
        return Slugger::getSlug($this->getShortName(), '_');
    }

    public function __toString()
    {
        return $this->getShortName();
    }

}
