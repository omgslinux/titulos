<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Securities;
use AppBundle\Form\SecuritiesType;
use AppBundle\Entity\FundBanks;

/**
 * Securities controller.
 *
 * @Route("/manage/securities")
 */
class SecuritiesController extends Controller
{
    /**
     * Lists all Securities entities.
     *
     * @Route("/", name="manage_securities_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $securities = $em->getRepository('AppBundle:Securities')->findAll();

        return $this->render('securities/index.html.twig', array(
            'securities' => $securities,
        ));
    }

    /**
     * Creates a new Securities entity.
     *
     * @Route("/new", name="manage_securities_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $security = new Securities();
        $form = $this->createForm('AppBundle\Form\SecuritiesType', $security);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($security);
            $em->flush();

            return $this->redirectToRoute('manage_securities_show', array('id' => $security->getId()));
        }

        return $this->render('securities/new.html.twig', array(
            'security' => $security,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Securities entity.
     *
     * @Route("search/", name="manage_securities_search")
     * @Method("GET")
     */
    public function searchAction(Securities $security)
    {
        $deleteForm = $this->createDeleteForm($security);

        return $this->render('securities/search.html.twig', array(
            'security' => $security,
        ));
    }

    /**
     * Finds and displays a Securities entity.
     *
     * @Route("/{id}", name="manage_securities_show")
     * @Method("GET")
     */
    public function showAction(Securities $security)
    {
        $deleteForm = $this->createDeleteForm($security);

        return $this->render('securities/show.html.twig', array(
            'security' => $security,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Securities entity.
     *
     * @Route("/{id}/edit", name="manage_securities_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Securities $security)
    {
        $deleteForm = $this->createDeleteForm($security);
        $editForm = $this->createForm('AppBundle\Form\SecuritiesType', $security);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($security);
            $em->flush();

            return $this->redirectToRoute('manage_securities_edit', array('id' => $security->getId()));
        }

        return $this->render('securities/edit.html.twig', array(
            'security' => $security,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Securities entity.
     *
     * @Route("/{id}", name="manage_securities_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Securities $security)
    {
        $form = $this->createDeleteForm($security);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($security);
            $em->flush();
        }

        return $this->redirectToRoute('manage_securities_index');
    }

    /**
     * Creates a form to delete a Securities entity.
     *
     * @param Securities $security The Securities entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Securities $security)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_securities_delete', array('id' => $security->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to load a Securities entity.
     *
     * @param Securities $security The Securities entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createLoadForm(Securities $security)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('manage_securities_delete', array('id' => $security->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Loads the contents of a csv file into Securities from a FundBanks entity
     *
     * @Route("/{id}/load", name="manage_securities_load")
     * @Method({"GET", "POST"})
     */
    public function loadAction(Request $request, FundBanks $fundbank)
    {
        $filename = $request->get('filename');
        $rootdir = $this->getParameter('pdf_rootdir');
        $full = $rootdir . '/' . $filename;
        $records = $this->get('app.readcsv')->readcsv($filename);
        $fields = array(
            'creditnumber',
            'startdate',
            'duration',
            'amount',
            'city' =>  array(
                'entity' => 'Cities'
            ),
            'volume',
            'book',
            'folio',
            'building',
            'page'
        );
        print_r($_POST);
        die(print_r($records));

        sleep(5);
        $em = $this->getDoctrine()->getManager();
        foreach ($records as $recordkey => $record) {
            $security = new Securities($fundbank);
            foreach ($fields as $fieldkey => $value) {
            //    echo "field: ($field), v: ($value), record[value]:" . $record[$value] . "\n";
                if (in_array($value, $fields ))
                {
                    if (is_array($value)) {
                        $object = $em->getRepository('AppBundle:' . $fieldkey['entity'])->findBy(array($value => $record[$value]));
                        $contents = $object;
                    } else {
                        $contents = $record[$value];
                    }
                    $function= '$security->set' . ucfirst() . '('.$contents.');';
                    eval($function);
                    //$values .= "'" . $record["$value"] . "'";
                }
            }
            $em->persist($security);
        }
        $em->flush();

        return $this->redirectToRoute('manage_funds_banks_show', array('id' => $fundbank->getId()));

    }


}
