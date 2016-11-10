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
 * @Route("/manage/funds/banks")
 */
class FundBankTasksController extends Controller
{

    /**
     * Creates a new FundBankTasks entity.
     *
     * @Route("/{id}/tasks/new", name="manage_fundbanks_tasks_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, FundBanks $fundbank)
    {
        //$fundlinks = $em->getRepository('AppBundle:FundLinks')->find($fund);
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

        return $this->render('funds/tasks.html.twig', array(
            'fundbank' => $fundbank,
            'action' => 'Crear tarea',
            'create_form' => $createForm->createView(),
        ));
    }

    /**
     * Creates a form to show a FundBankTasks entity.
     *
     * @Route("/tasks/{id}", name="manage_fundbanks_tasks_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, FundBank $fundbank)
    {
        //$em = $this->getDoctrine()->getManager();
        //$banktasks = $em->getRepository('AppBundle:FundBankTasks')->findOneBy(array('id' => $fundbanks->getBankid()));



        return $this->render('funds/tasks.html.twig', array(
            'action' => 'Listado de tareas',
            'fundbank' => $fundbank,
        ));
    }

    /**
     * Creates a form to edit a FundBanks entity.
     *
     * @Route("/tasks/{id}/edit", name="manage_fundbanks__tasks_edit")
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
     * @Route("/tasks/{id}/delete", name="manage_fundbanks_tasks_delete")
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
