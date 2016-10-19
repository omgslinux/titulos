<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\FundTypes;

class FundTypesLoader extends AbstractFixture implements OrderedFixtureInterface
{
    private $order = 2;
    private $table;

    private $fieldlist;

    public function getOrder()
    {
        return $this->order;
    }
    public function load(ObjectManager $manager)
    {
        $this->table = 'fundtypes';
        $this->fieldlist = 'id,fundtype';
        $this->manage($manager);
    }

    public function manage(ObjectManager $manager)
    {
        $fundtypes = array(
            array('id' => '1', 'fundtype' => 'Hipotecario'),
            array('id' => '2', 'fundtype' => 'Otro'),
        );

        foreach ($fundtypes as $fundtype => $value) {
            $values = "'" . $value['id'] . "', '" . $value['fundtype']. "'";
            $sql = "INSERT INTO " . $this->table . " (". $this->fieldlist . ") VALUES ($values)";
            echo "Ejecutando $sql\n";
            $stmt = $manager->getConnection()->prepare($sql);
            $result = $stmt->execute();
        }
        //$manager->flush();
    }
}
