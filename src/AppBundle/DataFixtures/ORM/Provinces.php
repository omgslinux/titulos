<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Provinces;
use Appbundle\repository\ProvincesRepository;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

class ProvincesLoader extends ContainerAwareLoader implements OrderedFixtureInterface
{
    private $order = 1;
    private $csvfile;

    public function getOrder()
    {
        return $this->order;
    }

    public function load(ObjectManager $manager)
    {
        //$this->fieldlist = 'name';
        $this->csvfile = 'provinces.csv';

        $rootdir = $this->getParameter('csv_loaddir');
        $filename = $rootdir . '/' . $this->csvfile;
        $records = $this->get('app.readcsv')->readcsv($filename);
        $fields = array(
            'name' => true,
        );
        printf("fields: (%s)\n<br><br>", print_r($fields, true));

        $em = $this->getDoctrine()->getManager();
        foreach ($records as $recordkey => $record) {
            printf("recordkey: (%s)\n<br><br>", print_r($record, true));
            //$security = new Securities();
            $params=array(
                'fields' => $fields,
                'classname'  => 'Provinces',
                'row' => $record,
            );
            $province = $this->get('app.readcsv')->emdumprow($em, $params);
            //$bank->setFundbank($bank);
            $em->persist($province);
        }
        $em->flush();
    }

    public function emdump(ObjectManager $manager)
    {
        $this->records = $this->readcsv($this->csvfile);
        foreach ($this->records as $province) {
        // print_r($recordkey);
            $entity = new \AppBundle\Entity\Provinces();
            $entity->setName($province['name']);
            echo "Insertando: " . $entity->getName() . "\n";

            $manager->persist($entity);
            $manager->flush();
        }
    }

    public function qbdump(ObjectManager $manager)
    {
        $fields=explode(',', $this->fieldlist);
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
                if (in_array($value, $fields)) {
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
}
