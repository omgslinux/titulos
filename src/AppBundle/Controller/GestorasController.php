<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Gestoras;
use AppBundle\Form\GestorasType;

/**
 * Gestoras controller.
 *
 * @Route("/manage/gestoras/")
 */
class GestorasController extends Controller
{
    /**
     * Lists all Gestoras entities.
     *
     * @Route("/", name="manage_gestoras_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gestoras = $em->getRepository('AppBundle:Gestoras')->findAll();

        return $this->render('gestoras/index.html.twig', array(
            'gestoras' => $gestoras,
        ));
    }

    /**
     * Creates a new Gestoras entity.
     *
     * @Route("/new", name="manage_gestoras_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $gestora = new Gestoras();
        $form = $this->createForm('AppBundle\Form\GestorasType', $gestora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gestora);
            $em->flush();

            return $this->redirectToRoute('manage_gestoras_show', array('id' => $gestora->getId()));
        }

        return $this->render('gestoras/new.html.twig', array(
            'gestora' => $gestora,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Gestoras entity.
     *
     * @Route("/{id}", name="manage_gestoras_show")
     * @Method("GET")
     */
    public function showAction(Gestoras $gestora)
    {
        $deleteForm = $this->createDeleteForm($gestora);

        return $this->render('gestoras/show.html.twig', array(
            'gestora' => $gestora,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Gestoras entity.
     *
     * @Route("/{id}/edit", name="manage_gestoras_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Gestoras $gestora)
    {
        $deleteForm = $this->createDeleteForm($gestora);
        $editForm = $this->createForm('AppBundle\Form\GestorasType', $gestora);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gestora);
            $em->flush();

            return $this->redirectToRoute('manage_gestoras_edit', array('id' => $gestora->getId()));
        }

        return $this->render('gestoras/edit.html.twig', array(
            'gestora' => $gestora,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Gestoras entity.
     *
     * @Route("/{id}", name="manage_gestoras_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Gestoras $gestora)
    {
        $form = $this->createDeleteForm($gestora);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gestora);
            $em->flush();
        }

        return $this->redirectToRoute('manage_gestoras_index');
    }

    /**
     * Creates a form to delete a Gestoras entity.
     *
     * @param Gestoras $gestora The Gestoras entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gestoras $gestora)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_gestoras_delete', array('id' => $gestora->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
