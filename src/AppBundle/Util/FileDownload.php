<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FileDownload
{
    private $ch;
    private $rootdir;
    private $url=array();
    private $basedir='../web/';
    private $path;

    public function setRootdir($rootdir)
    {
        $this->rootdir = $rootdir;
    }

    public function setBasedir($basedir)
    {
        $this->basedir = $basedir;
    }

    public function setUrl($url)
    {
        if ($server=strstr($url, '?', true)) {
            $this->url['server']=$server;
            $param=substr(strstr($url, '?'), 1);
            $this->url['args'] = $param;
        } else {
            $this->url=array('server' => $url);
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getFullbase()
    {
        return $this->rootdir . '/' . $this->basedir;
    }

    public function getFulldir()
    {
        return $this->getFullbase() . dirname($this->path) . '/';
    }

    public function isDocdownloaded($path)
    {
        if (file_exists($this->getFullbase() . $path)) {
            return true;
        } else {
            $this->setPath($path);
            return false;
        }
    }

    public function getFile($path = false)
    {
        if ($path===false) {
            $path = $this->path;
        } else {
            $this->path = $path;
        }
        echo "basedir: " . $this->basedir . "<br>\n";
        echo "path: " . $path . "<br>\n";
        echo "rootdir: " . $this->rootdir . "<br>\n";
        echo "getFullbase: " . $this->getFullbase() . "<br>\n";
        echo "getFulldir: " . $this->getFulldir() . "<br>\n";
        // print getcwd();

        if (!is_dir($this->getFulldir())) {
            mkdir($this->getFulldir(), 0755, true);
        }

        if (!empty($this->url['args'])) {
            $url=$this->url['server'] . '?';
            $params=explode('&', $this->url['args']);
            foreach ($params as $param) {
                $key = strstr($param, '=', true);
                $value = substr(strstr($param, '='), 1);
                $url.="$key=" . rawurlencode($value);
            }
        } else {
            $url = $this->url['server'];
        }
        echo "curl -v -k --url $url -o ". $this->getFullbase() . '/' . $path . "<br>\n";
        system("curl -v -k --url $url -o ". $this->getFullbase() . '/' . $path);
    }

    public function getoldFile($path = false)
    {
        if ($path===false) {
            $path = $this->path;
        } else {
            $this->path = $path;
        }
        echo "basedir: " . $this->basedir . "\n";
        echo "path: " . $path . "\n";
        echo "rootdir: " . $this->rootdir . "\n";
        echo "getFullbase: " . $this->getFullbase() . "\n";
        echo "getFulldir: " . $this->getFulldir() . "\n";
        // $url  = 'http://www.example.com/a-large-file.zip';
        //$path = '/path/to/a-large-file.zip';
        // print getcwd();

        if (! is_dir($this->getFulldir())) {
            mkdir($this->getFulldir(), 0755, true);
        }

        $fp = fopen($this->getFullbase() . '/' . $path, 'w');
        $this->ch = curl_init();
        $this->setopt(CURLOPT_SSL_VERIFYPEER, false);
        $this->setopt(CURLOPT_FOLLOWLOCATION, true);
        $this->setopt(CURLOPT_MAXREDIRS, 4);
        $this->setopt(CURLOPT_RETURNTRANSFER, true);
        $this->setopt(CURLOPT_HTTPGET, true);
        $this->setopt(CURLOPT_HTTPHEADER, array('Content-Type: application/pdf'));
//            $this->setopt(CURLOPT_BINARYTRANSFER,TRUE);
//            $this->setopt(CURLOPT_FILETIME,TRUE);
//        $this->setopt(CURLOPT_VERBOSE,TRUE);
//        	$this->setopt(CURLOPT_POST, FALSE);
//            $this->setopt(CURLOPT_TIMEOUT, 100);
        if ($this->url['args']) {
            $url=$this->url['server'] . '?';
            $params=explode('&', $this->url['args']);
            foreach ($params as $param) {
                $key = strstr($param, '=', true);
                $value = substr(strstr($param, '='), 1);
                $url.="$key=" . rawurlencode($value);
            }
        } else {
            $url = $this->url['server'];
        }
        $this->setopt(CURLOPT_URL, $url);
            //$this->setopt(CURLOPT_POSTFIELDS,$this->url['args']);
        $this->setopt(CURLOPT_FILE, $fp);
    //        curl_exec($ch);
        if (! curl_exec($this->ch)) {
            $return_array['STATUS'] = curl_getinfo($this->ch);
            $return_array['ERROR']  = curl_error($this->ch);
            curl_close($this->ch);
            fclose($fp);
            print_r($return_array);
            print_r($this->url);
            echo $path;
            return $path;
        } else {
            echo "curl -v --url $url -o ". $this->getFullbase() . '/' . $path;
            return system("curl -v --url $url -o ". $this->getFullbase() . '/' . $path);
            //return "Error";
        }
     /* curl_setopt($ch, CURLOPT_URL, $target);
	curl_setopt($ch, CURLOPT_REFERER, $ref);
	curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt ($ch, CURLOPT_HTTPGET, TRUE);
	curl_setopt ($ch, CURLOPT_POST, FALSE);
	$return_array['FILE']   = curl_exec($ch);
	$return_array['STATUS'] = curl_getinfo($ch);
	$return_array['ERROR']  = curl_error($ch);
  	curl_close($ch);
  	return $return_array;
            return false;
            */
    }

    public function setopt($option, $value)
    {
        curl_setopt($this->ch, $option, $value);
    }
}
