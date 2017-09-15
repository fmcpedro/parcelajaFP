<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tpayments;
use AppBundle\Entity\TpaymentsSimulator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Tpayment controller.
 *
 */
class TpaymentsController extends Controller {

    public function blankAction(Request $request) {

        //$em = $this->getContainer()->get('doctrine.orm.entity_manager');
//        $em = $this->getDoctrine()->getManager();
//        
//        $payments = $em->getRepository('AppBundle:Tpayments')->findLastDaysPayments(6);
//        
//        foreach ($payments as $key => $payment) {
//            
//            $data = $this->getIngenicoObject($payment->getFpayid());
//            
//            
//            $entity = new \AppBundle\Entity\IngenicoPayment();
//            $entity->setOrderId($this->xml_attribute($data, 'orderID'));
//            $entity->setPayId(intval($this->xml_attribute($data, 'PAYID')));
//            $entity->setPayIdSub($this->xml_attribute($data, 'PAYIDSUB'));
//            $entity->setNcStatus($this->xml_attribute($data, 'NCSTATUS'));
//            $entity->setNcError($this->xml_attribute($data, 'NCERROR'));
//            $entity->setNcErrorPlus($this->xml_attribute($data, 'NCERRORPLUS'));
//            $entity->setAcceptance($this->xml_attribute($data, 'ACCEPTANCE'));
//            $entity->setStatus($this->xml_attribute($data, 'STATUS'));
//            $entity->setIpcty($this->xml_attribute($data, 'IPCTY'));
//            $entity->setCccty($this->xml_attribute($data, 'CCCTY'));
//            $entity->setEci($this->xml_attribute($data, 'ECI'));
//            $entity->setCvcCheck($this->xml_attribute($data, 'CVCCheck'));
//            $entity->setAavCheck($this->xml_attribute($data, 'AAVCheck'));
//            $entity->setVc($this->xml_attribute($data, 'VC'));
//            $entity->setAmount($this->xml_attribute($data, 'amount'));
//            $entity->setCurrency($this->xml_attribute($data, 'currency'));
//            $entity->setPm($this->xml_attribute($data, 'PM'));
//            $entity->setBrand($this->xml_attribute($data, 'BRAND'));
//            $entity->setCardNo($this->xml_attribute($data, 'CARDNO'));
//            $entity->setScoring($this->xml_attribute($data, 'SCORING'));
//            $entity->setScoCategory($this->xml_attribute($data, 'SCO_CATEGORY'));
//
//            $entity = $em->merge($entity); //it's important to use result of function, not the same element
//            $em->flush();
//            
//        }

 
        
        
        
        
        
        return $this->render('tpayments/blank.html.twig');
    }
//

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

            
            
                $purchase = new \AppBundle\Entity\Tpurchase();
            $purchase->setFcalcamount($form["valorCompra"]->getData());
            $purchase->setFmonthdata($form["numeroParcelas"]->getData());
            
            if ($form["taxa"]->getData() == 1):
                
                
                $tpayments = $em->getRepository('AppBundle:Tpayments')->generatePaymentsTaxaDesconto($purchase);
                return $this->render('tpayments/simulatorDesconto.html.twig', array(
                            'simulation' => $simulation,
                            'tpayments' => $tpayments,
                            'form' => $form->createView(),
                ));
            else:
                $tpayments = $em->getRepository('AppBundle:Tpayments')->generatePaymentsTaxaServico($purchase);
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
