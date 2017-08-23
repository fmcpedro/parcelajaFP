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

        $simulation = new TpaymentsSimulator();
        $form = $this->createForm('AppBundle\Form\TpaymentsSimulatorType', $simulation);
        $form->handleRequest($request);
        $tpayments = array();

        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($tpayment);
//            $em->flush();

            if ($form["taxa"]->getData() == 1):
                $tpayments = $this->generatePaymentsTaxaDesconto($form["valorCompra"]->getData(), $form["numeroParcelas"]->getData());
                return $this->render('tpayments/simulatorDesconto.html.twig', array(
                            'simulation' => $simulation,
                            'tpayments' => $tpayments,
                            'form' => $form->createView(),
                ));
            else:
                $tpayments = $this->generatePaymentsTaxaServico($form["valorCompra"]->getData(), $form["numeroParcelas"]->getData());
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

    public function generatePaymentsTaxaServico($valorCompra, $numeroPrestacoes) {

        $logger = $this->get('logger');
        $logger->info("generatePaymentsTaxaServico");

        $prestacoes = array();
        $capitalAmortizadoAnterior = 0;
        $capitalEmDividaAnterior = 0;
        $juroAcumuladoAnterior = 0;
        $impostoSeloAcumuladoAnterior = 0;
        $piiAcumuladoAnterior = 0;
        $valorTransfBniComImpostoSelo = 0;
        $valorTransfBni = 0;
        $impostoSelo = 0;
        
//        $comissaoPagarClienteFinal = 0;
//        $payMethod = new \AppBundle\Entity\Tpaymethod(); 
//        $payMethodFee = new \AppBundle\Entity\Tpaymethodfee();
        
        $em = $this->getDoctrine()->getManager();
        $payMethod = $em->getRepository('AppBundle:Tpaymethod')->findOneBy(array('fpmonths' => $numeroPrestacoes));


        //SELECT * FROM parcelaja_payments.TPayMethodFee where fpaymethodid=19 and FFixedAddCharge = 0 and FFixedAddCharge3 <> 0 and FStartValue < 1200 and FEndValue > 1200
        $query = $em->createQuery('SELECT fee
    FROM AppBundle:Tpaymethodfee fee
    WHERE fee.fpaymethodid = :fpaymethodid
    AND fee.ffixedaddcharge = :ffixedaddcharge
        AND fee.ffixedaddcharge3 <> :ffixedaddcharge3
    AND fee.fstartvalue <= :fstartvalue
    AND fee.fendvalue >= :fendvalue')
                ->setParameter('fpaymethodid', $payMethod->getFpaymethodid())
                ->setParameter('ffixedaddcharge', 0)
                ->setParameter('ffixedaddcharge3', 0)
                ->setParameter('fstartvalue', $valorCompra)
                ->setParameter('fendvalue', $valorCompra);
        $payMethodFee = $query->getSingleResult();

        $comissaoPagarClienteFinal = $payMethodFee->getFfixedaddcharge3();

        for ($i = 0; $i < $numeroPrestacoes; $i++) {

            $prestacao = new TpaymentsTaxaServico($valorCompra, $numeroPrestacoes, $i, $comissaoPagarClienteFinal);

            //ok, validado
            $prestacao->setCapitalAmortizadoAcumulado($prestacao->getCapitalAmortizadoMensalmente() + $capitalAmortizadoAnterior);
            $capitalAmortizadoAnterior = $prestacao->getCapitalAmortizadoAcumulado();

            //ok, validado  
            $prestacao->setJuro($capitalEmDividaAnterior * (TpaymentsTaxaDesconto::TAXA_JURO / $prestacao->getNumeroPrestacoes()));
            $capitalEmDividaAnterior = $prestacao->getCapitalEmDivida();

            //ok, validado
            $prestacao->setJuroAcumulado($prestacao->getJuro() + $juroAcumuladoAnterior);
            $juroAcumuladoAnterior = $prestacao->getJuroAcumulado();

            //ok, validado
            if ($i == 0):
                $prestacao->setProcSepaCt(TpaymentsTaxaServico::PROC_SEPA_CT);
            else:
                $prestacao->setProcSepaCt(0);
            endif;

            //ok, validado
            $prestacao->setImpostoSeloAcumulado($prestacao->getImpostoSelo() + $impostoSeloAcumuladoAnterior);
            $impostoSeloAcumuladoAnterior = $prestacao->getImpostoSeloAcumulado();

            //os calculos seguintes têm de vir depois desta função
            $this->executarCalculosCirculares($prestacao);

            //ok, validado, utilizado mais abaixo
            $valorTransfBniComImpostoSelo += $prestacao->getValorTransfBniComImpostoSelo();
            //ok, validado, utilizado abaixo
            $valorTransfBni += $prestacao->getValorTransfBni();
            //ok, validado, utilizado abaixo
            $impostoSelo += $prestacao->getImpostoSeloValorBni();


            $prestacoes[] = $prestacao;
        }


        //calculo de volores dependentes dos valores dos caculos circulares(pii, imposto selo, e Iva)
        foreach ($prestacoes as $prestacao) {
            //ok, validado
            $prestacao->setValorComissaoSujeitaIva(($prestacao->getValorComissaoPagarCliente() - $valorTransfBniComImpostoSelo) / (1 + TpaymentsTaxaServico::IVA));
            //ok, validado
            $prestacao->setImpSelo($impostoSelo);
            //ok, validado
            $prestacao->setPiiAcumulado($prestacao->getPiiParcial() + $piiAcumuladoAnterior);
            $piiAcumuladoAnterior = $prestacao->getPiiAcumulado();

            //ok, validado
            $prestacao->setServicosFinanceiros($valorTransfBni);
        }


        return $prestacoes;
    }

    public function generatePaymentsTaxaDesconto($valorCompra, $numeroPrestacoes) {

        $prestacoes = array();
        $capitalAmortizadoAnterior = 0;
        $capitalEmDividaAnterior = 0;
        $juroAcumuladoAnterior = 0;
        $impostoSeloAcumuladoAnterior = 0;
        $piiAcumuladoAnterior = 0;
        $valorTransfBniComImpostoSelo = 0;
        $valorTransfBni = 0;
        $impostoSelo = 0;


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

            $valorTransfBniComImpostoSelo += $prestacao->getValorTransfBniComImpostoSelo();
            $valorTransfBni += $prestacao->getValorTransfBni();


            $impostoSelo += $prestacao->getImpostoSeloValorBni();
            //echo "ImpostoSeloValorBni = " . $prestacao->getImpostoSeloValorBni();


            $prestacoes[] = $prestacao;
        }



        foreach ($prestacoes as $prestacao) {
            $prestacao->setValorComissaoSujeitaIva($prestacao->getValorComissaoPagarAderente() - $valorTransfBniComImpostoSelo);
            $prestacao->setServicosFinanceiros($valorTransfBni);
            $prestacao->setImpSelo($impostoSelo);
            //echo $prestacao->getValorComissaoSujeitaIva();
        }

        return $prestacoes;
    }

    public function executarCalculosCirculares(TpaymentsTaxaServico $prestacao) {

        // na primeira chamada o IMPOSTO DE SELO vai com zero
        $iva = new CalculateIva($prestacao->getJuro(), 0, $prestacao->getComissaoPagarClienteFinal(), $prestacao->getNumeroPrestacoes());
        // na primeira chamada o IVA vai com zero
        $impostoSelo = new CalculateImpostoSeloBNIE($prestacao->getJuro(), 0, $prestacao->getComissaoPagarClienteFinal(), $prestacao->getNumeroPrestacoes());

        $resultadoIva = 0;
        $resultadoImpostoSelo = 0;
        $resultadoIvaAnterior = -1;
        $resultadoImpostoSeloAnterior = -1;

        // para depois de fazer um maximo de 10000 iterações, ou quando a diferença entre o resultado anterior for demasiado pequena.
        // em cada iteração ou valor do IVA entra na no calculo do Imposto de Selo e o valor do Imposto de selo entra no calculo do IVA.
        $iteracoes = 0;
        $maximoIteracoes = 10000;

        for ($iteracoes = 0; $iteracoes <= $maximoIteracoes; $iteracoes++) {

            $resultadoIva = $iva->calculate($prestacao->getComOgone(), $prestacao->getComEvoPayments(), $prestacao->getProcSepaCt());
            $resultadoImpostoSelo = $impostoSelo->calculate($prestacao->getComOgone(), $prestacao->getComEvoPayments(), $prestacao->getProcSepaCt());

//            echo "<br/> Prestacao                       = " . $prestacao->getNumParcela();
//            echo "<br/> Iteracao                        = " . $iteracoes;
//            echo "<br/> Resultado Iva                   = " . $resultadoIva;
//            echo "<br/> Resultado Imposto Selo          = " . $resultadoImpostoSelo;
//            echo "<br/>";

            $iva = new CalculateIva($prestacao->getJuro(), $resultadoImpostoSelo, $prestacao->getComissaoPagarClienteFinal(), $prestacao->getNumeroPrestacoes());
            $impostoSelo = new CalculateImpostoSeloBNIE($prestacao->getJuro(), $resultadoIva, $prestacao->getComissaoPagarClienteFinal(), $prestacao->getNumeroPrestacoes());

            if ($resultadoIva - $resultadoIvaAnterior <= TpaymentsTaxaServico::DIFERENCA_ENTRE_ITERACOES && $resultadoImpostoSelo - $resultadoImpostoSeloAnterior <= TpaymentsTaxaServico::DIFERENCA_ENTRE_ITERACOES) {
                break;
            }

            $resultadoIvaAnterior = $resultadoIva;
            $resultadoImpostoSeloAnterior = $resultadoImpostoSelo;
        }

        //escrever resultados
        $prestacao->setIvaValorParcela($resultadoIva);
        $prestacao->setImpostoSeloValorBni($resultadoImpostoSelo);


//
//        echo "<br/> FINAL : Valor Comissão Pagar Cliente = " . $prestacao->getComissaoPagarClienteFinal();
//        echo "<br/> FINAL : Iva Valor Parcela = " . $prestacao->getIvaValorParcela();
//        echo "<br/> FINAL : Imposto Selo BNIE = " . $prestacao->getImpostoSeloValorBni();
//        echo "<br/> FINAL : Pii parcial       = " . $prestacao->getPiiParcial();
//        echo "<br/>";
//        echo "<br/>";
    }

    /**
     * Lists all tpayment entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        // tabela payments
        //FInstalment = numero da parcela paga
        //FAmounth = montante capturado efectivamente
        //FPurchaseID = id da compra
        //table purchase
        //FmountData = numero de meses/parcelas
        //FCalcAmounth = valor sem taxas
        //FTotPurchaseValue = valor total da compra com taxas

        $payment = new Tpayments();
        $purchase = new Tpurchase();
        $generatedPayments = array();

        $payments = $em->getRepository('AppBundle:Tpayments')->findAll();

        foreach ($payments as $payment) {
            //buscar a compra
            $purchase = $em->getRepository('AppBundle:Tpurchase')->find($payment->getFpurchaseid());

            // FFee = Quando é feita uma transação através de uma taxa de desconto, esta percentagem é cobrada a Loja.
            // FExtraCharge = Quando é feita uma transação através de taxa de serviço, este é o valor cobrado da taxa de serviço.

            // Se tiver FExtraCharge diferente de 0, então é Taxa de Serviço
//            if($purchase->getFextracharge() <> 0):
//                //gerar todos os pagamentos da compra
//                $generatedPayments = $this->generatePaymentsTaxaServico($purchase->getFtotpurchasevalue(), $purchase->getFmonthdata());
//                else:
//                //gerar todos os pagamentos da compra
//                $generatedPayments = $this->generatePaymentsTaxaDesconto($purchase->getFtotpurchasevalue(), $purchase->getFmonthdata());
//            endif;
//            
//            
            $generatedPayments = $this->generatePaymentsTaxaDesconto($purchase->getFtotpurchasevalue(), $purchase->getFmonthdata());
            
            //adicionar a parcela relativa ao pagamento
            $tpayments[] = $generatedPayments[$payment->getFinstallment() - 1];
        }



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
