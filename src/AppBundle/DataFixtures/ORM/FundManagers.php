<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\FundManagers;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FundManagersLoader implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $order = 20;
    private $container;
    private $csvfile = 'fundmanagers.csv';

    public function getOrder()
    {
        return $this->order;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function load(ObjectManager $em)
    {
        $rootdir = $this->container->getParameter('csv_loaddir');
        $filename = $rootdir . '/' . $this->csvfile;
        $records = $this->container->get('app.readcsv')->readcsv($filename);
        $fields = array(
            'shortname' => true,
            'longname' => true,
            'nif' => true,
            'description' => true,
            'capitalsocial' => true,
            'regdate' => array(
                'type' => array(
                    'date' => true,
                    'format' => 'Y-m-d'
                )
            ),
            'address' => true
        );
        printf("fields: (%s)\n<br><br>", print_r($fields, true));

        foreach ($records as $recordkey => $record) {
            printf("recordkey: (%s)\n<br><br>", print_r($record, true));
            //$security = new Securities();
            $params=array(
                'fields' => $fields,
                'classname'  => 'FundManagers',
                'row' => $record,
            );
            $fundmanager = $this->get('app.readcsv')->emdumprow($em, $params);
            //$bank->setFundbank($bank);
            $em->persist($fundmanager);
        }
        $em->flush();
    }
}
