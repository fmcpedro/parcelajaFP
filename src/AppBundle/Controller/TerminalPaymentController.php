<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TerminalPayment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Terminalpayment controller.
 *
 */
class TerminalPaymentController extends Controller {

    /**
     * Lists all terminalPayment entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();


        $terminalPayment = new TerminalPayment();
        $searchForm = $this->createForm('AppBundle\Form\TerminalPaymentSearchType', $terminalPayment);
        $searchForm->handleRequest($request);


        if ($searchForm->isSubmitted()) {


            $terminal = $searchForm["terminal"]->getData();
            $year = $searchForm["year"]->getData();
            $month = $searchForm["month"]->getData();
            
            $group = $searchForm["group"]->getData();
            $subGroup = $searchForm["subGroup"]->getData();
            $agency = $searchForm["agency"]->getData();
            $value = $searchForm["value"]->getData();
            
            
            $search = array();
            if (!empty($terminal)) {
                $search['terminal'] = $terminal;
            }

            if (!empty($year)) {
                $search['year'] = $year;
            }

            if (!empty($month)) {
                $search['month'] = $month;
            }




            if (!empty($group)) {
                $search['group'] = $group;
            }

            if (!empty($subGroup)) {
                $search['subGroup'] = $subGroup;
            }

            if (!empty($agency)) {
                $search['agency'] = $agency;
            }

            if (!empty($value)) {
                $search['value'] = $value;
            }
            
            
            $terminalPayments = $em->getRepository('AppBundle:TerminalPayment')->findByJoinTerminalAndAgency($search);


            //$search = array('fserial' => $fserial, 'fstate' => $fstate, 'fsoftversion' => $fsoftversion, 'fagencyid' => $fagencyid);
        } else {
            $terminalPayments = $em->getRepository('AppBundle:TerminalPayment')->findAll();
        }


        return $this->render('terminalpayment/index.html.twig', array(
                    'search_form' => $searchForm->createView(),
                    'terminalPayments' => $terminalPayments,
        ));
    }

    /**
     * Creates a new terminalPayment entity.
     *
     */
    public function newAction(Request $request) {
        $terminalPayment = new Terminalpayment();
        $form = $this->createForm('AppBundle\Form\TerminalPaymentType', $terminalPayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($terminalPayment);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                    'notice', 'Pagamento de Terminal registado!'
            );

            //return $this->redirectToRoute('admin_terminal_payment_show', array('id' => $terminalPayment->getId()));
            return $this->redirectToRoute('admin_terminal_payment_edit', array('id' => $terminalPayment->getId()));
        }

        return $this->render('terminalpayment/new.html.twig', array(
                    'terminalPayment' => $terminalPayment,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a terminalPayment entity.
     *
     */
    public function showAction(TerminalPayment $terminalPayment) {
        $deleteForm = $this->createDeleteForm($terminalPayment);

        return $this->render('terminalpayment/show.html.twig', array(
                    'terminalPayment' => $terminalPayment,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing terminalPayment entity.
     *
     */
    public function editAction(Request $request, TerminalPayment $terminalPayment) {
        $deleteForm = $this->createDeleteForm($terminalPayment);
        $editForm = $this->createForm('AppBundle\Form\TerminalPaymentType', $terminalPayment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->get('session')->getFlashBag()->add(
                    'notice', 'Pagamento de Terminal actualizado!'
            );

            return $this->redirectToRoute('admin_terminal_payment_edit', array('id' => $terminalPayment->getId()));
        }

        return $this->render('terminalpayment/edit.html.twig', array(
                    'terminalPayment' => $terminalPayment,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a terminalPayment entity.
     *
     */
    public function deleteAction(Request $request, TerminalPayment $terminalPayment) {
        $form = $this->createDeleteForm($terminalPayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($terminalPayment);
            $em->flush();
        }

        return $this->redirectToRoute('admin_terminal_payment_index');
    }

    /**
     * Creates a form to delete a terminalPayment entity.
     *
     * @param TerminalPayment $terminalPayment The terminalPayment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TerminalPayment $terminalPayment) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_terminal_payment_delete', array('id' => $terminalPayment->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
