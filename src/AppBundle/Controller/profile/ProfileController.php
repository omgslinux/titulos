<?php

namespace AppBundle\Controller\profile;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Users;
use AppBundle\Entity\FundBankTasks;

/**
 * Profile controller.
 *
 * @Route("/profile")
 */
class ProfileController extends Controller
{

    /**
     * Index for User profile
     *
     * @Route("/user/", name="profile_user_index",
     * methods={"GET"})
     */
    public function userAction(Request $request)
    {
        //$em = $this->getDoctrine()->getManager();
        //$user = $em->getRepository('AppBundle:Users')->findOneBy(array('id', $this->getUser()->getId()));
        $user = $this->getUser();

        return $this->render('profile/user.html.twig', array(
            'user' => $user,
            'action' => 'Datos del usuario ' . $user,
        ));
    }

    /**
     * Index for User profile
     *
     * @Route("/tasks/", name="profile_tasks_index",
     * methods={"GET"})
     */
    public function tasksAction(Request $request)
    {
        //$em = $this->getDoctrine()->getManager();
        //$user = $em->getRepository('AppBundle:Users')->findOneBy(array('id', $this->getUser()->getId()));
        $user = $this->getUser();

        return $this->render('profile/tasks.html.twig', array(
            'user' => $user,
            'action' => 'Tareas del usuario ' . $user,
            'backlink' => $this->generateUrl('profile_user_index'),
            'backmessage' => 'Volver al listado',
        ));
    }

    /**
     * Creates a form to edit a Users entity.
     *
     * @Route("/tasks/{id}/edit", name="profile_tasks_edit",
     * methods={"GET", "POST"})
     */
    public function taskeditAction(Request $request, FundBankTasks $banktasks)
    {

        $deleteForm = $this->createDeleteTaskForm($banktasks);
        $editform = $this->createForm('AppBundle\Form\FundBankTasksType', $banktasks);
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($banktasks);
            $em->flush();

            return $this->redirectToRoute('profile_tasks_index');
        }

        return $this->render('profile/edit.html.twig', array(
            'action' => 'Editando tarea ',
            'backlink' => $this->generateUrl('profile_tasks_index'),
            'backmessage' => 'Volver al listado de tareas',
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Creates a form to edit a Users entity.
     *
     * @Route("/user/edit", name="profile_user_edit",
     * methods={"GET", "POST"})
     */
    public function usereditAction(Request $request)
    {
        $user = $this->getUser();

        $deleteForm = $this->createDeleteForm($user);
        $editform = $this->createForm('AppBundle\Form\profile\UserType', $user, array('require_password' => false));
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (null != $user->getPlainpassword()) {
                $encoder = $this->get('security.password_encoder');
                $encodedPassword = $encoder->encodePassword($user, $user->getPlainpassword());
                $user->setPassword($encodedPassword);
            }
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profile_user_index', array('id' => $user->getId()));
        }

        return $this->render('profile/edit.html.twig', array(
            'user' => $user,
            'action' => 'Editando usuario',
            'backlink' => $this->generateUrl('profile_user_index'),
            'backmessage' => 'Volver al índice',
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $fund The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Users $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profile_user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Deletes a FundBankTasks entity.
     *
     * @Route("/user/{id}/delete", name="profile_user_delete",
     * methods={"GET", "DELETE"})
     */
    public function deleteAction(Request $request, Users $user)
    {
        $form = $this->createDeleteTaskForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('logout');
    }

    /**
     * Deletes a FundBankTasks entity.
     *
     * @Route("/tasks/{id}/delete", name="profile_task_delete",
     * methods={"GET", "DELETE"})
     */
    public function deleteTaskAction(Request $request, FundBankTasks $banktask)
    {
        $form = $this->createDeleteTaskForm($banktask);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($banktask);
            $em->flush();
        }

        return $this->redirectToRoute('profile_tasks_index');
    }



    /**
     * Creates a form to delete a FundBankTasks entity.
     *
     * @param FundBankTasks $banktasks The FundBankTasks entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteTaskForm(FundBankTasks $banktask)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profile_task_delete', array('id' => $banktask->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
