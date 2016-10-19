<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FundManagers;
use AppBundle\Form\FundManagersType;

/**
 * FundManagers controller.
 *
 * @Route("/manage/fundmanagers/")
 */
class FundManagersController extends Controller
{
    /**
     * Lists all FundManagers entities.
     *
     * @Route("/", name="manage_fundmanagers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fundmanagers = $em->getRepository('AppBundle:FundManagers')->findAll();

        return $this->render('fundmanagers/index.html.twig', array(
            'fundmanagers' => $fundmanagers,
        ));
    }

    /**
     * Creates a new FundManagers entity.
     *
     * @Route("/new", name="manage_fundmanagers_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fundmanager = new FundManagers();
        $form = $this->createForm('AppBundle\Form\FundManagersType', $fundmanager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundmanager);
            $em->flush();

            return $this->redirectToRoute('manage_fundmanagers_show', array('id' => $fundmanager->getId()));
        }

        return $this->render('fundmanagers/new.html.twig', array(
            'fundmanager' => $fundmanager,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FundManagers entity.
     *
     * @Route("/{id}", name="manage_fundmanagers_show")
     * @Method("GET")
     */
    public function showAction(FundManagers $fundmanager)
    {
        $deleteForm = $this->createDeleteForm($fundmanager);

        return $this->render('fundmanagers/show.html.twig', array(
            'fundmanager' => $fundmanager,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FundManagers entity.
     *
     * @Route("/{id}/edit", name="manage_fundamanagers_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FundManagers $fundmanager)
    {
        $deleteForm = $this->createDeleteForm($fundmanager);
        $editForm = $this->createForm('AppBundle\Form\FundManagersType', $fundmanager);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundmanager);
            $em->flush();

            return $this->redirectToRoute('manage_fundamanagers_edit', array('id' => $fundmanager->getId()));
        }

        return $this->render('fundmanagers/edit.html.twig', array(
            'fundmanager' => $fundmanager,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundManagers entity.
     *
     * @Route("/{id}", name="manage_fundmanagers_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FundManagers $fundmanager)
    {
        $form = $this->createDeleteForm($fundmanager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fundmanager);
            $em->flush();
        }

        return $this->redirectToRoute('manage_fundmanagers_index');
    }

    /**
     * Creates a form to delete a FundManagers entity.
     *
     * @param FundManagers $fundmanager The FundManagers entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FundManagers $fundmanager)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_fundmanagers_delete', array('id' => $fundmanager->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
