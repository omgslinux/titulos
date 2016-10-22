<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FundLinkTypes;
use AppBundle\Form\FundLinkTypesType;

/**
 * FundLinkTypes controller.
 *
 * @Route("/manage/linktypes/")
 */
class FundLinkTypesController extends Controller
{
    /**
     * Lists all FundLinkTypes entities.
     *
     * @Route("/", name="manage_linktypes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fltype = $em->getRepository('AppBundle:FundLinkTypes')->findAll();

        return $this->render('linktypes/index.html.twig', array(
            'fltype' => $fltype,
        ));
    }

    /**
     * Creates a new FundLinkTypes entity.
     *
     * @Route("/new", name="manage_linktypes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $fltype = new FundLinkTypes();
        $form = $this->createForm('AppBundle\Form\FundLinkTypesType', $fltype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fltype);
            $em->flush();

            return $this->redirectToRoute('manage_linktypes_index');
        }

        return $this->render('linktypes/edit.html.twig', array(
            'fltype' => $fltype,
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FundLinkTypes entity.
     *
     * @Route("/{id}", name="manage_linktypes_show")
     * @Method("GET")
     */
    public function showAction(FundLinkTypes $fltype)
    {
        $deleteForm = $this->createDeleteForm($fltype);

        return $this->render('linktypes/show.html.twig', array(
            'fltype' => $fltype,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FundLinkTypes entity.
     *
     * @Route("/{id}/edit", name="manage_linktypes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FundLinkTypes $fltype)
    {
        $deleteForm = $this->createDeleteForm($fltype);
        $editForm = $this->createForm('AppBundle\Form\FundLinkTypesType', $fltype);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fltype);
            $em->flush();

            return $this->redirectToRoute('manage_linktypes_show', array('id' => $fltype->getId()));
        }

        return $this->render('linktypes/edit.html.twig', array(
            'fltype' => $fltype,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundLinkTypes entity.
     *
     * @Route("/{id}", name="manage_linktypes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FundLinkTypes $fltype)
    {
        $form = $this->createDeleteForm($fltype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fltype);
            $em->flush();
        }

        return $this->redirectToRoute('manage_linktypes_index');
    }

    /**
     * Creates a form to delete a FundLinkTypes entity.
     *
     * @param FundLinkTypes $fltype The FundLinkTypes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FundLinkTypes $fltype)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_linktypes_delete', array('id' => $fltype->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
