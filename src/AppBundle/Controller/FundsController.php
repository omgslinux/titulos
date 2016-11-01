<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundLinks;
use AppBundle\Entity\FundLaws;
use AppBundle\Entity\FundBanks;
use AppBundle\Entity\MortgageFunds;
use AppBundle\Form\FundsType;
use AppBundle\Util\Slugger;
// use AppBundle\Util\FileDownload;

/**
 * Funds controller.
 *
 * @Route("/manage/funds")
 */
class FundsController extends Controller
{
    /**
     * Lists all Funds entities.
     *
     * @Route("/", name="manage_funds_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $funds = $em->getRepository('AppBundle:Funds')->findAll();

        return $this->render('funds/index.html.twig', array(
            'funds' => $funds,
        ));
    }

    /**
     * Creates a new Funds entity.
     *
     * @Route("/new", name="manage_funds_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fund = new Funds();
        $form = $this->createForm('AppBundle\Form\FundsType', $fund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fund);
            $em->flush();

            return $this->redirectToRoute('manage_funds_index');
        }

        return $this->render('funds/edit.html.twig', array(
            'fund' => $fund,
            'h1' => 'Crear fondo ',
            'backlink' => $this->generateUrl('manage_funds_index'),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Funds entity.
     *
     * @Route("/{id}", name="manage_funds_show")
     * @Method("GET")
     */
    public function showAction(Funds $fund)
    {

        $em = $this->getDoctrine()->getManager();

        $mfund = $em->getRepository('AppBundle:MortgageFunds')->find($fund);

        $fundlinks = $em->getRepository('AppBundle:FundLinks')->findBy(array('fund' => $fund->getId()));
        $fundbanks = $em->getRepository('AppBundle:FundBanks')->findBy(array('fund' => $fund->getId()));
        $fundlaws = $em->getRepository('AppBundle:FundLaws')->findBy(array('fund' => $fund->getId()));

        $deleteForm = $this->createDeleteForm($fund);
        $downloadForm = $this->createDownloadForm($fund);

        $filepath = $this->get('app.filedownload');
        $filepath->setUrl($fund->getCNMVPDFLink());


        return $this->render('funds/show.html.twig', array(
            'fund' => $fund,
            'mfund' => $mfund,
            'fundlinks' => $fundlinks,
            'fundbanks' => $fundbanks,
            'fundlaws' => $fundlaws,
            'filepath' => $filepath,
            'delete_form' => $deleteForm->createView(),
            'download_form' => $downloadForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Funds entity.
     *
     * @Route("/{id}/edit", name="manage_funds_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Funds $fund)
    {
        $deleteForm = $this->createDeleteForm($fund);
        $editForm = $this->createForm('AppBundle\Form\FundsType', $fund);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fund);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fund->getId()));
        }

        return $this->render('funds/edit.html.twig', array(
            'fund' => $fund,
            'h1' => 'Editar fondo',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al fondo',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Funds entity.
     *
     * @Route("/{id}", name="manage_funds_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Funds $fund)
    {
        $form = $this->createDeleteForm($fund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fund);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_index');
    }

    /**
     * Creates a form to delete a Funds entity.
     *
     * @param Funds $fund The Funds entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Funds $fund)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_funds_delete', array('id' => $fund->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Displays a form to download a file.
     *
     * @Route("/{id}/download", name="manage_funds_download")
     * @Method({"GET", "POST"})
     */
    public function downloadAction(Request $request, Funds $fund)
    {
        $downloadForm = $this->createDownloadForm($fund);
        $downloadForm->handleRequest($request);

        if ($downloadForm->isSubmitted() && $downloadForm->isValid()) {
            // 1 is internal hardcoded for "CNMV registration doc"
            $filepath = $this->get('app.filedownload');
            $filepath->setUrl($fund->getCNMVPDFLink());
            if (!$filepath->isDocdownloaded($fund->getFulldocpath())) {
                $filepath->getFile();
            }

            return $this->redirectToRoute('manage_funds_show', array('id' => $fund->getId()));
        }

    }

    /**
     * Creates a form to download a file from CNMV entity.
     *
     * @param Funds $fund The Funds entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDownloadForm(Funds $fund)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_funds_download', array('id' => $fund->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }




    /**
     * Creates a new MortgageFunds entity.
     *
     * @Route("/{id}/extra/new", name="manage_funds_extra_new")
     * @Method({"GET", "POST"})
     */
    public function extranewAction(Request $request, Funds $fund)
    {
        $mfund = new MortgageFunds($fund);
        $form = $this->createForm('AppBundle\Form\MortgageFundsType', $mfund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mfund);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $mfund->getId()));
        }

        return $this->render('funds/edit.html.twig', array(
            'fund' => $fund,
            'h1' => 'Añadir datos adicionales para el fondo ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));

    }


    /**
     * Creates a new FundBanks entity.
     *
     * @Route("/{id}/banks/new", name="manage_funds_banks_new")
     * @Method({"GET", "POST"})
     */
    public function banksnewAction(Request $request,Funds $fund)
    {
        //$em = $this->getDoctrine()->getManager();
        //$fundbanks = $em->getRepository('AppBundle:FundBanks')->find($fund);
        $fundbanks = new FundBanks($fund);
        $form = $this->createForm('AppBundle\Form\FundBanksType', $fundbanks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundbanks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundbanks->getFundid()));
        }

        return $this->render('funds/edit.html.twig', array(
            'fund' => $fund,
            'h1' => 'Crear entidad cedente para el fondo ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));

    }

    /**
     * Creates a new FundLaws entity.
     *
     * @Route("/{id}/laws/new", name="manage_funds_laws_new")
     * @Method({"GET", "POST"})
     */
    public function lawsnewAction(Request $request,Funds $fund)
    {
        //$fundlinks = $em->getRepository('AppBundle:FundLinks')->find($fund);
        $fundlaws = new FundLaws($fund);
        $form = $this->createForm('AppBundle\Form\FundLawsType', $fundlaws);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundlaws);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundlaws->getFund()->getId()));
        }

        return $this->render('funds/edit.html.twig', array(
            'fund' => $fund,
            'h1' => 'Crear enlace a ley ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));

    }


    /**
     * Creates a new FundLinks entity.
     *
     * @Route("/{id}/links/new", name="manage_funds_links_new")
     * @Method({"GET", "POST"})
     */
    public function linksnewAction(Request $request,Funds $fund)
    {
        //$fundlinks = $em->getRepository('AppBundle:FundLinks')->find($fund);
        $fundlinks = new FundLinks($fund);
        $form = $this->createForm('AppBundle\Form\FundLinksType', $fundlinks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundlinks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundlinks->getFundid()));
        }

        return $this->render('funds/edit.html.twig', array(
            'fund' => $fund,
            'h1' => 'Crear enlace ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));

    }




}
