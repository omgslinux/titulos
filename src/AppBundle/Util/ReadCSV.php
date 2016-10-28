<?php

namespace AppBundle\Util;

class ReadCSV
{
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

    public function emdump(ObjectManager $manager)
    {
        $this->records = $this->readcsv($this->csvfile);
        foreach ($this->records as $value) {
            // echo "Insertando " . $value['city'] . " @@ " . $value['province'] ."\n";
            $entity = new Cities();
            $entity->setCity(addslashes($value['city']));
            //$eprovince = $manager->getRepository('AppBundle:Provinces')->findOneByName($value['province']);
            $eprovince = new Provinces();
            $eprovince->setName($value['province']);
            // echo "Provincia: " . $eprovince . "\n";
            $entity->setProvince($eprovince);

            $manager->persist($entity);
        }
        $manager->flush();
    }


}
