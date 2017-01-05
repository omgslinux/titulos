<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use AppBundle\Entity\Laws;
use AppBundle\Entity\Funds;

/**
 * Search controller.
 *
 * @Route("/search")
 */
class SearchController extends Controller
{

    /**
     * Search funds by selecting a FundBank entity
     *
     * @Route("/fundsbybank", name="search_funds_bybank")
     * @Method({"GET", "POST"})
     */
    public function fundsByBankAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb
            ->select('DISTINCT IDENTITY(f.bank) AS id')
            ->addSelect('b.shortname')
            ->from('AppBundle:FundBanks', 'f')
            ->join('AppBundle:Banks', 'b', 'WITH', 'f.bank=b.id')
            ->addOrderBy('b.shortname', 'ASC')
        ;

        $query = $qb->getQuery();
        $fundbanks = $query->getResult();
        $selectedBankId = null;
        $funds = null;

        if ($request->isMethod(Request::METHOD_POST)) {
            $selectedBankId = $request->request->get('banks', null);
            $qbFunds = $em->createQueryBuilder();
            $qbFunds
                ->select('DISTINCT IDENTITY(b.fund) AS id')
                ->from('AppBundle:FundBanks', 'b')
                ->join('AppBundle:MortgageFunds', 'm', 'WITH', 'b.fund=m.fund')
                ->where('b.bank = :selected')
                ->setParameter('selected', $selectedBankId)
                ->OrderBy('b.fund')
            ;
            $queryFunds = $qbFunds->getQuery();
            $fundarray = $queryFunds->getResult();
            $fundids = [];
            foreach ($fundarray as $key => $value) {
                $fundids[]=$value['id'];
            }
            $funds = $em->getRepository('AppBundle:Funds')->findby(array('id'=>$fundids));
        }

        return $this->render('search/funds/bybank.html.twig', array(
            'action' => 'Búsqueda de fondos por entidad cedente',
            'fundbanks' => $fundbanks,
            'funds' => $funds,
            'selectedBankId' => $selectedBankId,
            'backlink' => $this->generateUrl('profile_tasks_index'),
            'backmessage' => 'Volver al listado de tareas',
        ));
    }

    /**
     * Search all funds in a FundManagers entity
     *
     * @Route("/fundsbymanager", name="search_funds_bymanager")
     * @Method({"GET", "POST"})
     */
    public function fundsByManagerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fundmanagers = $em->getRepository('AppBundle:FundManagers')->findAll();
        $selectedId = null;
        $funds = null;

        if ($request->isMethod(Request::METHOD_POST)) {
            $selectedId = $request->request->get('fundamanagers', null);
            $funds = $em
                ->getRepository('AppBundle:Funds')
                ->findby(array('fundmanager'=>$selectedId), array('fundname' => 'ASC'));
        }

        return $this->render('search/funds/bymanager.html.twig', array(
            'action' => 'Búsqueda de fondos por entidad gestora',
            'fundmanagers' => $fundmanagers,
            'funds' => $funds,
            'selectedId' => $selectedId,
            'backlink' => $this->generateUrl('profile_tasks_index'),
            'backmessage' => 'Volver al listado de tareas',
        ));
    }



    /**
     * Search loans by selecting a FundBank entity
     *
     * @Route("/fundsbyloan", name="search_funds_byloan")
     * @Method({"GET", "POST"})
     */
    public function fundsByLoanAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb
            ->select('DISTINCT IDENTITY(s.fundbank) AS id')
            ->addSelect('b.shortname')
            ->from('AppBundle:Securities', 's')
            ->join('AppBundle:FundBanks', 'f', 'WITH', 's.fundbank=f.id')
            ->join('AppBundle:Banks', 'b', 'WITH', 'f.bank=b.id')
            ->addOrderBy('b.shortname', 'ASC')
        ;

        $query = $qb->getQuery();
        $fundbanks = $query->getResult();
        $selectedBankId = null;
        $securities = null;
        $amount = null;
        $startdate = null;

        if ($request->isMethod(Request::METHOD_POST)) {
            $selectedBankId = $request->request->get('banks', null);
            $amount = $request->request->get('amount', null);
            $startdate = $request->request->get('startdate', null);
            $qbFunds = $em->createQueryBuilder();
            $qbFunds
                ->select('s')
                ->from('AppBundle:Securities', 's')
                ->join('AppBundle:FundBanks', 'b', 'WITH', 's.fundbank=b.id')
                ->join('AppBundle:MortgageFunds', 'm', 'WITH', 'b.fund=m.fund')
                ->where('s.fundbank = :selected')
                ->andWhere('s.amount = :amount')
                ->setParameter('selected', $selectedBankId)
                ->setParameter('amount', $amount)
                ->OrderBy('b.fund')
            ;
            $queryFunds = $qbFunds->getQuery();
            $securities = $queryFunds->getResult();
            /*
            $fundids = [];
            foreach ($fundarray as $key => $value) {
                $fundids[]=$value['id'];
            }
            $funds = $em->getRepository('AppBundle:Funds')->findby(array('id'=>$fundids));
            */
        }

        return $this->render('search/funds/byloan.html.twig', array(
            'action' => 'Búsqueda de fondos por préstamo hipotecario',
            'fundbanks' => $fundbanks,
            'securities' => $securities,
            'amount' => $amount,
            'startdate' => $startdate,
            'selectedBankId' => $selectedBankId,
            'backlink' => $this->generateUrl('profile_tasks_index'),
            'backmessage' => 'Volver al listado de tareas',
        ));
    }

    /**
     * Creates a form to show a Funds entity.
     *
     * @Route("/funds/{id}", name="search_funds")
     * @Method({"GET"})
     */
    public function searchFundAction(Request $request, Funds $fund)
    {

        return $this->render('search/funds/show.html.twig', array(
            'fund' => $fund,
        ));
    }

    /**
     * Creates a form to show Laws entities.
     *
     * @Route("/laws/", name="search_laws_index")
     * @Method({"GET"})
     */
    public function searchLawsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $laws = $em->getRepository('AppBundle:Laws')->findBy(array(), array('lawdate' => 'ASC'));

        return $this->render('search/laws/index.html.twig', array(
            'laws' => $laws,
        ));
    }

    /**
     * Creates a form to show Laws entities.
     *
     * @Route("/laws/{id}", name="search_laws_show")
     * @Method({"GET"})
     */
    public function showLawsAction(Request $request, Laws $law)
    {

        return $this->render('search/laws/show.html.twig', array(
            'law' => $law,
        ));
    }

    /**
     * Search a mortgage
     *
     * @Route("/floor", name="search_floor")
     * @Method({"GET", "POST"})
     */
    public function floorAction(Request $request)
    {
        $defaultData = array('message' => 'Introduce los datos del préstamo:');
        $form = $this->createFormBuilder($defaultData)
            ->add('mortgagedate', DateType::class, array(
                'attr' => array(
                    'width' => 10,
                ),
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ))
            ->add('amount', MoneyType::class)
            ->add('payments', IntegerType::class)
            ->add('interest', NumberType::class)
            ->add('months', IntegerType::class)
            ->add('differential', NumberType::class)
            ->add('reference', NumberType::class)
            ->add('revisions', IntegerType::class)
            ->add('floor', NumberType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $payments=array();
        $data=false;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            //dump($data);
            $eurdata = array(
                '01/01/1999'  =>  '3,069',
                '01/02/1999'  =>  '3,030',
                '01/03/1999'  =>  '3,046',
                '01/04/1999'  =>  '2,756',
                '01/05/1999'  =>  '2,683',
                '01/06/1999'  =>  '2,836',
                '01/07/1999'  =>  '3,030',
                '01/08/1999'  =>  '3,237',
                '01/09/1999'  =>  '3,301',
                '01/10/1999'  =>  '3,684',
                '01/11/1999'  =>  '3,689',
                '01/12/1999'  =>  '3,828',
                '01/01/2000'  =>  '3,949',
                '01/02/2000'  =>  '4,111',
                '01/03/2000'  =>  '4,267',
                '01/04/2000'  =>  '4,365',
                '01/05/2000'  =>  '4,849',
                '01/06/2000'  =>  '4,968',
                '01/07/2000'  =>  '5,105',
                '01/08/2000'  =>  '5,248',
                '01/09/2000'  =>  '5,219',
                '01/10/2000'  =>  '5,218',
                '01/11/2000'  =>  '5,193',
                '01/12/2000'  =>  '4,881',
                '01/01/2001'  =>  '4,574',
                '01/02/2001'  =>  '4,591',
                '01/03/2001'  =>  '4,471',
                '01/04/2001'  =>  '4,481',
                '01/05/2001'  =>  '4,461',
                '01/06/2001'  =>  '4,312',
                '01/07/2001'  =>  '4,311',
                '01/08/2001'  =>  '4,108',
                '01/09/2001'  =>  '3,770',
                '01/10/2001'  =>  '3,369',
                '01/11/2001'  =>  '3,198',
                '01/12/2001'  =>  '3,298',
                '01/01/2002'  =>  '3,483',
                '01/02/2002'  =>  '3,594',
                '01/03/2002'  =>  '3,816',
                '01/04/2002'  =>  '3,860',
                '01/05/2002'  =>  '3,963',
                '01/06/2002'  =>  '3,869',
                '01/07/2002'  =>  '3,645',
                '01/08/2002'  =>  '3,440',
                '01/09/2002'  =>  '3,236',
                '01/10/2002'  =>  '3,126',
                '01/11/2002'  =>  '3,017',
                '01/12/2002'  =>  '2,872',
                '01/01/2003'  =>  '2,705',
                '01/02/2003'  =>  '2,504',
                '01/03/2003'  =>  '2,411',
                '01/04/2003'  =>  '2,447',
                '01/05/2003'  =>  '2,252',
                '01/06/2003'  =>  '2,014',
                '01/07/2003'  =>  '2,076',
                '01/08/2003'  =>  '2,279',
                '01/09/2003'  =>  '2,258',
                '01/10/2003'  =>  '2,303',
                '01/11/2003'  =>  '2,410',
                '01/12/2003'  =>  '2,388',
                '01/01/2004'  =>  '2,216',
                '01/02/2004'  =>  '2,163',
                '01/03/2004'  =>  '2,055',
                '01/04/2004'  =>  '2,163',
                '01/05/2004'  =>  '2,297',
                '01/06/2004'  =>  '2,404',
                '01/07/2004'  =>  '2,361',
                '01/08/2004'  =>  '2,302',
                '01/09/2004'  =>  '2,377',
                '01/10/2004'  =>  '2,316',
                '01/11/2004'  =>  '2,328',
                '01/12/2004'  =>  '2,301',
                '01/01/2005'  =>  '2,312',
                '01/02/2005'  =>  '2,310',
                '01/03/2005'  =>  '2,335',
                '01/04/2005'  =>  '2,265',
                '01/05/2005'  =>  '2,193',
                '01/06/2005'  =>  '2,103',
                '01/07/2005'  =>  '2,168',
                '01/08/2005'  =>  '2,223',
                '01/09/2005'  =>  '2,220',
                '01/10/2005'  =>  '2,414',
                '01/11/2005'  =>  '2,684',
                '01/12/2005'  =>  '2,783',
                '01/01/2006'  =>  '2,833',
                '01/02/2006'  =>  '2,914',
                '01/03/2006'  =>  '3,105',
                '01/04/2006'  =>  '3,221',
                '01/05/2006'  =>  '3,308',
                '01/06/2006'  =>  '3,401',
                '01/07/2006'  =>  '3,539',
                '01/08/2006'  =>  '3,615',
                '01/09/2006'  =>  '3,715',
                '01/10/2006'  =>  '3,799',
                '01/11/2006'  =>  '3,862',
                '01/12/2006'  =>  '3,921',
                '01/01/2007'  =>  '4,064',
                '01/02/2007'  =>  '4,094',
                '01/03/2007'  =>  '4,106',
                '01/04/2007'  =>  '4,253',
                '01/05/2007'  =>  '4,373',
                '01/06/2007'  =>  '4,505',
                '01/07/2007'  =>  '4,564',
                '01/08/2007'  =>  '4,666',
                '01/09/2007'  =>  '4,725',
                '01/10/2007'  =>  '4,647',
                '01/11/2007'  =>  '4,607',
                '01/12/2007'  =>  '4,793',
                '01/01/2008'  =>  '4,498',
                '01/02/2008'  =>  '4,349',
                '01/03/2008'  =>  '4,590',
                '01/04/2008'  =>  '4,820',
                '01/05/2008'  =>  '4,994',
                '01/06/2008'  =>  '5,361',
                '01/07/2008'  =>  '5,393',
                '01/08/2008'  =>  '5,323',
                '01/09/2008'  =>  '5,384',
                '01/10/2008'  =>  '5,248',
                '01/11/2008'  =>  '4,350',
                '01/12/2008'  =>  '3,452',
                '01/01/2009'  =>  '2,622',
                '01/02/2009'  =>  '2,135',
                '01/03/2009'  =>  '1,909',
                '01/04/2009'  =>  '1,771',
                '01/05/2009'  =>  '1,644',
                '01/06/2009'  =>  '1,610',
                '01/07/2009'  =>  '1,412',
                '01/08/2009'  =>  '1,334',
                '01/09/2009'  =>  '1,261',
                '01/10/2009'  =>  '1,243',
                '01/11/2009'  =>  '1,231',
                '01/12/2009'  =>  '1,242',
                '01/01/2010'  =>  '1,232',
                '01/02/2010'  =>  '1,225',
                '01/03/2010'  =>  '1,215',
                '01/04/2010'  =>  '1,225',
                '01/05/2010'  =>  '1,249',
                '01/06/2010'  =>  '1,281',
                '01/07/2010'  =>  '1,373',
                '01/08/2010'  =>  '1,421',
                '01/09/2010'  =>  '1,420',
                '01/10/2010'  =>  '1,495',
                '01/11/2010'  =>  '1,541',
                '01/12/2010'  =>  '1,526',
                '01/01/2011'  =>  '1,550',
                '01/02/2011'  =>  '1,714',
                '01/03/2011'  =>  '1,924',
                '01/04/2011'  =>  '2,086',
                '01/05/2011'  =>  '2,147',
                '01/06/2011'  =>  '2,144',
                '01/07/2011'  =>  '2,183',
                '01/08/2011'  =>  '2,097',
                '01/09/2011'  =>  '2,067',
                '01/10/2011'  =>  '2,110',
                '01/11/2011'  =>  '2,044',
                '01/12/2011'  =>  '2,004',
                '01/01/2012'  =>  '1,837',
                '01/02/2012'  =>  '1,678',
                '01/03/2012'  =>  '1,499',
                '01/04/2012'  =>  '1,368',
                '01/05/2012'  =>  '1,266',
                '01/06/2012'  =>  '1,219',
                '01/07/2012'  =>  '1,061',
                '01/08/2012'  =>  '0,877',
                '01/09/2012'  =>  '0,740',
                '01/10/2012'  =>  '0,650',
                '01/11/2012'  =>  '0,588',
                '01/12/2012'  =>  '0,549',
                '01/01/2013'  =>  '0,575',
                '01/02/2013'  =>  '0,594',
                '01/03/2013'  =>  '0,545',
                '01/04/2013'  =>  '0,528',
                '01/05/2013'  =>  '0,484',
                '01/06/2013'  =>  '0,507',
                '01/07/2013'  =>  '0,525',
                '01/08/2013'  =>  '0,542',
                '01/09/2013'  =>  '0,543',
                '01/10/2013'  =>  '0,541',
                '01/11/2013'  =>  '0,506',
                '01/12/2013'  =>  '0,543',
                '01/01/2014'  =>  '0,562',
                '01/02/2014'  =>  '0,549',
                '01/03/2014'  =>  '0,577',
                '01/04/2014'  =>  '0,604',
                '01/05/2014'  =>  '0,592',
                '01/06/2014'  =>  '0,513',
                '01/07/2014'  =>  '0,488',
                '01/08/2014'  =>  '0,469',
                '01/09/2014'  =>  '0,362',
                '01/10/2014'  =>  '0,338',
                '01/11/2014'  =>  '0,335',
                '01/12/2014'  =>  '0,329',
                '01/01/2015'  =>  '0,298',
                '01/02/2015'  =>  '0,255',
                '01/03/2015'  =>  '0,212',
                '01/04/2015'  =>  '0,180',
                '01/05/2015'  =>  '0,165',
                '01/06/2015'  =>  '0,163',
                '01/07/2015'  =>  '0,167',
                '01/08/2015'  =>  '0,161',
                '01/09/2015'  =>  '0,154',
                '01/10/2015'  =>  '0,128',
                '01/11/2015'  =>  '0,079',
                '01/12/2015'  =>  '0,059',
                '01/01/2016'  =>  '0,042',
                '01/02/2016'  =>  '-0,008',
                '01/03/2016'  =>  '-0,012',
                '01/04/2016'  =>  '-0,010',
                '01/05/2016'  =>  '-0,013',
                '01/06/2016'  =>  '-0,028',
                '01/07/2016'  =>  '-0,056',
                '01/08/2016'  =>  '-0,048',
                '01/09/2016'  =>  '-0,057',
                '01/10/2016'  =>  '-0,069',
                '01/11/2016'  =>  '-0,074',
                '01/12/2016'  =>  '-0,080',
            );

            $mortgagedate=new \DateTime($data['mortgagedate']->format('d/m/Y'));
            $remaining=$remaining1=$data['amount'];
            $diferenciatotal=0;
            for ($payment=1; $payment<=$data['payments']; $payment++) {
                //$fechapago->modify('+1 month');
                $comment="";
                if ($payment<=$data['months']) {
                    $euribor = $eurdif = $data['interest'];
                    $comment="Interes fijo";
                    $euribordate = new \DateTime('01/' . $mortgagedate->format('m/Y'));
                } else {
                    if (($payment - $data['months']) % $data['revisions'] == 1) {
                        $euribordate = new \DateTime('01/' . $mortgagedate->format('m/Y'));
                        if ($data['reference'] >0){
                            $euribordate->modify('-' . $data['reference']. 'months');
                        }
                        //$euribordate='01/' . $mortgagedate->format('m/Y');
                        if (!empty($eurdata[$euribordate->format('d/m/Y')])) {
                            $euribor = str_replace(',', '.', $eurdata[$euribordate->format('d/m/Y')]);
                            $eurdif= $euribor + $data['differential'];
                        }
                    }
                    $comment="Euribor $euribor ($eurdif)";
                }
                $cuota = ($data['amount'])/((1-(1+($eurdif/1200))**-$data['payments'])/($eurdif/1200));
                $interesam = $eurdif * $remaining / 1200;
                $capitalam = $cuota - $interesam;
                $remaining = $remaining - $capitalam;
                if ($eurdif < $data['floor']) {
                    $interes1 = $data['floor'];
                } else {
                    $interes1 = $eurdif;
                }
                $cuota1 = ($data['amount'])/((1-(1+($interes1/1200))**-$data['payments'])/($interes1/1200));
                $interesam1 = $interes1 * $remaining1 / 1200;
                $capitalam1 = $cuota1 - $interesam1;
                $remaining1=$remaining1 - $capitalam1;
                $difference = $capitalam - $capitalam1;
                $diferenciatotal = $diferenciatotal + $difference;
                $payments[$payment]=array(
                    'payment' => $payment,
                    'mortgagedate' => $mortgagedate->format('d/m/Y'),
                    'euribordate' => $euribordate->format('d/m/Y'),
                    'euribor' => $euribor,
                    'eurdif' => $eurdif,
                    'cuota' => $cuota,
                    'interesam' => $interesam,
                    'capitalam' => $capitalam,
                    'remaining' => $remaining,
                    'interes1' => $interes1,
                    'cuota1' => $cuota1,
                    'interesam1' => $interesam1,
                    'capitalam1' => $capitalam1,
                    'remaining1' => $remaining1,
                    'difference' => $difference,
                    'total' => $diferenciatotal,
                    'comment' => $comment,
                );
                $mortgagedate = $mortgagedate->add(new \DateInterval('P1M'));
            }
        }

        return $this->render('search/floor.html.twig', array(
            'title' => 'Cálculo de las claúsulas suelo',
            'payments' => $payments,
            'form' => $form->createView(),
            'data' => $data,
        ));
    }
}
