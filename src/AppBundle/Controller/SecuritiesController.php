<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Securities;
use AppBundle\Entity\Cities;
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
        $filename = urldecode($request->get('filename'));
        $rootdir = $this->getParameter('pdf_rootdir');
        $full = $rootdir . '/' . $filename;
        $records = $this->get('app.readcsv')->readcsv($filename);
        $fields = array(
            'creditnumber' => true,
            'startdate' => array(
                'type' => array(
                    'date' => true,
                    'format' => 'Y-m-d'
                )
            ),
            'duration' => true,
            'amount' => true,
            'city' => array(
                'type' => array(
                    'entity' => true,
                    'class' => 'Cities',
                    'property' => 'city',
                    'mappedBy' => 'city'
                )
            ),
            'city_id' => array(
                'type' => array(
                    'entity' => true,
                    'class' => 'Cities',
                    'property' => 'city',
                    'mappedBy' => 'id'
                )
            ),
            'volume' => true,
            'book' => true,
            'folio' => true,
            'building' => true,
            'page' => true
        );
        printf("fields: (%s)\n<br><br>", print_r($fields, true));

        //sleep(5);
        $em = $this->getDoctrine()->getManager();
        foreach ($records as $recordkey => $record) {
            printf("recordkey: (%s)\n<br><br>", print_r($record, true));
            $security = new Securities();
            $security->setFundbank($fundbank);
            foreach ($record as $field => $value) {
                if (!empty($fields["$field"])) {
                    printf("<strong>field</strong>: (line %s) (%s) ", __LINE__, $field);
                    echo "<strong>value</strong>: ($value)\n<br>";
                    $property = $field;
                    if (!is_array($fields["$field"])) {
                        $function = '$security->set' . ucfirst($property) . '(\'' . $value. '\');';
                    } else {
                        $properties = $fields["$field"];
                        printf("<strong>properties</strong>: (line %s), (%s)\n<br>", __LINE__, print_r($properties, true));
                        if (!empty($properties['type'])) {
                            $types=$properties['type'];
                            foreach ($types as $type => $v) {
                                printf("<strong>type</strong>: (line %s), (%s)<br>", __LINE__, print_r($type, true));
                                switch ($type) {
                                    case 'date':
                                        $date = $types['date'];
                                        printf("<strong>date</strong>: (line %s) (%s)<br>", __LINE__, print_r($date, true));
                                        $format = $types['format'];
                                        $classobject = \DateTime::createFromFormat($format, $value);
                                        printf("<strong>classobject</strong>: (line %s) (%s)<br>", __LINE__, $classobject->format($format));
                                        break;
                                    case 'entity':
                                        $entity = $properties['type'];
                                        printf("<strong>entity</strong>: (line %s) (%s)<br>", __LINE__, print_r($entity, true));
                                        $property = $entity['property'];
                                        $class = $entity['class'];
                                        $mappedby = $entity['mappedBy'];
                                        printf("<strong>class</strong>: (line %s) (%s)<br>", __LINE__, $class);
                                        $eval = '$classobject = new AppBundle\Entity\\'. $class . '();';
                                        printf("eval (line %s): (%s)", __LINE__, $eval);
                                        eval($eval);
                                        $classobject = $em->getRepository('AppBundle:' . $class)
                                            ->findOneBy(array($mappedby => $value));
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            }
                            $function= '$security->set' . ucfirst($property) . '($classobject);';
                        } else {
                            //$function= '$security->set' . ucfirst($property) . '($object);';
                        }
                    }
                    printf("\n<strong>function</strong> (line %s): %s\n<br><br>", __LINE__, $function);
                    eval($function);
                }
            }
            $em->persist($security);
        }
        $em->flush();

        return $this->redirectToRoute('manage_funds_banks_show', array('id' => $fundbank->getId()));
    }
}
