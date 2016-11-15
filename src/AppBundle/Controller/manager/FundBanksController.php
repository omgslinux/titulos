<?php

namespace AppBundle\Controller\manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundBanks;
use AppBundle\Entity\FundLinks;
use AppBundle\Entity\Securities;
use AppBundle\Entity\FundBankTasks;
use AppBundle\Form\FundBanksType;

/**
 * Funds controller.
 *
 * @Route("/manage/funds")
 */
class FundBanksController extends Controller
{

    /**
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/banks/{id}", name="manage_funds_banks_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, FundBanks $fundbank)
    {
        $filename = false;
        $form = false;
        $securitiescount=false;
        foreach ($fundbank->getFund()->getLinks() as $fundlink) {
            if ($fundlink->getLinktypeid() == 7) {
                $filepath = $this->get('app.filedownload');
                // $filename = $fundlink->getFulldocpath(7,$fundbank->getLoadFilename());
                $filename = $fundlink->getFullcleancsvpath($fundbank->getLoadFilename());
                if (!$filepath->isDocdownloaded($filename)) {
                    $filename = false;
                }
                $loadSecurityForm = $this->createLoadSecurityForm($fundbank);
                $form = $loadSecurityForm->createView();

                $securitiescount = count($fundbank->getSecurities());
            }
        }

        return $this->render('funds/banks.html.twig', array(
            'fundbank' => $fundbank,
            'filename' => $filename,
            'securitiescount' => $securitiescount,
            'download_form' => $form
        ));
    }

    /**
     * Creates a new FundBanks entity.
     *
     * @Route("/{id}/banks/new", name="manage_funds_banks_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Funds $fund)
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

        return $this->render('default/edit.html.twig', array(
            'fund' => $fund,
            'action' => 'Crear entidad cedente para el fondo ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/banks/{id}/edit", name="manage_funds_banks_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FundBanks $fundbank)
    {
//        $fund = $em->getRepository('AppBundle:Funds')->findOneBy(array('id' => $fundbanks->getFund()));
        $deleteForm = $this->createDeleteForm($fundbank);
        $editform = $this->createForm('AppBundle\Form\FundBanksType', $fundbank);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundbank);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundbank->getFundid()));
        }

        return $this->render('default/edit.html.twig', array(
            'fundbank' => $fundbank,
            'action' => 'Editar entidad cedente para el fondo ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fundbank->getFundid())),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundBanks entity.
     *
     * @Route("/banks/{id}/delete", name="manage_funds_banks_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, FundBanks $fundbank)
    {
        $form = $this->createDeleteForm($fundbank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fundbank);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_show', array('id' => $fundbank->getFundid()));
    }

    /**
     * Creates a form to delete a FundBanks entity.
     *
     * @param FundBanks $fundbanks The FundBanks entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FundBanks $fundbank)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_funds_banks_delete', array('id' => $fundbank->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to download a file from CNMV entity.
     *
     * @param FundLinks $fundlink The FundLinks entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDownloadForm(\AppBundle\Entity\FundLinks $fundlink)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_funds_links_download', array('id' => $fundlink->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }


    /**
     * Creates a form to load a file into Securities entity
     *
     * @param FundBanks $fundbank The FundBanks entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createLoadSecurityForm(FundBanks $fundbank)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_securities_load', array('id' => $fundbank->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
}
