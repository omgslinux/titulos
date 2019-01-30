<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundManagers;

/**
 * PDF controller.
 *
 * @Route("/PDF")
 */
class PDFController extends Controller
{
    /**
     * PDF index
     *
     * @Route("/", name="pdf_index",
     * methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fundmanagers = $em->getRepository('AppBundle:FundManagers')->findAll();

        return $this->render('pdf/index.html.twig', array(
            'fundmanagers' => $fundmanagers
        ));
    }

    /**
     * PDF funds
     *
     * @Route("/funds/{id}", name="pdf_funds",
     * methods={"GET", "POST"})
     */
    public function fundsAction(FundManagers $fundmanager)
    {
//        die('fundmanager: ' . $name);
//        $em = $this->getDoctrine()->getManager();
//        $fundmanagerId = $em->getRepository('AppBundle:FundManagers')
//            ->findOneByShortname($name->getShortname())
//        ;

//        $funds = $em->getRepository('AppBundle:Funds')->find($fundmanagerId);
//        $filepath = $this->get('app.filedownload');

        return $this->render('pdf/funds.html.twig', array(
            'fundmanager' => $fundmanager,
            'filepath' => $this->get('app.filedownload')
        ));
    }
}
