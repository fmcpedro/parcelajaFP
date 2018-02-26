<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Broker;
use AppBundle\Entity\BrokerPurchaseSearch;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Broker controller.
 *
 */
class BrokerController extends Controller {

    public function brokerPurchasesAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $brokerPurchaseSearch = new BrokerPurchaseSearch();
        $searchForm = $this->createForm('AppBundle\Form\BrokerPurchaseSearchType', $brokerPurchaseSearch);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $search = array();
            $startDate = $searchForm["startDate"]->getData();
            $endDate = $searchForm["endDate"]->getData();
            $brokerId = $searchForm["brokerId"]->getData();

            if (!empty($startDate)) {
                $search['startDate'] = $startDate;
            }

            if (!empty($endDate)) {
                $search['endDate'] = $endDate;
            }

            if (!empty($brokerId)) {
                $search['brokerId'] = $brokerId;
            }

            $purchases = $em->getRepository('AppBundle:Tpurchase')->findPurchasesByBroker($search);
        } else {
            $purchases = null;
        }

        return $this->render('broker/brokerPurchases.html.twig', array(
                    'purchases' => $purchases,
                    'search_form' => $searchForm->createView(),
        ));
    }

    /**
     * Lists all broker entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $brokers = $em->getRepository('AppBundle:Broker')->findAll();

        return $this->render('broker/index.html.twig', array(
                    'brokers' => $brokers,
        ));
    }

    /**
     * Creates a new broker entity.
     *
     */
    public function newAction(Request $request) {
        $broker = new Broker();
        $form = $this->createForm('AppBundle\Form\BrokerType', $broker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($broker);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'notice', 'Broker registado com sucesso!'
            );

//            return $this->redirectToRoute('admin_broker_show', array('id' => $broker->getId()));
            return $this->redirectToRoute('admin_broker_edit', array('id' => $broker->getId()));
        }

        return $this->render('broker/new.html.twig', array(
                    'broker' => $broker,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a broker entity.
     *
     */
//    public function showAction(Broker $broker)
//    {
//        $deleteForm = $this->createDeleteForm($broker);
//
//        return $this->render('broker/show.html.twig', array(
//            'broker' => $broker,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing broker entity.
     *
     */
    public function editAction(Request $request, Broker $broker) {
        $deleteForm = $this->createDeleteForm($broker);
        $editForm = $this->createForm('AppBundle\Form\BrokerType', $broker);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                    'notice', 'Broker actualizado com sucesso!'
            );

            return $this->redirectToRoute('admin_broker_edit', array('id' => $broker->getId()));
        }

        return $this->render('broker/edit.html.twig', array(
                    'broker' => $broker,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a broker entity.
     *
     */
    public function deleteAction(Request $request, Broker $broker) {
        $form = $this->createDeleteForm($broker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($broker);
            $em->flush();
        }

        return $this->redirectToRoute('admin_broker_index');
    }

    /**
     * Creates a form to delete a broker entity.
     *
     * @param Broker $broker The broker entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Broker $broker) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_broker_delete', array('id' => $broker->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
