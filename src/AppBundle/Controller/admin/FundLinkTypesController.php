<?php

namespace AppBundle\Controller\admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\FundLinkTypes;
use AppBundle\Form\FundLinkTypesType;

/**
 * FundLinkTypes controller.
 *
 * @Route("/admin/linktypes")
 */
class FundLinkTypesController extends Controller
{
    /**
     * Lists all FundLinkTypes entities.
     *
     * @Route("/", name="admin_linktypes_index",
     * methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fltype = $em->getRepository('AppBundle:FundLinkTypes')->findAll();

        return $this->render('admin/linktypes/index.html.twig', array(
            'fltype' => $fltype,
        ));
    }

    /**
     * Creates a new FundLinkTypes entity.
     *
     * @Route("/new", name="admin_linktypes_new",
     * methods={"GET", "POST"})
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

            return $this->redirectToRoute('admin_linktypes_index');
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Crear tipo de enlace ',
            'backlink' => $this->generateUrl('admin_linktypes_index'),
            'backmessage' => 'Volver al listado de tipos de enlace',
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FundLinkTypes entity.
     *
     * @Route("/{id}", name="admin_linktypes_show",
     * methods={"GET"})
     */
    public function showAction(FundLinkTypes $fltype)
    {
        $deleteForm = $this->createDeleteForm($fltype);

        return $this->render('admin/linktypes/show.html.twig', array(
            'fltype' => $fltype,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FundLinkTypes entity.
     *
     * @Route("/{id}/edit", name="admin_linktypes_edit",
     * methods={"GET", "POST"})
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

            return $this->redirectToRoute('admin_linktypes_show', array('id' => $fltype->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Editando tipo de enlace ',
            'backlink' => $this->generateUrl('admin_linktypes_index'),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundLinkTypes entity.
     *
     * @Route("/{id}", name="admin_linktypes_delete",
     * methods={"DELETE"})
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

        return $this->redirectToRoute('admin_linktypes_index');
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
            ->setAction($this->generateUrl('admin_linktypes_delete', array('id' => $fltype->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
