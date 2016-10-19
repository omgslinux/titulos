<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Cities;
use AppBundle\Entity\Provinces;
use AppBundle\Repository\ProvincesRepository;

class CitiesLoader extends AbstractFixture implements OrderedFixtureInterface
{
    private $order = 3;
    private $fieldlist;
    private $table;
    private $csvfile;
    private $records=array();
    private $rawdump=false;

    public function getOrder()
    {
        return $this->order;
    }

    public function load(ObjectManager $manager)
    {
        $this->fieldlist = 'province_id,city';
        $this->table = 'cities';
        // print_r($fields);
        if ($this->rawdump) {
            $this->csvfile = $this->table.'.csv';
            $this->qbdump($manager);
        } else {
            $this->csvfile = 'city-province.csv';
            $this->emdump($manager);
        }
    }

    public function qbdump(ObjectManager $manager)
    {
        $this->records = $this->readcsv($this->csvfile);
        $counter=0;
        // print_r($funds);
        $fields=explode(',',$this->fieldlist);
        foreach ($this->records as $recordkey => $record) {
            // print_r($recordkey);
            $counter++;
            $values = '';
            $fcounter=count($fields);
            foreach ($fields as $field => $value) {
                echo "field: ($field), v: ($value), record[value]:" . $record[$value] . "\n";
                if (in_array($value, $fields ))
                {
                    $values .= "'" . $record["$value"] . "'";
                }
                $fcounter--;
                if ($fcounter>0) {
                    $values .= ', ';
                }
            }

            $sql = "INSERT INTO " . $this->table . " (". $this->fieldlist . ") VALUES ($values)";
            echo "Ejecutando $sql\n";
            $stmt = $manager->getConnection()->prepare($sql);
            $result = $stmt->execute();
        }
    }

    public function emdump(ObjectManager $manager)
    {
        $this->records = $this->readcsv($this->csvfile);
        foreach ($this->records as $value) {
            echo "Insertando " . $value['city'] . " @@ " . $value['province'] ."\n";
            $entity = new \AppBundle\Entity\Cities();
            $entity->setCity(addslashes($value['city']));
            //$eprovince = $manager->getRepository('AppBundle:Provinces')->findOneByName($value['province']);
            $eprovince = new Provinces;
            $eprovince->setName($value['province']);
            echo "Provincia: " . $eprovince . "\n";
            $entity->setProvince($eprovince);

            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function readcsv($csvfile)
    {
        // print getcwd();
        if (($handle = fopen('app/Resources/sql/'."$csvfile", "r")) !== FALSE) {
            $headers = array();
            $data = array();
            $row = 0;
            while (($line = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                $column = 0;
                if ( $row === 1 ) {
                    $num = count($line);
                    // echo "<p> $num fields in line $row: <br /></p>\n";
                    foreach ($line as $key) {
                        $headers[$column] = $key;
                        $column++;
                    }
                } else {
                    foreach ($line as $value) {
                        $data[$row]["{$headers[$column]}"] = $value;
                        $column++;
                    }
                }
            }
        }
        return $data;
    }
}
