<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CNMVLinks
{
    private $URLBASE='http://www.cnmv.es/Portal/Consultas/Folletos/';
    private $NIF='V85166619';
    private $html;

    public function __construct($NIFS = false)
    {
        if ($NIFS===false) {
            $this->downloadAll($this->NIF);
        } else {
            if (is_array($NIFS)) {
                foreach ($NIFS as $NIF) {
                    $this->downloadAll($NIF);
                }
            } else {
                $this->downloadAll($NIFS);
            }
        }
    }

    public function downloadAll($NIF)
    {
        print "Descargando NIF $NIF\n";
        $this->NIF=$NIF;
        $this->getConstPDF();
        $this->getBrochurePDF();
    }

    public function geturl($URLPARAMS)
    {
        $url="";
        $params=explode('&', $URLPARAMS);
        foreach ($params as $param) {
            $key = strstr($param, '=', true);
            $value = substr(strstr($param, '='), 1);
            if ($url) {
                $url.= '\&';
            }
            $url.="$key=" . rawurlencode($value);
        }
        return $url;
    }

    public function getURLContents($URL)
    {
        $file=$this->NIF."html";
        system("curl -v -k --url $URL -o $file");
        $this->html=file_get_contents($file);
        unlink($file);
        return;
    }

    public function getPDFURL($htmltext)
    {
        $href=explode('=', substr($htmltext, stripos($htmltext, 'href', 1)));
        print_r($href);
        $url2=substr($href[2], 0, stripos($href[2], '"'));
        return $this->URLBASE . substr($href[1], 1) . '=' . rawurlencode($url2);
    }

    public function getPDF($URL, $pdf)
    {
        system("curl -v -l --url $URL -o $pdf");
    }

    /*
    include 'src/AppBundle/Util/FileDownload.php';
    $f=new AppBundle\Util\FileDownload();
    $f->setRootdir('./app');
    $f->setUrl($URL);
    //$f->setUrl('https://titulizaciones.tomalaplaza.net/pdf/SANTANDER_DE_TITULIZACION/EMPRESAS_BANESTO_2__FONDO_DE_TITULIZACION_DE_ACTIVOS.pdf');
    $f->getFile('xxx.pdf');
    */


    public function getConstPDF()
    {
        // Escritura de constitución del fondo
        $URLPARAMS='id=0&nif=' . $this->NIF;
        $URL=$this->URLBASE . 'AnotacionesCuenta.aspx?'. $this->geturl($URLPARAMS);
        $this->getURLContents($URL);
        $htmlconst=system("echo '$this->html'|grep 'verDoc.axd'|grep 'document'");
        $pdfurl=$this->getPDFURL($htmlconst);
        print "Escritura: ($pdfurl)\n";
        $this->getPDF($pdfurl, $this->NIF."-const.pdf");
    }

    public function getBrochurePDF()
    {
        // http://www.cnmv.es/Portal/Consultas/Folletos/FolletosEmisionOPV.aspx?nif=$NIF
        // Folleto de emisión del fondo
        $URLPARAMS='nif=' .$this->NIF;
        //$URL = $this->URLBASE . 'FolletosEmisionOPV.aspx?'. $this->geturl($URLPARAMS);
        $this->getURLContents($this->URLBASE . 'FolletosEmisionOPV.aspx?'. $this->geturl($URLPARAMS));
        //$htmlconst=system("echo '$this->html'|grep 'verDoc.axd'");
        $pdfurl=$this->getPDFURL(system("echo '$this->html'|grep 'verDoc.axd'"));
        print "Folleto: ($pdfurl)\n";
        $this->getPDF($pdfurl, $this->NIF."-broch.pdf");
    }
}
