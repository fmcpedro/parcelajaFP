<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tpayments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\TpaymentsTaxaDesconto;

/**
 * Tpayment controller.
 *
 */
class TpaymentsController extends Controller {

    public function simulatorAction(Request $request) {



        $simulation = new \AppBundle\Entity\TpaymentsSimulator();
        $form = $this->createForm('AppBundle\Form\TpaymentsSimulatorType', $simulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($tpayment);
//            $em->flush();
            
            if($form["taxa"]->getData() == 1 ):
                $tpayments = $this->generatePaymentsTaxaDesconto($form["valorCompra"]->getData(), $form["numeroParcelas"]->getData());
            
            else:
                
                $tpayments = $this->generatePaymentsTaxaServico($form["valorCompra"]->getData(), $form["numeroParcelas"]->getData());
            
            endif;
            
            
            

            return $this->render('tpayments/simulator.html.twig', array(
                        'simulation' => $simulation,
                        'tpayments' => $tpayments,
                        'form' => $form->createView(),
            ));
        }

        return $this->render('tpayments/simulator.html.twig', array(
                    'simulation' => $simulation,
                    'form' => $form->createView(),
        ));
    }

    
    public function generatePaymentsTaxaServico($valorCompra, $numeroPrestacoes) {
        return null;
    }
    
    
    public function generatePaymentsTaxaDesconto($valorCompra, $numeroPrestacoes) {

        $prestacoes = array();
        $capitalAmortizadoAnterior = 0;
        $capitalEmDividaAnterior = 0;
        $juroAcumuladoAnterior = 0;
        $impostoSeloAcumuladoAnterior = 0;
        $piiAcumuladoAnterior = 0;
        $valorTransfBniComIva = 0;


        for ($i = 0; $i < $numeroPrestacoes; $i++) {

            $prestacao = new TpaymentsTaxaDesconto($valorCompra, $numeroPrestacoes, $i);

            $prestacao->setCapitalAmortizadoAcumulado($prestacao->getCapitalAmortizadoMensalmente() + $capitalAmortizadoAnterior);
            $capitalAmortizadoAnterior = $prestacao->getCapitalAmortizadoAcumulado();

            $prestacao->setJuro($capitalEmDividaAnterior * (TpaymentsTaxaDesconto::TAXA_JURO / $prestacao->getNumeroPrestacoes()));
            $capitalEmDividaAnterior = $prestacao->getCapitalEmDivida();

            $prestacao->setJuroAcumulado($prestacao->getJuro() + $juroAcumuladoAnterior);
            $juroAcumuladoAnterior = $prestacao->getJuroAcumulado();

            if ($i == 0):
                $prestacao->setProcSepaCt(TpaymentsTaxaDesconto::PROC_SEPA_CT);
            else:
                $prestacao->setProcSepaCt(0);
            endif;

            $prestacao->setImpostoSeloAcumulado($prestacao->getImpostoSelo() + $impostoSeloAcumuladoAnterior);
            $impostoSeloAcumuladoAnterior = $prestacao->getImpostoSeloAcumulado();

            $prestacao->setPiiAcumulado($prestacao->getPiiParcial() + $piiAcumuladoAnterior);
            $piiAcumuladoAnterior = $prestacao->getPiiAcumulado();

            $valorTransfBniComIva += $prestacao->getValorTransfBniComImpostoSelo();

            $prestacoes[] = $prestacao;
        }



        foreach ($prestacoes as $prestacao) {
            $prestacao->setValorComissaoSujeitaIva($valorTransfBniComIva);
            //echo $prestacao->getValorComissaoSujeitaIva();
        }






        return $prestacoes;
    }

    /**
     * Lists all tpayment entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $tpayments = $em->getRepository('AppBundle:Tpayments')->findAll();

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
