<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Cities;
use AppBundle\Entity\Provinces;
use AppBundle\Repository\ProvincesRepository;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

class CitiesLoader extends ContainerAwareLoader implements OrderedFixtureInterface
{
    private $order = 3;
    private $csvfile = 'province_city.csv';

    public function getOrder()
    {
        return $this->order;
    }

    public function load(ObjectManager $manager)
    {
        //$this->fieldlist = 'province_id,city';

        $rootdir = $this->getParameter('csv_loaddir');
        $filename = $rootdir . '/' . $this->csvfile;
        $records = $this->get('app.readcsv')->readcsv($filename);
        $fields = array(
            'shortname' => true,
            'longname' => true,
            'acronym' => true,
            'province' => array(
                'type' => array(
                    'entity' => true,
                    'classname' => 'Provinces',
                    'property' => 'city',
                    'mappedBy' => 'province'
                )
            ),
            'province_id' => array(
                'type' => array(
                    'entity' => true,
                    'classname' => 'Provinces',
                    'property' => 'province',
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
                'classname'  => 'Cities',
                'row' => $record,
            );
            $bank = $this->get('app.readcsv')->emdumprow($em, $params);
            //$bank->setFundbank($bank);
            $em->persist($bank);
        }
        $em->flush();
    }
}
