<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Roles;
use AppBundle\Entity\Users;

/**
 * Funds controller.
 *
 * @Route("/manage/users")
 */
class UsersController extends Controller
{

    /**
     * Index for all Users entity.
     *
     * @Route("/", name="manage_users_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Users')->findAll();


        return $this->render('users/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a form to edit a Users entity.
     *
     * @Route("/{id}", name="manage_users_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request,Users $user)
    {
        $em = $this->getDoctrine()->getManager();
    //    $banktasks = $em->getRepository('AppBundle:FundBankTasks')->findAll(array('fundbank' => $fundbanks->getId()));


        return $this->render('users/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Creates a form to edit a Users entity.
     *
     * @Route("/{id}/edit", name="manage_users_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,Users $user)
    {
//        $fund = $em->getRepository('AppBundle:Funds')->findOneBy(array('id' => $fundbanks->getFund()));
        $deleteForm = $this->createDeleteForm($user);
        $editform = $this->createForm('AppBundle\Form\UsersType', $user, array('require_password' => false));
        $editform->handleRequest($request);

        if ($editform->isSubmitted() && $editform->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (null != $user->getPlainpassword()) {
                $encoder = $this->get('security.password_encoder');
                $encodedPassword = $encoder->encodePassword($user,$user->getPlainpassword());
                $user->setPassword($encodedPassword);
            }
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('manage_users_show', array('id' => $user->getId()));
        }

        return $this->render('users/edit.html.twig', array(
            'users' => $user,
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Users entity.
     *
     * @Route("/{id}/delete", name="manage_users_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, Users $users)
    {
        $form = $this->createDeleteForm($users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($users);
            $em->flush();
        }

        return $this->redirectToRoute('manage_users_show', array('id' => $users->getId()));
    }

    /**
     * Creates a form to delete a Users entity.
     *
     * @param Users $users The Users entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Users $users)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_users_delete', array('id' => $users->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new Users entity.
     *
     * @Route("/new", name="manage_users_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        //$fundlinks = $em->getRepository('AppBundle:FundLinks')->find($fund);
        $user = new Users;
        $createForm = $this->createForm('AppBundle\Form\RolesType', $user);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->get('security.password_encoder');
            $encodedPassword = $encoder->encodePassword($user,$user->getPlainpassword());
            $user->setPassword($encodedPassword);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('manage_users_index');
        }

        return $this->render('users/edit.html.twig', array(
            'users' => $user,
            'roles' => array('EDITOR', 'MANAGER','ADMIN'),
            'action' => 'Crear usuario',
            'create_form' => $createForm->createView(),
        ));
    }

    /**
     * Creates a new Roles entity.
     *
     * @Route("/{id}/roles/new", name="manage_user_roles_new")
     * @Method({"GET", "POST"})
     */
    public function rolesnewAction(Request $request,Users $users)
    {
        //$fundlinks = $em->getRepository('AppBundle:FundLinks')->find($fund);
        $roles = new Roles($users);
        $createForm = $this->createForm('AppBundle\Form\RolesType', $roles);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($roles);
            $em->flush();

            return $this->redirectToRoute('manage_users_show', array('id' => $users->getId()));
        }

        return $this->render('users/roles.html.twig', array(
            'users' => $users,
            'roles' => array('EDITOR', 'MANAGER','ADMIN'),
            'action' => 'Añadir rol',
            'create_form' => $createForm->createView(),
        ));
    }




}
