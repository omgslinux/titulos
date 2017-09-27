<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\FundManagers;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FundsLoader extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    private $order = 100;
    private $csvfile;
    private $container;

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
        //$fieldlist = 'fundmanager_id,fundtype_id,fundname,nif,constdate';

        $this->csvfile = "fundamangers_funds.csv";
        //$container = $em->getParameter

        $rootdir = $this->container->getParameter('csv_loaddir');
        $filename = $rootdir . '/' . $this->csvfile;
        $records = $this->container->get('app.readcsv')->readcsv($filename);
        $fields = array(
            'shortname' => true,
            'longname' => true,
            'acronym' => true,
            'fundmanager_shortname' => array(
                'type' => array(
                    'entity' => true,
                    'classname' => 'FundManagers',
                    'property' => 'shortname',
                    'mappedBy' => 'fundmanager'
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
                'classname'  => 'Funds',
                'row' => $record,
            );
            $fund = $this->get('app.readcsv')->emdumprow($em, $params);
            //$bank->setFundbank($bank);
            $em->persist($fund);
        }
        $em->flush();
    }
}
