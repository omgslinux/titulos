<?php

namespace AppBundle\Controller\manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\MortgageFunds;
use AppBundle\Form\MortgageFundsType;

/**
 * MortgageFunds controller.
 *
 * @Route("/manage/funds")
 */
class MortgageFundsController extends Controller
{

    /**
     * Creates a new MortgageFunds entity.
     *
     * @Route("/{id}/extra/new", name="manage_funds_extra_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Funds $fund)
    {
        $mfund = new MortgageFunds();
        $mfund->setFund($fund);
        $form = $this->createForm('AppBundle\Form\MortgageFundsType', $mfund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mfund);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $mfund->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Añadir datos adicionales para el fondo ' . $fund,
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al fondo',
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit a MortgageFunds entity.
     *
     * @Route("/extra/{id}/edit", name="manage_funds_extra_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MortgageFunds $mfund)
    {
        $deleteForm = $this->createDeleteForm($mfund);
        $editform = $this->createForm('AppBundle\Form\MortgageFundsType', $mfund);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mfund);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $mfund->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'mfund' => $mfund,
            'action' => 'Datos adicionales del fondo ' . $mfund->getFundname(),
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $mfund->getId())),
            'backmessage' => 'Volver al fondo',
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MortgageFunds entity.
     *
     * @Route("/extra/{id}/delete", name="manage_funds_extra_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, MortgageFunds $mfund)
    {
        $form = $this->createDeleteForm($mfund);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mfund);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_show', array('id' => $mfund->getId()));
    }

    /**
     * Creates a form to delete a MortgageFunds entity.
     *
     * @param MortgageFunds $mfund The MortgageFunds entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MortgageFunds  $mfund)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_funds_extra_delete', array('id' => $mfund->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
