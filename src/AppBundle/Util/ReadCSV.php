<?php

namespace AppBundle\Util;

class ReadCSV
{
    private $rootdir;
    private $url=array();
    private $basedir='../web/app/Resources/pdf/';
    private $path;

    public function setRootdir($rootdir)
    {
        $this->rootdir = $rootdir;
    }

    public function setBasedir($basedir)
    {
        $this->basedir = $basedir;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getFullbase()
    {
        return $this->rootdir . '/' . $this->basedir;
    }

    public function getFulldir()
    {
        return $this->getFullbase() . dirname($this->path) . '/';
    }

    public function readcsv($csvfile)
    {
        // print getcwd();
        print $this->getFulldir()."\n$csvfile\n";

        if (($handle = fopen($this->getFulldir()."$csvfile", "r")) !== false) {
            $headers = array();
            $data = array();
            $row = 0;
            while (($line = fgetcsv($handle, 1000, ",")) !== false) {
                $row++;
                $column = 0;
                if ($row === 1) {
                    $num = count($line);
                    echo "<p> $num fields in line $row: <br /></p>\n";
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
        } else {
            die(print_r($data));
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
