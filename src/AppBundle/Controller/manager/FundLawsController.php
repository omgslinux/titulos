<?php

namespace AppBundle\Controller\manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundLaws;

/**
 * FundLinks controller.
 *
 * @Route("/manage/funds")
 */
class FundLawsController extends Controller
{

    /**
     * Creates a form to edit a FundLaws entity.
     *
     * @Route("/laws/{id}/edit", name="manage_funds_laws_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FundLaws $fundlaw)
    {
        $deleteForm = $this->createDeleteForm($fundlaw);
        $editForm = $this->createForm('AppBundle\Form\FundLawsType', $fundlaw);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundlaw);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundlaw->getFund()->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'fund' => $fundlaw->getFund(),
            'action' => 'Editar enlace a ley para el fondo',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fundlaw->getFund()->getId())),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a new FundLaws entity.
     *
     * @Route("/{id}/laws/new", name="manage_funds_laws_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Funds $fund)
    {
        //$fundlinks = $em->getRepository('AppBundle:FundLinks')->find($fund);
        $fundlaw = new FundLaws();
        $fundlaw->setFund($fund);
        $form = $this->createForm('AppBundle\Form\FundLawsType', $fundlaw);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundlaw);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundlaw->getFund()->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'fund' => $fund,
            'action' => 'Crear enlace a ley ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fund->getId())),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FundLaws entity.
     *
     * @Route("/laws/{id}", name="manage_funds_laws_show")
     * @Method("GET")
     */
    public function showAction(FundLaws $fundlaw)
    {

        return $this->render('manage/funds/laws.html.twig', array(
            'fundlaw' => $fundlaw,
            'action' => 'Ley en el fondo ',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fundlaw->getFund()->getId())),
            'backmessage' => 'Volver al fondo'
        ));
    }

    /**
     * Deletes a FundLaws entity.
     *
     * @Route("/laws/{id}", name="manage_funds_laws_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FundLaws $fundlaw)
    {
        $form = $this->createDeleteForm($fundlaw);
        $form->handleRequest($request);
        $id = $fundlaw->getFund()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fundlaw);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_show', array('id' => $id));
    }

    /**
     * Creates a form to delete a FundLaws entity.
     *
     * @param FundLaws $fundlaws The FundLaws entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FundLaws $fundlaw)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_funds_laws_delete', array('id' => $fundlaw->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
