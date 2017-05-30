<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\InterestRates;

class MortgageRefunds extends ContainerAwareLoader
{

    private $rates=array();
    private $refunds=array();
    private $container;
    private $payments=array();
    private $formdata=array();
    private $remainings=array();
    private $datepattern='Y/m/d'; // Pattern for internal array format

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getRatebase($payment,$ratedif)
    {
        if ($payment>0) {
            $mdate=new \DateTime($this->formdata['mortgagedate']->format($this->datepattern));
            $i=$payment-1;
            $mdate->add(new \DateInterval('P' . $i . 'M'));
            $ratedate=new \DateTime($mdate->format('Y/m/') . '01');
            //dump($ratedate);
            //dump($payment);
            //dump($ratedif);
            if (!empty($this->rates[$ratedate->format($this->datepattern)])) {
              $startdate=$this->rates[$ratedate->format($this->datepattern)];
              if ($payment<=$this->formdata['months']) {
                  $ratebase = $ratedif = $this->formdata['interest'];
              } else {
                  if (($payment - $this->formdata['months']) % $this->formdata['revisions'] == 1) {
                      if ($this->formdata['reference'] >0) {
                          $ratedate->modify('-' . $this->formdata['reference'] . 'months');
                      }
                      if (!empty($this->rates[$ratedate->format($this->datepattern)])) {
                          $ratebase = $this->getInterestRate($ratedate->format($this->datepattern));
                          $ratedif= $ratebase + $this->formdata['differential'];
                      } else {
                          $ratedif=false;
                      }
                  }
              }
            }
      } else {
            $ratedif=0;
      }
        return $ratedif;
    }

    public function getCuota($amount,$interest,$payments)
    {
        $cuota=$amount/((1-(1+($interest/1200))**-($payments+1))/($interest/1200));
        //dump("amount=$amount, interest=$interest, payments=$payments, cuota=$cuota");
        return $cuota;
    }

    public function getRateData(float $ratedif, $payment)
    {
        $cuota = $this->getCuota($this->remaining['nofloor'],$ratedif,$this->formdata['payments']-$payment);
        $interesam = $ratedif * $this->remaining['nofloor'] / 1200;
        $capitalam = $cuota - $interesam;
        $this->remaining['nofloor'] -= $capitalam;
        $interes1 = $ratedif;
        if ($ratedif!==$this->formdata['interest'] && $ratedif < $this->formdata['floor']) {
            $interes1 = $this->formdata['floor'];
        }
        $cuota1 = $this->getCuota($this->remaining['floor'],$interes1,$this->formdata['payments']-$payment);
        $interesam1 = $interes1 * $this->remaining['floor'] / 1200;
        $capitalam1 = $cuota1 - $interesam1;
        $this->remaining['floor'] -= $capitalam1;
        $difference = ($capitalam1 - $capitalam) + ($interesam1 - $interesam);
        return array(
            'cuota' => $cuota,
            'interesam' => $interesam,
            'capitalam' => $capitalam,
            'remaining' => $this->remaining['nofloor'],
            'interes1' => $interes1,
            'cuota1' => $cuota1,
            'interesam1' => $interesam1,
            'capitalam1' => $capitalam1,
            'remaining1' => $this->remaining['floor'],
            'difference' => $difference,
        );
    }

    public function setData($data)
    {
        $this->formdata=$data;
        $mortgagedate=new \DateTime($data['mortgagedate']->format('Y/m/d'));
        $this->remaining['nofloor']=$this->remaining['floor']=$data['amount'];
        $diferenciatotal=0;
        $em=$this->container->get('doctrine')->getManager();
        $interestrates = $em->getRepository('AppBundle:InterestRates')->findAll();

        // Dump into array for faster access
        $legal=0;
        foreach ($interestrates as $rate) {
            $ratedate=$rate->getInterestDate()->format($this->datepattern);
            if ($mortgagedate->format('Y/m') <= $rate->getInterestDate()->format('Y/m')) {
                $this->rates[$ratedate]=array(
                  'euribor' => $rate->getEuribor(),
                  'irph'    => $rate->getIRPH(),
                );
            }
            if (count($this->refunds)) {
                if ($legal != $rate->getLegalInterest()) {
                    $legal=$rate->getLegalInterest();
                    $this->refunds[$ratedate]=array('legalinterest' => $legal);
                    //'legalinterest' => $rate->getLegalInterest(),
                }
            } else {
                $legal=$rate->getLegalInterest();
                $this->refunds[$ratedate]=array('legalinterest' => $legal);
            }
        }
        krsort($this->refunds);
        //dump($this->refunds);
    }

    private function getInterestRate($date)
    {
        if ($this->formdata['interesttype']===0) {
            return $this->rates[$date]['euribor'];
        } else {
            return $this->rates[$date]['irph'];
        }
    }

    public function getRefund($startdate, $enddate, $interesam1, $interesam)
    {
        $totalrefund=$paymentrefund=0;
        if ($interesam1>$interesam) {
            $difference=$interesam1-$interesam;
            //dump("startdate: ". $startdate->format('Y/m/d') .", enddate: " .$enddate->format('Y/m/d') .", difference: $difference");
            foreach ($this->refunds as $xdate => $rate) {
                $date=new \DateTime($xdate);
                if ($startdate->format('Ymd')<$enddate->format('Ymd')) {
                    $legalinterest=$rate['legalinterest'];
                    if ($this->formdata['refundtype']===1) {
                        $legalinterest=$rate['legalinterest'] + 2;
                    }
                    $dailyinterest=$legalinterest/36500;
                    if ($startdate->format('Y/m/d')<$xdate) {
                        $days=round(($enddate->format('U') - $date->format('U'))/(3600*24));
                    } else {
                        $days=round(($enddate->format('U') - $startdate->format('U'))/(3600*24));
                    }
                    $paymentrefund=$difference * $days * $dailyinterest;
                    $totalrefund += $paymentrefund;
                    /*
                    dump("xdate: ".$xdate. ", enddate: ". $enddate->format('Ymd') . ", legalinterest: ". $legalinterest.
                      ", date (L): " . $date->format('L'). ", days: $days, dailyinterest: $dailyinterest, ".
                      "paymentrefund: $paymentrefund , totalrefund: ". $totalrefund);
                      */
                    $enddate=$date;
                }
            }
        }

        return $totalrefund;

    }
}
