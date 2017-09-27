<?php
namespace AppBundle\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class FundsCommand extends ContainerAwareCommand
{
    private $order = 100;
    private $csvfile;
    private $container;

    public function getOrder()
    {
        return $this->order;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        //$ciudad = $io->ask('¿Para qué ciudad quieres generar los emails?', 'sevilla');
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
        $em = $this->getContainer()->get('doctrine')->getManager();
        //$em = $this->getDoctrine()->getManager();
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
