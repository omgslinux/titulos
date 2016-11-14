<?php

namespace AppBundle\Controller\profile;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Funds controller.
 *
 * @Route("/profile/user")
 */
class UserController extends Controller
{

    /**
     * Index for User profile
     *
     * @Route("/", name="profile_user_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:Users')->findOneBy(array('id', $this->getUser()->getId()));

        return $this->render('profile/edit.html.twig', array(
            'user' => $user,
            'action' => 'Editar perfil de usuario'
        ));
    }


    /**
     * Creates a form to edit a Users entity.
     *
     * @Route("/edit", name="profle_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        //$em = $this->getDoctrine()->getManager();
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
            'backlink' => $this->generateUrl('admin_users_show', array('id' => $user->getId())),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editform->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
