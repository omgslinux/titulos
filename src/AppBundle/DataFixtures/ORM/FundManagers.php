<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\FundManagers;

class FundManagersLoader extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 20;
    }

    public function load(ObjectManager $manager)
    {
        $fundmanagers = array(
            array(
                'id' => 1,
                'shortname' => 'EUROPEA DE TITULIZACION',
                'longname' => 'EUROPEA DE TITULIZACION, S.A., S.G.F.T.',
                'nif' => 'A-80514466',
                'description' => ''
            ),
            array(
                'id' => 2,
                'shortname' => 'GESTICAIXA',
                'longname' => 'GESTICAIXA, S.G.F.T., S.A.',
                'nif' => 'A-58481227',
                'description' => ''
            ),
            array(
                'id' => 3,
                'shortname' => 'GESTION DE ACTIVOS TITULIZADOS',
                'longname' => 'GESTION DE ACTIVOS TITULIZADOS, SGFT, S.A.',
                'nif' => 'A-61604955',
                'description' => ''
            ),
            array(
                'id' => 4,
                'shortname' => 'HAYA TITULIZACION',
                'longname' => 'HAYA TITULIZACION, SGFT, S.A.',
                'nif' => 'A80732142',
                'description' => ''
            ),
            array(
                'id' => 5,
                'shortname' => 'INTERMONEY TITULIZACION',
                'longname' => 'INTERMONEY TITULIZACION, S.G.F.T., S.A.',
                'nif' => 'A-83774885',
                'description' => ''
            ),
            array(
                'id' => 6,
                'shortname' => 'SANTANDER DE TITULIZACION',
                'longname' => 'SANTANDER DE TITULIZACION, SGFT, S.A.',
                'nif' => 'A-80481419',
                'description' => ''
            ),
            array(
                'id' => 7,
                'shortname' => 'TITULIZACION DE ACTIVOS',
                'longname' => 'TITULIZACION DE ACTIVOS, S.A., S.G.F.T.',
                'nif' => 'A-80352750',
                'description' => ''
            )
        );
        foreach ($fundmanagers as $fundmanager) {
            $entidad = new FundManagers();
            $entidad->setShortName($fundmanager['shortname']);
            $entidad->setLongName($fundmanager['longname']);
            $entidad->setNif($fundmanager['nif']);
            $entidad->setDescription($fundmanager['description']);

            $manager->persist($entidad);
        }
        $manager->flush();
    }

    public function readcsv($file)
    {
        if (($handle = fopen("$file", "r")) !== false) {
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
                        $data[$row][${headers[$column]}] = $value;
                    }
                }
            }
        }
        return $data;
    }
}
