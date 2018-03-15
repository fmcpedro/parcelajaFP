<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Tpayments;
use AppBundle\Entity\TpaymentsTaxaDesconto;
use AppBundle\Entity\TpaymentsTaxaServico;
use AppBundle\Entity\Tpurchase;
use AppBundle\Utils\CalculateImpostoSeloBNIE;
use AppBundle\Utils\CalculateIva;
use DateTime;
use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GroupRepository
 *
 * @author Luis Miguens
 */
class TpaymentsRepository extends EntityRepository {

    public function findLastPayment(Tpurchase $tpurchase) {


        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT payments '
                . 'FROM AppBundle:Tpayments payments '
                . 'where payments.fpurchaseid = :purchase_id '
                . 'order by payments.finstallment DESC');

        $query->setParameter('purchase_id', $tpurchase->getFpurchaseid());
        $payments = $query->getResult();

        //return only last payment

        if (!empty($payments)):
            return $payments[0];
        else:
            return null;
        endif;
    }

    //put your code here
    //devolve os pagamentos dos ultimos x dias (utilizado para exportar ficheiro)
    public function findLastDaysPayments($days = 30) {

        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT payments '
                . 'FROM AppBundle:Tpayments payments '
                . 'where payments.fdate > :date');


        //dump(new DateTime('-' . $days . ' day'));

        $query->setParameter('date', new DateTime('-' . $days . ' day'));
        $payments = $query->getResult();

        return $payments;
    }

    /**
     * devolve todos os pagamentos (utilizado nos mapas)
     * 
     * Tabela payments
     * FInstalment = numero da parcela paga
     * FAmounth = montante capturado efectivamente
     * FPurchaseID = id da compra
     *    
     * Table purchase
     * FmountData = numero de meses/parcelas
     * FCalcAmounth = valor sem taxas
     * FTotPurchaseValue = valor total da compra com taxas
     *  
     */
    public function findAllProcessedPayments($numDays = 220) {
        $em = $this->getEntityManager();
        $tpayments = array();

        //$payments = $em->getRepository('AppBundle:Tpayments')->findAll();
        $payment = new Tpayments();
        $purchase = new Tpurchase();

        $payments = $em->getRepository('AppBundle:Tpayments')->findLastDaysPayments($numDays);

        foreach ($payments as $key => $payment) {
            //buscar a compra
            $purchase = $em->getRepository('AppBundle:Tpurchase')->find($payment->getFpurchaseid());

            //$purchase = new Tpurchase();
//            if($purchase->getFpurchaseid() == 149):
//                dump($purchase);
//            endif;


            $purchase_date = strtotime($purchase->getFpurchasedate()->format('d-m-Y'));
            $start_date = strtotime('10-03-2017');

            if ($purchase_date > $start_date) {

                // FFee = Quando é feita uma transação através de uma taxa de desconto, esta percentagem é cobrada a Loja.
                // FExtraCharge = Quando é feita uma transação através de taxa de serviço, este é o valor cobrado da taxa de serviço.
                // Se tiver FExtraCharge diferente de 0, então é Taxa de Serviço
                if ($purchase->getFextracharge() <> 0):
                    //echo "TaxaServico <br/>";
                    //gerar todos os pagamentos da compra
                    //$generatedPayments = $this->generatePaymentsTaxaServico($purchase->getFcalcamount(), $purchase->getFmonthdata(), $tipoTransacao, $payment->getFpayid(), $payment->getFDate());
                    $generatedPayments = $this->generatePaymentsTaxaServico($purchase, $payment);
                else:
                    //echo "TaxaDesconto <br/>";
                    //gerar todos os pagamentos da compra
                    //$generatedPayments = $this->generatePaymentsTaxaDesconto($purchase->getFcalcamount(), $purchase->getFmonthdata(), $tipoTransacao, $payment->getFpayid(), $payment->getFDate());
                    $generatedPayments = $this->generatePaymentsTaxaDesconto($purchase, $payment);
                endif;

                //adicionar a parcela relativa ao pagamento
                $tpayments[] = $generatedPayments[$payment->getFinstallment() - 1];
            }
        }

        return $tpayments;
    }

    /**
     * devolve todos os pagamentos cancelados
     * 
     */
    public function findAllCanceledPayments($numDays = 220) {
        $em = $this->getEntityManager();
        $tpayments = array();
        $cancelation = new \AppBundle\Entity\PurchaseCancelation();

        $cancelations = $em->getRepository('AppBundle:PurchaseCancelation')->findAll();
    
        foreach ($cancelations as $key => $cancelation) {
            
            $purchase = $em->getRepository('AppBundle:Tpurchase')->find($cancelation->getPurchaseId());
            
            $payment = $em->getRepository('AppBundle:Tpayments')->findOneBy([
                'fpurchaseid' => $cancelation->getPurchaseId(),
                'finstallment' => $cancelation->getInstallmentId() - 1]);

            // FFee = Quando é feita uma transação através de uma taxa de desconto, esta percentagem é cobrada a Loja.
            // FExtraCharge = Quando é feita uma transação através de taxa de serviço, este é o valor cobrado da taxa de serviço.
            // Se tiver FExtraCharge diferente de 0, então é Taxa de Serviço
            if ($purchase->getFextracharge() <> 0):
                //echo "TaxaServico <br/>";
                $generatedPayments = $this->generatePaymentsTaxaServico($purchase, $payment, 'CANCELLATION');
            else:
                //echo "TaxaDesconto <br/>";
                $generatedPayments = $this->generatePaymentsTaxaDesconto($purchase, $payment, 'CANCELLATION');
            endif;

            //adicionar a parcela relativa ao pagamento
            $tpayments[] = $generatedPayments[$cancelation->getInstallmentId()];
        }

        return $tpayments;
    }

    
    
     /**
     * devolve todos os pagamentos devolvidos
     * 
     */
    public function findAllReturnedPayments($numDays = 220) {
        $em = $this->getEntityManager();
        $tpayments = array();
        $return = new \AppBundle\Entity\PurchaseReturn();

        $returns = $em->getRepository('AppBundle:PurchaseReturn')->findAll();
    
        foreach ($returns as $key => $return) {
            
            $purchase = $em->getRepository('AppBundle:Tpurchase')->find($return->getPurchaseId());
            
            $payment = $em->getRepository('AppBundle:Tpayments')->findOneBy([
                'fpurchaseid' => $return->getPurchaseId(),
                'finstallment' => $return->getInstallmentId() - 1]);

            // FFee = Quando é feita uma transação através de uma taxa de desconto, esta percentagem é cobrada a Loja.
            // FExtraCharge = Quando é feita uma transação através de taxa de serviço, este é o valor cobrado da taxa de serviço.
            // Se tiver FExtraCharge diferente de 0, então é Taxa de Serviço
            if ($purchase->getFextracharge() <> 0):
                //echo "TaxaServico <br/>";
                $generatedPayments = $this->generatePaymentsTaxaServico($purchase, $payment, 'DEVOLUTION');
            else:
                //echo "TaxaDesconto <br/>";
                $generatedPayments = $this->generatePaymentsTaxaDesconto($purchase, $payment, 'DEVOLUTION');
            endif;

            //adicionar a parcela relativa ao pagamento
            $tpayments[] = $generatedPayments[$return->getInstallmentId()];
        }

        return $tpayments;
    }
    
    
    
    
    
    
    
    
    /**
     * Função que gera um array com a lista de pagamentos de uma compra (TpaymentsTaxaDesconto)
     * 
     * @param type $valorCompra
     * @param type $numeroPrestacoes
     * @return array
     */
    //public function generatePaymentsTaxaDesconto($valorCompra, $numeroPrestacoes, $tipoTransacao = "SC", $payID=0, $dataPayment=0) {
    public function generatePaymentsTaxaDesconto(Tpurchase $purchase, Tpayments $payment = null) {


        $numeroPrestacoes = $purchase->getFmonthdata();

        $prestacoes = array();
        $capitalAmortizadoAnterior = 0;
        $capitalEmDividaAnterior = 0;
        $juroAcumuladoAnterior = 0;
        $impostoSeloAcumuladoAnterior = 0;
        $piiAcumuladoAnterior = 0;
        $valorTransfBniComImpostoSelo = 0;
        $valorTransfBni = 0;
        $impostoSelo = 0;


        $dataPagamentoAnterior = $purchase->getFpurchasedate()->getTimestamp();


        for ($i = 0; $i < $numeroPrestacoes; $i++) {

            $prestacao = new TpaymentsTaxaDesconto($purchase, $i, $payment);

            $prestacao->setCapitalAmortizadoAcumulado($prestacao->getCapitalAmortizadoMensalmente() + $capitalAmortizadoAnterior);
            $capitalAmortizadoAnterior = $prestacao->getCapitalAmortizadoAcumulado();

            //$prestacao->setJuro($capitalEmDividaAnterior * (TpaymentsTaxaDesconto::TAXA_JURO / $prestacao->getNumeroPrestacoes()));
            $prestacao->setJuro($capitalEmDividaAnterior * (TpaymentsTaxaDesconto::TAXA_JURO / 12));
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


            $prestacao->setDataPagamento($dataPagamentoAnterior);
            $dataPagamentoAnterior = strtotime("+1 month", $dataPagamentoAnterior);

            $prestacoes[] = $prestacao;
        }



        foreach ($prestacoes as $prestacao) {
            $prestacao->setValorComissaoSujeitaIva($prestacao->getValorComissaoPagarAderente() - $valorTransfBniComImpostoSelo);
            $prestacao->setServicosFinanceiros($valorTransfBni);
            $prestacao->setImpSelo($impostoSelo);
        }

        return $prestacoes;
    }

    /**
     * Função que gera um array com a lista de pagamentos de uma compra (TpaymentsTaxaServico)
     * 
     * @param type $valorCompra
     * @param type $numeroPrestacoes
     * @return array
     */
    //public function generatePaymentsTaxaServico($valorCompra, $numeroPrestacoes, $tipoTransacao = "SC", $payID=0, $dataPayment=0) {


    public function generatePaymentsTaxaServico(Tpurchase $purchase, Tpayments $payment = null) {

        $valorCompra = $purchase->getFcalcamount();
        $numeroPrestacoes = $purchase->getFmonthdata();


        $prestacoes = array();
        $capitalAmortizadoAnterior = 0;
        $capitalEmDividaAnterior = 0;
        $juroAcumuladoAnterior = 0;
        $impostoSeloAcumuladoAnterior = 0;
        $piiAcumuladoAnterior = 0;
        $valorTransfBniComImpostoSelo = 0;
        $valorTransfBni = 0;
        $impostoSelo = 0;

        $em = $this->getEntityManager();
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

        //dump($valorCompra);

        $payMethodFee = $query->getSingleResult();

        $comissaoPagarClienteFinal = $payMethodFee->getFfixedaddcharge3();

        $dataPagamentoAnterior = $purchase->getFpurchasedate()->getTimestamp();

        for ($i = 0; $i < $numeroPrestacoes; $i++) {

            $prestacao = new TpaymentsTaxaServico($purchase, $i, $comissaoPagarClienteFinal, $payment);
            //$prestacao = new TpaymentsTaxaServico($valorCompra, $numeroPrestacoes, $i, $comissaoPagarClienteFinal, $tipoTransacao, $payID, $dataPayment);
            //ok, validado
            $prestacao->setCapitalAmortizadoAcumulado($prestacao->getCapitalAmortizadoMensalmente() + $capitalAmortizadoAnterior);
            $capitalAmortizadoAnterior = $prestacao->getCapitalAmortizadoAcumulado();

            //ok, validado  
            //$prestacao->setJuro($capitalEmDividaAnterior * (TpaymentsTaxaDesconto::TAXA_JURO / $prestacao->getNumeroPrestacoes()));
            $prestacao->setJuro($capitalEmDividaAnterior * (TpaymentsTaxaDesconto::TAXA_JURO / 12));
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


            $prestacao->setDataPagamento($dataPagamentoAnterior);
            $dataPagamentoAnterior = strtotime("+1 month", $dataPagamentoAnterior);

            //dump($dataPagamentoAnterior);
            //echo "numero parcela = " . $prestacao->getNumParcela();

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

    public function executarCalculosCirculares(TpaymentsTaxaServico $prestacao) {

        // na primeira chamada o IMPOSTO DE SELO vai com zero
        $iva = new CalculateIva($prestacao->getJuro(), 0, $prestacao->getNumParcela(), $prestacao->getValParcelasEmissor(), $prestacao->getComissaoPagarClienteFinal(), $prestacao->getNumeroPrestacoes());
        // na primeira chamada o IVA vai com zero
        $impostoSelo = new CalculateImpostoSeloBNIE($prestacao->getJuro(), 0, $prestacao->getNumParcela(), $prestacao->getValParcelasEmissor(), $prestacao->getComissaoPagarClienteFinal(), $prestacao->getNumeroPrestacoes());

        $resultadoIva = 0;
        $resultadoImpostoSelo = 0;
        $resultadoIvaAnterior = -1;
        $resultadoImpostoSeloAnterior = -1;

        // para depois de fazer um maximo de 10000 iterações, ou quando a diferença entre o resultado anterior for demasiado pequena.
        // em cada iteração ou valor do IVA entra na no calculo do Imposto de Selo e o valor do Imposto de selo entra no calculo do IVA.
        $iteracoes = 0;
        $maximoIteracoes = 1000;

        for ($iteracoes = 0; $iteracoes < $maximoIteracoes; $iteracoes++) {

            $resultadoIva = $iva->calculate();
            $resultadoImpostoSelo = $impostoSelo->calculate();

//            dump("Prestacao = " . $prestacao->getNumParcela()
//                    . " Iteracao = " . $iteracoes
//                    . " Resultado Iva = " . $resultadoIva
//                    . " Resultado Imposto Selo = " . $resultadoImpostoSelo);


            $iva = new CalculateIva($prestacao->getJuro(), $resultadoImpostoSelo, $prestacao->getNumParcela(), $prestacao->getValParcelasEmissor(), $prestacao->getComissaoPagarClienteFinal(), $prestacao->getNumeroPrestacoes());
            $impostoSelo = new CalculateImpostoSeloBNIE($prestacao->getJuro(), $resultadoIva, $prestacao->getNumParcela(), $prestacao->getValParcelasEmissor(), $prestacao->getComissaoPagarClienteFinal(), $prestacao->getNumeroPrestacoes());


//            dump("resultado IVA = " . $resultadoIva);
//            dump("resultado IVA ANTERIOR= " . $resultadoIvaAnterior);
//            dump(abs($resultadoIva - $resultadoIvaAnterior) <= TpaymentsTaxaServico::DIFERENCA_ENTRE_ITERACOES);
//            
//            dump("resultado IS = " . $resultadoImpostoSelo);
//            dump("resultado IS ANTERIOR = " . $resultadoImpostoSeloAnterior);

            if (abs($resultadoIva - $resultadoIvaAnterior) <= TpaymentsTaxaServico::DIFERENCA_ENTRE_ITERACOES && abs($resultadoImpostoSelo - $resultadoImpostoSeloAnterior) <= TpaymentsTaxaServico::DIFERENCA_ENTRE_ITERACOES) {
                break;
            }

            $resultadoIvaAnterior = $resultadoIva;
            $resultadoImpostoSeloAnterior = $resultadoImpostoSelo;
        }


//                    dump("Prestacao = " . $prestacao->getNumParcela()
//                    . " Iteracao = " . $iteracoes
//                    . " Resultado Iva = " . $resultadoIva
//                    . " Resultado Imposto Selo = " . $resultadoImpostoSelo);
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

}
