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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('interesttype', ChoiceType::class, array(
                'choices'  => array(
                    'Euribor' => 0,
                    'IRPH' => 1,
                  ))
              )
            ->add('refundtype', ChoiceType::class, array(
                'choices'  => array(
                    'Legal' => 0,
                    'judicial' => 1,
                  ))
              )
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
        $payment=1;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            //dump($data);
            $mortgage=$this->get('app.mortgagerefunds');
            $mortgage->setData($data);
            $mortgagedate=new \DateTime($data['mortgagedate']->format('Y/m/d'));
            $remaining=$remaining1=$data['amount'];
            $diferenciatotal=0;
            $enddate=new \DateTime($mortgagedate->format('Y/m/d'));
            $enddate->add(new \DateInterval('P'.$data['payments'].'M'));
            $now=new \DateTime();
            if ($now < $enddate) {
                $enddate=$now;
            }
            //dump($enddate);
            //dump($mortgagedate);
            $ratedif=0;
            for ($payment=1;$mortgagedate<=$enddate; $payment++) {
                $interes1=$ratedif=$mortgage->getRatebase($payment,$ratedif);
                if ($ratedif!==$data['interest']) {
                    if ($data['interesttype']===0) {
                        $comment="Euribor";
                    } else {
                        $comment="IRPH";
                    }
                    $ratebase=$ratedif - $data['differential'];
                    $comment.=" $ratebase ($ratedif)";
                    if ($ratedif < $data['floor']) {
                        $interes1 = $data['floor'];
                    }
                } else {
                    $ratebase=$ratedif;
                    $comment="Interes fijo";
                }
                //dump($ratedif);
                //if ($ratedif!==false) {
                  $ratedata=$mortgage->getRateData($ratedif);
                  //dump($ratedata);

                  $refund=$mortgage->getRefund($mortgagedate,$enddate,$ratedata['interesam1'], $ratedata['interesam']);
                  $diferenciatotal = $diferenciatotal + $ratedata['difference'];
                  $paytemp=array(
                      'payment' => $payment,
                      'mortgagedate' => $mortgagedate->format('d/m/Y'),
                      'ratebase' => $ratebase,
                      'ratedif' => $ratedif,
                      'total' => $diferenciatotal,
                      'refund' => $refund,
                      'comment' => $comment,
                  );
                  $payments[$payment]=$paytemp + $ratedata;
                  //dump($payments[$payment]);
                  $mortgagedate = $mortgagedate->add(new \DateInterval('P1M'));
                //}
            }
        }

        //dump($payments);

        return $this->render('search/floor.html.twig', array(
            'title' => 'Cálculo de las claúsulas suelo',
            'payments' => $payments,
            'payment0' => $payment,
            'form' => $form->createView(),
            'data' => $data,
        ));
    }
}
