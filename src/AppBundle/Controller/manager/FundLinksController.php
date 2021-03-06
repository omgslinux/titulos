<?php

namespace AppBundle\Controller\manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundLinks;
use AppBundle\Form\FundLinksType;

/**
 * FundLinks controller.
 *
 * @Route("/manage/funds")
 */
class FundLinksController extends Controller
{

    /**
     * Creates a form to edit a FundLinks entity.
     *
     * @Route("/links/{id}/edit", name="manage_funds_links_edit",
     * methods={"GET", "POST"})
     */
    public function editAction(Request $request, FundLinks $fundlinks)
    {
        $deleteForm = $this->createDeleteForm($fundlinks);
        $editForm = $this->createForm('AppBundle\Form\FundLinksType', $fundlinks);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundlinks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundlinks->getFund()->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'fundlink' => $fundlinks,
            'action' => 'Editar enlace ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fundlinks->getFundid())),
            'backmessage' => 'Volver al fondo ' . $fundlinks->getFundname(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Finds and displays a FundLinks entity.
     *
     * @Route("/links/{id}", name="manage_funds_links_show",
     * methods={"GET"})
     */
    public function showAction(FundLinks $fundlinks)
    {
        $filepath = $this->get('app.filedownload');
        $filepath->setUrl($fundlinks->getUrl());
        $downloadForm = $this->createDownloadForm($fundlinks);

        return $this->render('manage/funds/links.html.twig', array(
            'fundlink' => $fundlinks,
            'filepath' => $filepath,
            'action' => 'Enlaces en el fondo ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fundlinks->getFundid())),
            'backmessage' => 'Volver al fondo ' . $fundlinks->getFundname(),
            'download_form' => $downloadForm->createView()
        ));
    }

    /**
     * Deletes a FundLinks entity.
     *
     * @Route("/links/{id}", name="manage_funds_links_delete",
     * methods={"DELETE"})
     */
    public function deleteAction(Request $request, FundLinks $fundlinks)
    {
        $form = $this->createDeleteForm($fundlinks);
        $form->handleRequest($request);
        $id=$fundlinks->getFund()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fundlinks);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_show', array('id' => $id));
    }

    /**
     * Creates a form to delete a FundLinks entity.
     *
     * @param FundLinks $fundlinks The FundLinks entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FundLinks $fundlinks)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_funds_links_delete', array('id' => $fundlinks->getId())))
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
    private function createDownloadForm(FundLinks $fundlink)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_funds_download', array(
                'id' => $fundlink->getFund()->getId(),
                'linktype' => $fundlink->getLinktype()->getId()
                )))
            ->setMethod('POST')
            ->getForm()
        ;
    }


    /**
     * Displays a form to download a file.
     *
     * @Route("/links/{id}/download", name="manage_funds_links_download",
     * methods={"GET", "POST"})
     */
    public function downloadAction(Request $request, FundLinks $fundlink)
    {
        $downloadForm = $this->createDownloadForm($fundlink);
        $downloadForm->handleRequest($request);

        if ($downloadForm->isSubmitted() && $downloadForm->isValid()) {
            // 1 is internal hardcoded for "CNMV registration doc"
            $filepath = $this->get('app.filedownload');
            $filepath->setUrl($fundlink->getUrl());
            if (!$filepath->isDocdownloaded($fundlink->getFulldocpath())) {
                $filepath->getFile();
            }

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundlink->getFund()->getId()));
        }
    }

    /**
     * Creates a new FundLinks entity.
     *
     * @Route("/{id}/links/new", name="manage_funds_links_new",
     * methods={"GET", "POST"})
     */
    public function newAction(Request $request, Funds $fund)
    {
        $fundlinks = new FundLinks();
        $fund->addLink($fundlinks);
        $form = $this->createForm('AppBundle\Form\FundLinksType', $fundlinks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundlinks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundlinks->getFundid()));
        }

        return $this->render('default/edit.html.twig', array(
            'fund' => $fund,
            'action' => 'Crear enlace ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al fondo ' . $fund->getFundname(),
            'create_form' => $form->createView(),
        ));
    }
}
