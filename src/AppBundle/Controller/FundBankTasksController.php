<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\FundBanks;
use AppBundle\Entity\FundBankTasks;
use AppBundle\Form\FundBankTasksType;

/**
 * Funds controller.
 *
 * @Route("/manage/funds/banks/tasks")
 */
class FundBankTasksController extends Controller
{

    /**
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/{id}", name="manage_fundbanks_tasks_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, FundBankTasks $banktasks)
    {
        $em = $this->getDoctrine()->getManager();
        $banktasks = $em->getRepository('AppBundle:FundBankTasks')->findOneBy(array('id' => $fundbanks->getBankid()));


        return $this->render('funds/tasks.html.twig', array(
            'action' => 'Listado de tareas',
            'banktasks' => $banktasks,
        ));
    }

    /**
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/{id}/edit", name="manage_fundbanks__tasks_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FundBankTasks $banktasks)
    {
//        $fund = $em->getRepository('AppBundle:Funds')->findOneBy(array('id' => $fundbanks->getFund()));
        $deleteForm = $this->createDeleteForm($banktasks);
        $editform = $this->createForm('AppBundle\Form\FundBankTasksType', $banktasks);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($banktasks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_banks_show', array('id' => $banktasks->getBankid()));
        }

        return $this->render('funds/tasks.html.twig', array(
            'banktasks' => $banktasks,
            'action' => 'Edición de tareas',
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundBanks entity.
     *
     * @Route("/{id}/delete", name="manage_fundbanks_tasks_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, FundBankTasks $banktasks)
    {
        $form = $this->createDeleteForm($fundbanks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($banktasks);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_banks_show', array('id' => $banktasks->getBankid()));
    }

    /**
     * Creates a form to delete a FundBanks entity.
     *
     * @param FundBanks $fundbanks The FundBanks entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FundBankTasks $banktasks)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_fundbanks_tasks_delete', array('id' => $banktasks->getBankid())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
