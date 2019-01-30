<?php

namespace AppBundle\Controller\admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\LawType;
use AppBundle\Entity\FundLinkTypes;
use AppBundle\Form\FundLinkTypesType;

/**
 * LawsType controller.
 *
 * @Route("/admin/lawtypes")
 */
class LawTypeController extends Controller
{
    /**
     * Lists all FundLinkTypes entities.
     *
     * @Route("/", name="admin_lawtypes_index",
     * methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $lawtypes = $em->getRepository('AppBundle:LawType')->findAll();

        return $this->render('admin/lawtype/index.html.twig', array(
            'lawtypes' => $lawtypes,
        ));
    }

    /**
     * Creates a new FundLinkTypes entity.
     *
     * @Route("/new", name="admin_lawtypes_new",
     * methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lawtype = new LawType();
        $form = $this->createForm('AppBundle\Form\LawTypeType', $lawtype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lawtype);
            $em->flush();

            return $this->redirectToRoute('admin_lawtypes_index');
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Crear tipo de ley ',
            'backlink' => $this->generateUrl('admin_lawtypes_index'),
            'backmessage' => 'Volver al listado de tipos de índice',
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FundLinkTypes entity.
     *
     * @Route("/{id}", name="admin_lawtypes_show",
     * methods={"GET"})
     */
    public function showAction(LawType $lawtype)
    {
        $deleteForm = $this->createDeleteForm($lawtype);

        return $this->render('admin/lawtype/show.html.twig', array(
            'lawtypes' => $lawtypes,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FundLinkTypes entity.
     *
     * @Route("/{id}/edit", name="admin_lawtypes_edit",
     * methods={"GET", "POST"})
     */
    public function editAction(Request $request, LawType $lawtype)
    {
        $deleteForm = $this->createDeleteForm($lawtype);
        $editForm = $this->createForm('AppBundle\Form\LawTypeType', $lawtype);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lawtype);
            $em->flush();

            return $this->redirectToRoute('admin_lawtypes_show', array('id' => $lawtype->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Editando tipo de ley ',
            'backlink' => $this->generateUrl('admin_lawtypes_index'),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundLinkTypes entity.
     *
     * @Route("/{id}", name="admin_lawtypes_delete",
     * methods={"DELETE"})
     */
    public function deleteAction(Request $request, LawType $lawtype)
    {
        $form = $this->createDeleteForm($lawtype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lawtype);
            $em->flush();
        }

        return $this->redirectToRoute('admin_lawtypes_index');
    }

    /**
     * Creates a form to delete a FundLinkTypes entity.
     *
     * @param FundLinkTypes $fltype The FundLinkTypes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(LawType $lawtype)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_lawtypes_delete', array('id' => $lawtype->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
