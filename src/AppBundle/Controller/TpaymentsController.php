<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tpayments;
use AppBundle\Entity\TpaymentsSimulator;
use AppBundle\Entity\TpaymentsTaxaDesconto;
use AppBundle\Entity\TpaymentsTaxaServico;
use AppBundle\Utils\CalculateImpostoSeloBNIE;
use AppBundle\Utils\CalculateIva;
use Proxies\__CG__\AppBundle\Entity\Tpurchase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tpayment controller.
 *
 */
class TpaymentsController extends Controller {

    public function simulatorAction(Request $request) {

        $logger = $this->get('logger');
        $logger->info("simulatorAction");
        $em = $this->getDoctrine()->getManager();

        $simulation = new TpaymentsSimulator();
        $form = $this->createForm('AppBundle\Form\TpaymentsSimulatorType', $simulation);
        $form->handleRequest($request);
        $tpayments = array();

        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($tpayment);
//            $em->flush();

            if ($form["taxa"]->getData() == 1):
                $tpayments = $em->getRepository('AppBundle:Tpayments')->generatePaymentsTaxaDesconto($form["valorCompra"]->getData(), $form["numeroParcelas"]->getData());
                return $this->render('tpayments/simulatorDesconto.html.twig', array(
                            'simulation' => $simulation,
                            'tpayments' => $tpayments,
                            'form' => $form->createView(),
                ));
            else:
                $tpayments = $em->getRepository('AppBundle:Tpayments')->generatePaymentsTaxaServico($form["valorCompra"]->getData(), $form["numeroParcelas"]->getData());
                return $this->render('tpayments/simulatorServico.html.twig', array(
                            'simulation' => $simulation,
                            'tpayments' => $tpayments,
                            'form' => $form->createView(),
                ));
            endif;
        }

        return $this->render('tpayments/simulatorDesconto.html.twig', array(
                    'simulation' => $simulation,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Lists all tpayment entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

       $tpayments = $em->getRepository('AppBundle:Tpayments')->findAllProcessedPayments();

        return $this->render('tpayments/index.html.twig', array(
                    'tpayments' => $tpayments,
        ));
    }

    /**
     * Creates a new tpayment entity.
     *
     */
    public function newAction(Request $request) {
        $tpayment = new Tpayment();
        $form = $this->createForm('AppBundle\Form\TpaymentsType', $tpayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tpayment);
            $em->flush();

            return $this->redirectToRoute('admin_payments_show', array('fpurchaseid' => $tpayment->getFpurchaseid()));
        }

        return $this->render('tpayments/new.html.twig', array(
                    'tpayment' => $tpayment,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tpayment entity.
     *
     */
    public function showAction(Tpayments $tpayment) {
        $deleteForm = $this->createDeleteForm($tpayment);

        return $this->render('tpayments/show.html.twig', array(
                    'tpayment' => $tpayment,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tpayment entity.
     *
     */
    public function editAction(Request $request, Tpayments $tpayment) {
        $deleteForm = $this->createDeleteForm($tpayment);
        $editForm = $this->createForm('AppBundle\Form\TpaymentsType', $tpayment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_payments_edit', array('fpurchaseid' => $tpayment->getFpurchaseid()));
        }

        return $this->render('tpayments/edit.html.twig', array(
                    'tpayment' => $tpayment,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tpayment entity.
     *
     */
    public function deleteAction(Request $request, Tpayments $tpayment) {
        $form = $this->createDeleteForm($tpayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tpayment);
            $em->flush();
        }

        return $this->redirectToRoute('admin_payments_index');
    }

    /**
     * Creates a form to delete a tpayment entity.
     *
     * @param Tpayments $tpayment The tpayment entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Tpayments $tpayment) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_payments_delete', array('fpurchaseid' => $tpayment->getFpurchaseid())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
