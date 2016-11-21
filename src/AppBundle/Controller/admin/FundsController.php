<?php

namespace AppBundle\Controller\admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Funds;

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
     * @Route("/", name="admin_funds_index")
     * @Method({"GET", "POST"})
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
     * @Route("/{id}/{linktype}/download", name="admin_funds_download")
     * @Method({"GET", "POST"})
     */
    public function downloadAction(Request $request, Funds $fund, $linktype)
    {
        $downloadForm = $this->createDownloadForm($fund, $linktype);
        $downloadForm->handleRequest($request);

//        die(print_r($request->request->get('form'), true));

//        if ($downloadForm->isSubmitted() && $downloadForm->isValid()) {
            $filepath = $this->get('app.filedownload');
            $cnmv = $this->get('app.cnmvlinks');
            $cnmv->setNIF($fund->getNif());
            $cnmv->setPath($fund->getFulldocpath($linktype));
            $cnmv->getFileByLinktype($linktype);
            //die("fund: $fund, id: " . $fund->getId() . ", linktype: $linktype");
//        }
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
     * @Route("/downloadall", name="admin_funds_downloadall")
     * @Method({"GET", "POST"})
     */
    public function downloadAllAction(Request $request)
    {
        $downloadAllForm = $this->createDownloadAllForm();
        $downloadAllForm->handleRequest($request);

//        if ($downloadAllForm->isSubmitted() && $downloadAllForm->isValid()) {
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
//        }
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
