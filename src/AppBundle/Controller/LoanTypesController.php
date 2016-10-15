<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\LoanTypes;
use AppBundle\Form\LoanTypesType;

/**
 * LoanTypes controller.
 *
 * @Route("/manage/loans/types/")
 */
class LoanTypesController extends Controller
{
    /**
     * Lists all LoanTypes entities.
     *
     * @Route("/", name="manage_loans_types_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $loanTypes = $em->getRepository('AppBundle:LoanTypes')->findAll();

        return $this->render('loantypes/index.html.twig', array(
            'loanTypes' => $loanTypes,
        ));
    }

    /**
     * Creates a new LoanTypes entity.
     *
     * @Route("/new", name="manage_loans_types_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $loanType = new LoanTypes();
        $form = $this->createForm('AppBundle\Form\LoanTypesType', $loanType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($loanType);
            $em->flush();

            return $this->redirectToRoute('manage_loans_types_show', array('id' => $loanType->getId()));
        }

        return $this->render('loantypes/new.html.twig', array(
            'loanType' => $loanType,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LoanTypes entity.
     *
     * @Route("/{id}", name="manage_loans_types_show")
     * @Method("GET")
     */
    public function showAction(LoanTypes $loanType)
    {
        $deleteForm = $this->createDeleteForm($loanType);

        return $this->render('loantypes/show.html.twig', array(
            'loanType' => $loanType,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LoanTypes entity.
     *
     * @Route("/{id}/edit", name="manage_loans_types_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, LoanTypes $loanType)
    {
        $deleteForm = $this->createDeleteForm($loanType);
        $editForm = $this->createForm('AppBundle\Form\LoanTypesType', $loanType);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($loanType);
            $em->flush();

            return $this->redirectToRoute('manage_loans_types_edit', array('id' => $loanType->getId()));
        }

        return $this->render('loantypes/edit.html.twig', array(
            'loanType' => $loanType,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a LoanTypes entity.
     *
     * @Route("/{id}", name="manage_loans_types_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, LoanTypes $loanType)
    {
        $form = $this->createDeleteForm($loanType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($loanType);
            $em->flush();
        }

        return $this->redirectToRoute('manage_loans_types_index');
    }

    /**
     * Creates a form to delete a LoanTypes entity.
     *
     * @param LoanTypes $loanType The LoanTypes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LoanTypes $loanType)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_loans_types_delete', array('id' => $loanType->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
