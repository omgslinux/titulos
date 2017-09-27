<?php

namespace AppBundle\Controller\admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Banks;
use AppBundle\Entity\BankCategory;

/**
 * Banks controller.
 *
 * @Route("/admin/bankcategories")
 */
class BankCategoryController extends Controller
{
    /**
     * Lists all BankCategory entities
     *
     * @Route("/", name="admin_bankcategories_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:BankCategory')->findAll();

        return $this->render('admin/banks/category.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Creates a new BankCategory entity.
     *
     * @Route("/new", name="admin_bankcategories_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $category = new BankCategory();
        $form = $this->createForm('AppBundle\Form\BankCategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_bankcategories_index');
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Crear categoría ',
            'backlink' => $this->generateUrl('admin_bankcategories_index'),
            'backmessage' => 'Volver al listado',
            'create_form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Banks entity.
     *
     * @Route("/{id}", name="admin_bankcategories_show")
     * @Method("GET")
     */
    public function showAction(BankCategory $category)
    {

        return $this->render('admin/banks/show.html.twig', array(
            'category' => $category,
        ));
    }

    /**
     * Displays a form to edit an existing BankCategory entity.
     *
     * @Route("/{id}/edit", name="admin_bankcategories_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BankCategory $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('AppBundle\Form\BankCategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_bankcategories_index');
        }

        return $this->render('default/edit.html.twig', array(
            'action' => 'Editar categoría ',
            'backlink' => $this->generateUrl('admin_bankcategories_index'),
            'backmessage' => 'Volver al listado',
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a BankCategory entity.
     *
     * @Route("/{id}", name="admin_bankcategories_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BankCategory $category)
    {
        $form = $this->createDeleteForm($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
        }

        return $this->redirectToRoute('admin_bankcategories_index');
    }

    /**
     * Creates a form to delete a BankCategory entity.
     *
     * @param BankCategory $category The BankCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BankCategory $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_bankcategories_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
