<?php

namespace AppBundle\Controller\admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundLinks;

/**
 * Funds controller.
 *
 * @Route("/admin/funds")
 */
class FundsController extends Controller
{
    /**
     * Lists all Funds entities.
     *
     * @Route("/", name="admin_funds_index",
     * methods={"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $funds = $em->getRepository('AppBundle:Funds')->findAll();

        $filepath = $this->get('app.filedownload');

        return $this->render('admin/funds.html.twig', array(
            'funds' => $funds,
            'filepath' => $filepath,
        ));
    }


    /**
     * Displays a form to download a file.
     *
     * @Route("/{id}/{linktype}/download", name="admin_funds_download",
     * methods={"GET", "POST"})
     */
    public function downloadAction(Request $request, Funds $fund, $linktype)
    {
        $downloadForm = $this->createDownloadForm($fund, $linktype);
        $downloadForm->handleRequest($request);


        if ($linktype<3) {
            $cnmv = $this->get('app.cnmvlinks');
            $cnmv->setNIF($fund->getNif());
            $cnmv->setPath($fund->getFulldocpath($linktype));
            $cnmv->getFileByLinktype($linktype);
        } else {
            $em = $this->getDoctrine()->getManager();
            $fundlink = $em->getRepository('AppBundle:FundLinks')->findOneBy(array(
                'linktype' => $linktype,
                'fund' => $fund
            ));
            $filepath = $this->get('app.filedownload');
            $filepath->setUrl($fundlink->getUrl());
            if (!$filepath->isDocdownloaded($fundlink->getFulldocpath($linktype))) {
                $filepath->getFile();
            }
            //dump($fund, $fundlink);
        }
            //die("fund: $fund, id: " . $fund->getId() . ", linktype: $linktype");
        return $this->redirectToRoute('admin_funds_index');
    }

    /**
     * Creates a form to download a file from CNMV entity.
     *
     * @param Funds $fund The Funds entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDownloadForm(Funds $fund, $linktype)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_funds_download', array(
                'id' => $fund->getId(),
                'linktype' => $linktype,
                )))
            ->setMethod('POST')
            ->getForm()
        ;
    }

    /**
     * Displays a form to download a file.
     *
     * @Route("/downloadall", name="admin_funds_downloadall",
     * methods={"GET", "POST"})
     */
    public function downloadAllAction(Request $request)
    {
        $downloadAllForm = $this->createDownloadAllForm();
        $downloadAllForm->handleRequest($request);

        if ($downloadAllForm->isSubmitted() && $downloadAllForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $funds = $em->getRepository('AppBundle:Funds')->findAll();
            $cnmv = $this->get('app.cnmvlinks');
            $linktypes=array(1,2);
            foreach ($funds as $fund) {
                $cnmv->setNIF($fund->getNif());
                foreach ($linktypes as $linktype) {
                    //$cnmv->setFilepath($fund->getFulldocpath($linktype));
                    if (!$cnmv->isDocdownloaded($fund->getFulldocpath($linktype))) {
                        $cnmv->getFileByLinktype($linktype);
                    }
                }
            }
        }
        return $this->redirectToRoute('admin_funds_index');
    }

    /**
     * Creates a form to download a file from CNMV entity.
     *
     * @param Funds $fund The Funds entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDownloadAllForm()
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_funds_downloadall'))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
