<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Banks;

/**
 * Banks controller.
 *
 * @Route("/manage/banks")
 */
class BanksController extends Controller
{
    /**
     * Lists all Banks entities.
     *
     * @Route("/", name="manage_banks_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $banks = $em->getRepository('AppBundle:Banks')->findAll();

        return $this->render('banks/index.html.twig', array(
            'banks' => $banks,
        ));
    }

    /**
     * Creates a new Banks entity.
     *
     * @Route("/new", name="manage_banks_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $bank = new Banks();
        $form = $this->createForm('AppBundle\Form\BanksType', $bank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bank);
            $em->flush();

            return $this->redirectToRoute('manage_banks_show', array('id' => $bank->getId()));
        }

        return $this->render('banks/new.html.twig', array(
            'bank' => $bank,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Banks entity.
     *
     * @Route("/{id}", name="manage_banks_show")
     * @Method("GET")
     */
    public function showAction(Banks $bank)
    {

        $em = $this->getDoctrine()->getManager();

        $city = $em->getRepository('AppBundle:Cities')->find($bank);

        $deleteForm = $this->createDeleteForm($bank);


        return $this->render('banks/show.html.twig', array(
            'bank' => $bank,
            'city' => $city,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Banks entity.
     *
     * @Route("/{id}/edit", name="manage_banks_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Banks $bank)
    {
        $deleteForm = $this->createDeleteForm($bank);
        $editForm = $this->createForm('AppBundle\Form\BanksType', $bank);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bank);
            $em->flush();

            return $this->redirectToRoute('manage_banks_show', array('id' => $bank->getId()));
        }

        return $this->render('banks/edit.html.twig', array(
            'bank' => $bank,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Banks entity.
     *
     * @Route("/{id}", name="manage_banks_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Banks $bank)
    {
        $form = $this->createDeleteForm($bank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bank);
            $em->flush();
        }

        return $this->redirectToRoute('manage_banks_index');
    }

    /**
     * Creates a form to delete a Banks entity.
     *
     * @param Banks $bank The Banks entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Banks $bank)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_banks_delete', array('id' => $bank->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
