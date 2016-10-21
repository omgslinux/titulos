<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundLinks;
use AppBundle\Form\FundLinksType;

/**
 * FundLinks controller.
 *
 * @Route("/manage/funds/links")
 */
class FundLinksController extends Controller
{

    /**
     * Creates a form to edit a FundLinks entity.
     *
     * @Route("/{id}/edit", name="manage_funds_links_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,FundLinks $fundlinks)
    {
        $deleteForm = $this->createDeleteForm($fundlinks);
        $editForm = $this->createForm('AppBundle\Form\FundLinksType', $fundlinks);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundlinks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundlinks->getId()));
        }

        return $this->render('funds/links.html.twig', array(
            'fundlinks' => $fundlinks,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundLinks entity.
     *
     * @Route("/{id}", name="manage_funds_links_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FundLinks $fundbanks)
    {
        $form = $this->createDeleteForm($fundlinks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fundlinks);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_show', array('id' => $fundlinks->getId()));
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
}
