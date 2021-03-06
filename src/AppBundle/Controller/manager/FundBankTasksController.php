<?php

namespace AppBundle\Controller\manager;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\FundBanks;
use AppBundle\Entity\FundBankTasks;
use AppBundle\Form\FundBankTasksType;

/**
 * Funds controller.
 *
 * @Route("/manage/funds/banks")
 */
class FundBankTasksController extends Controller
{

    /**
     * Creates a new FundBankTasks entity.
     *
     * @Route("/{id}/tasks/new", name="manage_fundbanks_tasks_new",
     * methods={"GET", "POST"})
     */
    public function newAction(Request $request, FundBanks $fundbank)
    {
        $banktask = new FundBankTasks();
        $fundbank->addTask($banktask);
        $createForm = $this->createForm('AppBundle\Form\FundBankTasksType', $banktask);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($banktask);
            $em->flush();

            return $this->redirectToRoute('manage_funds_banks_show', array('id' => $banktask->getBankid()));
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Crear tarea para la entidad ' . $fundbank->getBank() . '(' . $fundbank->getLoantype() . ')',
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $fundbank->getFund()->getId())),
            'backmessage' => 'Volver al fondo ' . $fundbank->getFund(),
            'create_form' => $createForm->createView(),
        ));
    }

    /**
     * Creates a form to show a FundBankTasks entity.
     *
     * @Route("/tasks/{id}", name="manage_fundbanks_tasks_show",
     * methods={"GET", "POST"})
     */
    public function showAction(Request $request, FundBank $fundbank)
    {
        return $this->render('manage/funds/tasks.html.twig', array(
            'action' => 'Listado de tareas',
            'fundbank' => $fundbank,
        ));
    }

    /**
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/tasks/{id}/edit", name="manage_fundbanks__tasks_edit",
     * methods={"GET", "POST"})
     */
    public function editAction(Request $request, FundBankTasks $banktasks)
    {
        $deleteForm = $this->createDeleteForm($banktasks);
        $editform = $this->createForm('AppBundle\Form\FundBankTasksType', $banktasks);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($banktasks);
            $em->flush();

            return $this->redirectToRoute('manage_funds_banks_show', array('id' => $banktasks->getBankid()));
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Edición de tareas para la entidad ' . $banktasks->getBankname(),
            'backlink' => $this->generateUrl('manage_funds_show', array('id' => $banktasks->getFundbank()->getFund()->getId())),
            'backmessage' => 'Volver al fondo ' . $banktasks->getFundbank()->getFund(),
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a FundBanks entity.
     *
     * @Route("/tasks/{id}/delete", name="manage_fundbanks_tasks_delete",
     * methods={"GET", "DELETE"})
     */
    public function deleteAction(Request $request, FundBankTasks $banktasks)
    {
        $id = $banktasks->getBankid();
        $form = $this->createDeleteForm($banktasks);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($banktasks);
            $em->flush();
        }

        return $this->redirectToRoute('manage_funds_banks_show', array('id' => $id));
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
            ->setAction($this->generateUrl('manage_fundbanks_tasks_delete', array('id' => $banktasks->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
