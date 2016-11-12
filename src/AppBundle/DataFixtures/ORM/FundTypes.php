<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\FundTypes;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

class FundTypesLoader extends ContainerAwareLoader implements OrderedFixtureInterface
{
    private $order = 2;
    private $csvfile;

    public function getOrder()
    {
        return $this->order;
    }

    public function load(ObjectManager $em)
    {
        //$this->fieldlist = 'id,fundtype';
        //$this->manage($manager);
        $this->csvfile = 'fundtypes.csv';

        $rootdir = $this->getParameter('csv_loaddir');
        $filename = $rootdir . '/' . $this->csvfile;
        $records = $this->get('app.readcsv')->readcsv($filename);
        $fields = array(
            'fundtype' => true,
        );
        printf("fields: (%s)\n<br><br>", print_r($fields, true));

        foreach ($records as $recordkey => $record) {
            printf("recordkey: (%s)\n<br><br>", print_r($record, true));
            //$security = new Securities();
            $params=array(
                'fields' => $fields,
                'classname'  => 'FundTypes',
                'row' => $record,
            );
            $fundtype = $this->get('app.readcsv')->emdumprow($em, $params);
            //$bank->setFundbank($bank);
            $em->persist($bank);
        }
        $em->flush();
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
