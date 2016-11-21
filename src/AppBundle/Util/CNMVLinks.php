<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Util\FileDownload;

class CNMVLinks
{
    private $URLBASE='http://www.cnmv.es/Portal/Consultas/Folletos/';
    private $NIF='V85166619';
    private $html;
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function isDocdownloaded($path)
    {
        return $this->file->isDocdownloaded($path);
    }

    public function setPath($path)
    {
        $this->file->setPath($path);
    }

    public function getPath()
    {
        return $this->file->getPath();
    }

    public function setNIF($nif)
    {
        $this->NIF = $nif;
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
        $file=$this->NIF.".html";
        print "Descargando $URL en $file<br>\n";
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
//        $URL=$this->URLBASE . substr($href[1], 1) . '=' . rawurlencode($url2);
        $URL=$this->URLBASE . substr($href[1], 1) . '=' . $url2;
        $this->file->setUrl($URL);
        return $URL;
    }

    public function getPDF($URL, $pdf)
    {
        print "curl -v -l --url $URL -o $pdf<br>\n";
        system("curl -v -l --url $URL -o $pdf");
    }

    public function getFileByLinktype($linktype)
    {
        switch ($linktype) {
            case '1':
                $this->getConstPDF();
                break;
            case '2':
                $this->getBrochurePDF();
                break;
            default:
                # code...
                break;
        }
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
        $this->file->getFile();
        //$this->getPDF($pdfurl, ($this->filepath?$this->filepath:$this->NIF."-const.pdf"));
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
        $this->file->getFile();
        //$this->getPDF($pdfurl, ($this->getPath()?$this->getPath():$this->NIF."-broch.pdf"));
    }
}
