<?php

namespace AppBundle\Controller\admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Roles;
use AppBundle\Entity\Users;

/**
 * Funds controller.
 *
 * @Route("/admin/users")
 */
class UsersController extends Controller
{

    /**
     * Index for all Users entity.
     *
     * @Route("/", name="admin_users_index",
     * methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Users')->findAll();


        return $this->render('admin/users/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new Users entity.
     *
     * @Route("/new", name="admin_users_new",
     * methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new Users();
        $createForm = $this->createForm('AppBundle\Form\UsersType', $user);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->get('security.password_encoder');
            $encodedPassword = $encoder->encodePassword($user, $user->getPlainpassword());
            $user->setPassword($encodedPassword);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('default/edit.html.twig', array(
            'user' => $user,
            'action' => 'Crear usuario',
            'backlink' => $this->generateUrl('admin_users_index'),
            'backmessage' => 'Volver al listado',
            'create_form' => $createForm->createView(),
        ));
    }

    /**
     * Finds and displays a Users entity.
     *
     * @Route("/{id}", name="admin_users_show",
     * methods={"GET"})
     */
    public function showAction(Request $request, Users $user)
    {

        return $this->render('admin/users/show.html.twig', array(
            'user' => $user,
            'backlink' => $this->generateUrl('admin_users_index'),
            'backmessage' => 'Volver al listado de usuarios',
        ));
    }

    /**
     * Creates a form to edit a Users entity.
     *
     * @Route("/{id}/edit", name="admin_users_edit",
     * methods={"GET", "POST"})
     */
    public function editAction(Request $request, Users $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editform = $this->createForm('AppBundle\Form\UsersType', $user, array('require_password' => false));
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

            return $this->redirectToRoute('admin_users_show', array('id' => $user->getId()));
        }

        return $this->render('default/edit.html.twig', array(
            'user' => $user,
            'action' => 'Editando usuario',
            'backlink' => $this->generateUrl('admin_users_show', array('id' => $user->getId())),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Users entity.
     *
     * @Route("/{id}/delete", name="admin_users_delete",
     * methods={"GET", "DELETE"})
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

        return $this->redirectToRoute('admin_users_show', array('id' => $users->getId()));
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
            ->setAction($this->generateUrl('admin_users_delete', array('id' => $users->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new Roles entity.
     *
     * @Route("/{id}/roles/new", name="admin_user_roles_new",
     * methods={"GET", "POST"})
     */
    public function rolesnewAction(Request $request, Users $user)
    {
        $roles = new Roles();
        $createForm = $this->createForm('AppBundle\Form\RolesType', $roles);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($roles);
            $em->flush();

            return $this->redirectToRoute('admin_users_show', array('id' => $user->getId()));
        }

        return $this->render('admin/users/roles.html.twig', array(
            'users' => $user,
            'roles' => array('EDITOR', 'MANAGER','ADMIN'),
            'action' => 'Añadir rol',
            'create_form' => $createForm->createView(),
        ));
    }
}
