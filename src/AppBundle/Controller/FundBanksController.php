<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Funds;
use AppBundle\Entity\FundBanks;
use AppBundle\Entity\FundBankTasks;
use AppBundle\Form\FundBanksType;

/**
 * Funds controller.
 *
 * @Route("/manage/funds/banks")
 */
class FundBanksController extends Controller
{

    /**
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/{id}", name="manage_funds_banks_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request,FundBanks $fundbanks)
    {
        $em = $this->getDoctrine()->getManager();
        $banktasks = $em->getRepository('AppBundle:FundBankTasks')->findBy(array('fundbank' => $fundbanks->getId()));


        return $this->render('funds/banks.html.twig', array(
            'fundbanks' => $fundbanks,
            'banktasks' => $banktasks,
        ));
    }

    /**
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/{id}/edit", name="manage_funds_banks_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,FundBanks $fundbanks)
    {
//        $fund = $em->getRepository('AppBundle:Funds')->findOneBy(array('id' => $fundbanks->getFund()));
        $deleteForm = $this->createDeleteForm($fundbanks);
        $editform = $this->createForm('AppBundle\Form\FundBanksType', $fundbanks);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fundbanks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_show', array('id' => $fundbanks->getFundid()));
        }

        return $this->render('funds/banks.html.twig', array(
            'fundbanks' => $fundbanks,
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundBanks entity.
     *
     * @Route("/{id}/delete", name="manage_funds_banks_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, FundBanks $fundbanks)
    {
        $form = $this->createDeleteForm($fundbanks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fundbanks);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_show', array('id' => $fundbanks->getFundid()));
    }

    /**
     * Creates a form to delete a FundBanks entity.
     *
     * @param FundBanks $fundbanks The FundBanks entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FundBanks $fundbanks)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_funds_banks_delete', array('id' => $fundbanks->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new FundBankTasks entity.
     *
     * @Route("/{id}/tasks/new", name="manage_fundbanks_tasks_new")
     * @Method({"GET", "POST"})
     */
    public function tasksnewAction(Request $request,FundBanks $fundbank)
    {
        //$fundlinks = $em->getRepository('AppBundle:FundLinks')->find($fund);
        $banktasks = new FundBankTasks($fundbank);
        $createForm = $this->createForm('AppBundle\Form\FundBankTasksType', $banktasks);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($banktasks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_banks_show', array('id' => $banktasks->getBankid()));
        }

        return $this->render('funds/tasks.html.twig', array(
            'banktasks' => $banktasks,
            'action' => 'Crear tarea',
            'create_form' => $createForm->createView(),
        ));
    }




}
