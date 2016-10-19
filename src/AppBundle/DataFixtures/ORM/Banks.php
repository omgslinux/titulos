<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
// use AppBundle\Entity\FundManagers;

class BanksLoader extends AbstractFixture implements OrderedFixtureInterface
{
    private $fieldlist;
    private $order=10;
    private $table;

    private $csvfile;

    public function getOrder()
    {
        return $this->order;
    }

    public function load(ObjectManager $manager)
    {
        $fieldlist = 'shortname,longname';
        $table = 'banks';
        $this->manage($fieldlist,$table);
        $this->dump2bd($manager);
    }

    public function manage($fieldlist,$table,$csvfile = null)
    {
        $this->fieldlist=$fieldlist;
        $this->table = $table;
        if (is_null($csvfile))
        {
            $csvfile = "$table";
        }
        $this->csvfile = "${csvfile}.csv";
    }

    public function dump2bd(ObjectManager $manager)
    {
        $fields=explode(',',$this->fieldlist);
        print_r($fields);
        $records = $this->readcsv($this->csvfile);
        $counter=0;
        // print_r($funds);
        foreach ($records as $recordkey => $record) {
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
