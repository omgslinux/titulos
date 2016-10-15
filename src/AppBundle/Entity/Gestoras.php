<?php
// src/AppBundle/Entity/Gestoras.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
* @ORM\Entity
*/
class Gestoras
{
  /**
  * @ORM\Id
  * @ORM\Column(type="integer")
  * @ORM\GeneratedValue(strategy="AUTO") */
  protected $id;

  /**
  * @ORM\Column(type="string", length=20)
  */
  protected $shortname;

  /**
  * @ORM\Column(type="string", length=50)
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

  public function __toString()
  {
      return $this->getShortName();
  }

}
