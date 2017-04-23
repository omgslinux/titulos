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
        //$mdate=$this->formdata['mortgagedate']->add(new \DateInterval('P' . $payment . 'M'));
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
              //$comment="Interes fijo";
              //$ratedate = new \DateTime('01/' . $mdate->format('m/Y'));
          } else {
              if (($payment - $this->formdata['months']) % $this->formdata['revisions'] == 1) {
                  //$ratedate = new \DateTime($mdate->format('Y/m/'). '01');
                  if ($this->formdata['reference'] >0) {
                      $ratedate->modify('-' . $this->formdata['reference'] . 'months');
                  }
                  //$euribordate='01/' . $mortgagedate->format('m/Y');
                  if (!empty($this->rates[$ratedate->format($this->datepattern)])) {
                      $ratebase = $this->getInterestRate($ratedate->format($this->datepattern));
                      $ratedif= $ratebase + $this->formdata['differential'];
                  } else {
                      $ratedif=false;
                  }
              }
              //$comment="Euribor $ratebase ($ratedif)";
          }
      }
      return $ratedif;
    }

    public function getCuota($amount,$interest,$payments)
    {
        return $amount/((1-(1+($interest/1200))**-$payments)/($interest/1200));
    }

    public function getRateData(float $ratedif)
    {
                $cuota = $this->getCuota($this->formdata['amount'],$ratedif,$this->formdata['payments']);
                $interesam = $ratedif * $this->remaining['nofloor'] / 1200;
                $capitalam = $cuota - $interesam;
                $this->remaining['nofloor'] -= $capitalam;
                $interes1 = $ratedif;
                if ($ratedif!==$this->formdata['interest'] && $ratedif < $this->formdata['floor']) {
                    $interes1 = $this->formdata['floor'];
                }
                $cuota1 = $this->getCuota($this->formdata['amount'],$interes1,$this->formdata['payments']);
                $interesam1 = $interes1 * $this->remaining['floor'] / 1200;
                $capitalam1 = $cuota1 - $interesam1;
                $this->remaining['floor'] -= $capitalam1;
                $difference = ($capitalam1 - $capitalam) + ($interesam1 - $interesam);
                //$mdate=$this->formdata['mortgagedate']->add(new \DateInterval('P' . $payment . 'M'));
                return array(
                    //'ratedate' => $mdate,
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
/*        foreach ($interestrates as $key => $value) {
            if ($mortgagedate->format('Y/m') <= $value['interestdate']) {
                $this->rates[${value['interestdate']}]=array(
                  'euribor' => $value['euribor'],
                  'irph'    => $value['irph'],
                  'legalinterest' => $value['legalinterest']
                );
            }
        }*/
        foreach ($interestrates as $rate) {
            if ($mortgagedate->format('Y/m') <= $rate->getInterestDate()->format('Y/m')) {
                $this->rates[$rate->getInterestDate()->format($this->datepattern)]=array(
                  'euribor' => $rate->getEuribor(),
                  'irph'    => $rate->getIRPH(),
                  'legalinterest' => $rate->getLegalInterest(),
                );
            }
        }
        //dump($this->rates);
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
            //dump($startdate, $enddate, $difference);
            foreach ($this->rates as $xdate => $rate) {
                $date=new \DateTime($xdate);
                if ($startdate->format('Ym') <= $date->format('Ym') && $enddate >= $date) {
                    $legalinterest=$rate['legalinterest'];
                    if ($this->formdata['refundtype']===1) {
                        $legalinterest=$rate['legalinterest'] + 2;
                    }
                    $days=$date->format('t') - round(($startdate->format('U')-$date->format('U'))/(3600*24));
                    $paymentrefund=$difference * $days * (($legalinterest/1200) / ($date->format('L')+365));
                    $totalrefund += $paymentrefund;
                    //dump("xdate: ".$xdate, "startdate: ". $startdate->format('Ym'));
                    //dump("legalinterest: ". $legalinterest);
                    //dump("date (L): " . $date->format('L'), "days: " . $days, $paymentrefund, $totalrefund);
                }
            }
        }

        return $totalrefund;

    }

}
