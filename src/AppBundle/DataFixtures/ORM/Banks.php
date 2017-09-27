<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

class BanksLoader extends ContainerAwareLoader implements OrderedFixtureInterface
{
    private $order=10;
    private $csvfile="banks.csv";

    public function getOrder()
    {
        return $this->order;
    }

    public function load(ObjectManager $manager)
    {
//        $this->manage($fieldlist, $table);
//        $this->dump2bd($manager);

//        $this->fieldlist=$fieldlist;
//        $this->table = $table;
//        if (is_null($csvfile)) {
//            $csvfile = "$table";
//        }
//        $this->csvfile = "${csvfile}.csv";


        $rootdir = $this->getParameter('csv_loaddir');
        $filename = $rootdir . '/' . $this->csvfile;
        $records = $this->get('app.readcsv')->readcsv($filename);
        $fields = array(
            'shortname' => true,
            'longname' => true,
            'acronym' => true,
            'city' => array(
                'type' => array(
                    'entity' => true,
                    'classname' => 'Cities',
                    'property' => 'city',
                    'mappedBy' => 'city'
                )
            ),
            'city_id' => array(
                'type' => array(
                    'entity' => true,
                    'classname' => 'Cities',
                    'property' => 'city',
                    'mappedBy' => 'id'
                )
            ),
            'address' => true
        );
        printf("fields: (%s)\n<br><br>", print_r($fields, true));

        $em = $this->getDoctrine()->getManager();
        foreach ($records as $recordkey => $record) {
            printf("recordkey: (%s)\n<br><br>", print_r($record, true));
            //$security = new Securities();
            $params=array(
                'fields' => $fields,
                'classname'  => 'Banks',
                'row' => $record,
            );
            $bank = $this->get('app.readcsv')->emdumprow($em, $params);
            //$bank->setFundbank($bank);
            $em->persist($bank);
        }
        $em->flush();
    }
}
