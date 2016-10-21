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
  protected $description;

  public function getId()
  {
     return $this->id;
  }

  public function setShortName($shortname)
  {
     $this->shortname = $shortname;
  }

  public function getShortName()
  {
     return $this->shortname;
  }

  public function setLongName($longname)
  {
     $this->longname = $longname;
  }

  public function getLongName()
  {
     return $this->longname;
  }

  public function setNif($nif)
  {
     $this->nif = $nif;
  }

  public function getNif()
  {
     return $this->nif;
  }

  public function setDescription($description)
  {
     $this->description = $description;
  }

  public function getDescription()
  {
     return $this->description;
  }

  public function getSlugger()
  {
      return Slugger::getSlug($this->getShortName(), '-');
  }

  public function __toString()
  {
      return $this->getShortName();
  }

}
