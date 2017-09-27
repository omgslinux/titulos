<?php

namespace AppBundle\Controller\manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\InterestRates;

/**
 * InterestRates controller.
 *
 * @Route("/manage/rates")
 */
class InterestRatesController extends Controller
{
    /**
     * Lists all InterestRates entities.
     *
     * @Route("/", name="manage_rates_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rates = $em->getRepository('AppBundle:InterestRates')->findAll();

        return $this->render('manage/rates/index.html.twig', array(
            'rates' => $rates,
        ));
    }

    /**
     * Creates a new InterestRates entity.
     *
     * @Route("/new", name="manage_rates_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rate = new InterestRates();
        $form = $this->createForm('AppBundle\Form\InterestRatesType', $rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rate);
            $em->flush();

            return $this->redirectToRoute('manage_rates_index');
        }

        return $this->render('default/edit.html.twig', array(
            'rate' => $rate,
            'action' => 'Crear índice interés ',
            'backlink' => $this->generateUrl('manage_rates_index'),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a InterestRates entity.
     *
     * @Route("/{id}", name="manage_rates_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(InterestRates $rate)
    {
        //$deleteForm = $this->createDeleteForm($fund);

        return $this->render('manage/rates/show.html.twig', array(
            'rate' => $rate,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing InterestRates entity.
     *
     * @Route("/{id}/edit", name="manage_rates_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, InterestRates $rate)
    {
        $deleteForm = $this->createDeleteForm($rate);
        $editForm = $this->createForm('AppBundle\Form\InterestRatesType', $rate);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rate);
            $em->flush();

            return $this->redirectToRoute('manage_rates_show', array('id' => $rate->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'rate' => $rate,
            'action' => 'Editar índice interés',
            'backlink' => $this->generateUrl('manage_rates_show', array('id' => $rate->getId())),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a InterestRates entity.
     *
     * @Route("/{id}", name="manage_rates_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, InterestRates $rate)
    {
        $form = $this->createDeleteForm($rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rate);
            $em->flush();
        }

        return $this->redirectToRoute('manage_rates_index');
    }

    /**
     * Creates a form to delete a InterestRates entity.
     *
     * @param Funds $fund The Funds entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(InterestRates $rate)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_rates_delete', array('id' => $rate->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
