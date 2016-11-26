<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/funds/{id}", name="search_funds")
     * @Method({"GET"})
     */
    public function showAction(Request $request, Funds $fund)
    {

        return $this->render('search/funds/show.html.twig', array(
            'fund' => $fund,
        ));
    }
}
