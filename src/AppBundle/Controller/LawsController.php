<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Laws;
use AppBundle\Entity\FundManagers;
use AppBundle\Form\FundManagersType;

/**
 * Laws controller.
 *
 * @Route("/manage/laws/")
 */
class LawsController extends Controller
{
    /**
     * Lists all Laws entities.
     *
     * @Route("/", name="manage_laws_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $law = $em->getRepository('AppBundle:Laws')->findAll();

        return $this->render('laws/index.html.twig', array(
            'laws' => $law,
        ));
    }

    /**
     * Creates a new Laws entity.
     *
     * @Route("/new", name="manage_laws_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $law = new Laws();
        $form = $this->createForm('AppBundle\Form\LawsType', $law);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($law);
            $em->flush();

            return $this->redirectToRoute('manage_laws_show', array('id' => $law->getId()));
        }

        return $this->render('laws/edit.html.twig', array(
            'laws' => $law,
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Laws entity.
     *
     * @Route("/{id}", name="manage_laws_show")
     * @Method("GET")
     */
    public function showAction(Laws $law)
    {
        $deleteForm = $this->createDeleteForm($law);

        return $this->render('laws/show.html.twig', array(
            'laws' => $law,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Laws entity.
     *
     * @Route("/{id}/edit", name="manage_laws_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Laws $law)
    {
        $deleteForm = $this->createDeleteForm($law);
        $editForm = $this->createForm('AppBundle\Form\LawsType', $law);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($law);
            $em->flush();

            return $this->redirectToRoute('manage_laws_show', array('id' => $law->getId()));
        }

        return $this->render('funds/edit.html.twig', array(
            'fund' => $fundlinks->getFund(),
            'h1' => 'Editar enlace a ley',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fundlinks->getFund()->getId())),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        ));

    }

    /**
     * Deletes a Laws entity.
     *
     * @Route("/{id}", name="manage_laws_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Laws $law)
    {
        $form = $this->createDeleteForm($law);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($law);
            $em->flush();
        }

        return $this->redirectToRoute('manage_laws_index');
    }

    /**
     * Creates a form to delete a Laws entity.
     *
     * @param Laws $law The Laws entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Laws $law)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_laws_delete', array('id' => $law->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
