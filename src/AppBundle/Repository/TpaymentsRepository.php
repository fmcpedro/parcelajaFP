<?php

namespace AppBundle\Repository;

use AppBundle\Entity\TpaymentsTaxaDesconto;
use AppBundle\Entity\TpaymentsTaxaServico;
use AppBundle\Utils\CalculateImpostoSeloBNIE;
use AppBundle\Utils\CalculateIva;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Proxies\__CG__\AppBundle\Entity\Tpayments;
use Proxies\__CG__\AppBundle\Entity\Tpurchase;

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

    //put your code here
    //devolve os pagamentos dos ultimos x dias (utilizado para exportar ficheiro)
    public function findLastDaysPayments($days = 30) {

        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT payments '
                . 'FROM AppBundle:Tpayments payments '
                . 'where payments.fdate > :date');

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
    public function findAllProcessedPayments() {
        $em = $this->getEntityManager();
        $tpayments = array();

        //$payments = $em->getRepository('AppBundle:Tpayments')->findAll();
        $payment = new Tpayments();
        $purchase = new Tpurchase();

        $payments = $em->getRepository('AppBundle:Tpayments')->findLastDaysPayments(30);

        foreach ($payments as $payment) {
            //buscar a compra
            $purchase = $em->getRepository('AppBundle:Tpurchase')->find($payment->getFpurchaseid());


            //apenas são criados os pagamentos de compras após 10-03-2017
            $purchase_date = strtotime($purchase->getFpurchasedate()->format('d-m-Y'));
            $start_date = strtotime('10-03-2017');


            //se a data da compra for maior que a data de inicio da parceria
            if ($purchase_date >= $start_date):
                if ($purchase->getFmonthdata() == 1):
                    //se for uma pagamento numa unica vez = SC(sem credito)
                    $tipoTransacao = "SC";
                else:
                    //dentro da parceria AC=(a credito)
                    $tipoTransacao = "AC";
                endif;
            else:
                //antes da parceria com o banco = PP(pre-parceria)
                $tipoTransacao = "PP";
            endif;



            if ($purchase_date > $start_date) {
                // FFee = Quando é feita uma transação através de uma taxa de desconto, esta percentagem é cobrada a Loja.
                // FExtraCharge = Quando é feita uma transação através de taxa de serviço, este é o valor cobrado da taxa de serviço.
                // Se tiver FExtraCharge diferente de 0, então é Taxa de Serviço
                if ($purchase->getFextracharge() <> 0):
                    //echo "TaxaServico <br/>";
                    //gerar todos os pagamentos da compra
                    $generatedPayments = $this->generatePaymentsTaxaServico($purchase->getFcalcamount(), $purchase->getFmonthdata(), $tipoTransacao);
                else:
                    //echo "TaxaDesconto <br/>";
                    //gerar todos os pagamentos da compra
                    $generatedPayments = $this->generatePaymentsTaxaDesconto($purchase->getFcalcamount(), $purchase->getFmonthdata(), $tipoTransacao);
                endif;


//                foreach ($generatedPayments as $key => $value) {
//                    echo "NUMERO PARCELA = " . $value->getNumParcela();
//                }


                echo "valor do installment = " . $payment->getFinstallment();


                //adicionar a parcela relativa ao pagamento
                $tpayments[] = $generatedPayments[$payment->getFinstallment() - 1];
            }
        }



//        $value = new TpaymentsTaxaDesconto();
//        foreach ($tpayments as $key => $value) {
//            echo "NUMERO PARCELA = " . $value->getNumParcela();
//            
//        }



        return $tpayments;
    }

    /**
     * Função que gera um array com a lista de pagamentos de uma compra (TpaymentsTaxaDesconto)
     * 
     * @param type $valorCompra
     * @param type $numeroPrestacoes
     * @return array
     */
    public function generatePaymentsTaxaDesconto($valorCompra, $numeroPrestacoes, $tipoTransacao = "SC") {

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

            $prestacao = new TpaymentsTaxaDesconto($valorCompra, $numeroPrestacoes, $i, $tipoTransacao);

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

    /**
     * Função que gera um array com a lista de pagamentos de uma compra (TpaymentsTaxaServico)
     * 
     * @param type $valorCompra
     * @param type $numeroPrestacoes
     * @return array
     */
    public function generatePaymentsTaxaServico($valorCompra, $numeroPrestacoes, $tipoTransacao = "SC") {

//        $logger = $this->get('logger');
//        $logger->info("generatePaymentsTaxaServico");

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

        //echo "paymethodid : " . $payMethod->getFpaymethodid();


        /*         * **************************
         * NOTA - Verificar se isto pode ser feito assim, 
         * ou tenho de ir buscar o valor que está na base de dados, no caso das transacoes efectivas
         * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
         * 
         */




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

            $prestacao = new TpaymentsTaxaServico($valorCompra, $numeroPrestacoes, $i, $comissaoPagarClienteFinal, $tipoTransacao);

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

}
