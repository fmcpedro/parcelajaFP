<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExportCommand
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */

namespace AppBundle\Command;

use AppBundle\Entity\TpaymentsTaxaDesconto;
use AppBundle\Entity\TpaymentsTaxaServico;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportPaymentsCommand extends ContainerAwareCommand {
    
    const NUM_CASAS_DECIMAIS = 8;

    protected function configure() {
        $this
                // the name of the command (the part after "bin/console")
                ->setName('app:export-payments')

                // the short description shown while running "php bin/console list"
                ->setDescription('Export payments from last 5 days to a .csv file.')

                // the full command description shown when running the command with
                // the "--help" option
                ->setHelp('This command allows you to export payments from last 5 days to a .csv file...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);


        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $tpayments = $em->getRepository('AppBundle:Tpayments')->findAllProcessedPayments(5);

        $this->generateCsvFile($tpayments);


        // outputs a message followed by a "\n"
        $output->writeln('tpayments : ' . count($tpayments));

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }

    public function generateCsvFile($tpayments) {

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $path = $this->getContainer()->getParameter('EXPORT_PATH');
        $filename = date('YmdHis') . 'FicheiroAgregador.csv';
        $handle = fopen($path . $filename, 'w+');

        // Add the header of the CSV file
        fputcsv($handle, array(
            'CUSTO_CAPTURA',
            'EVO_PAYMENTS',
            'OGONE',
            'PROC_SEPA_CT',
            'CAPTURA',
            'IMPOSTO_SELO',
            'IVA',
            'TAXA_JURO',
            'LUCRO_PARCELA_JA',
            'LUCRO_BNI',
            'VALOR_COMPRA',
            'NUMERO_PRESTACOES',
            'COMISSAO_PAGAR_ADERENTE',
            'COMISSAO_PAGAR_CLIENTE_FINAL',
            'NUM_DA_PARCELA',
            'ADERENTE_ID',
            'COMPRA_ID',
            'PAGAMENTO_ID',
            'CLIENTE_NOME',
            'CLIENTE_NIF',
            'CLIENTE_CARTAO_CIDADAO',
            'VALOR_COMISSAO_PAGAR_ADERENTE',
            'VALOR_COMISSAO_PAGAR_CLIENTE',
            'VALOR_COMISSAO_SUJEITA_A_IVA',
            'IVA_COMISSAO',
            'CUSTO_DE_CAPTURA',
            'IVA_CUSTO_DE_CAPTURA',
            'IVA_TOTAL',
            'VALOR_TOTAL_COBRADO_AO_ADERENTE',
            'VALOR_TOTAL_COBRADO_AO_CLIENTE',
            'VALOR_FINANCIANDO_AO_ADERENTE',
            'VALOR_PAGO_AO_ADERENTE',
            'VALOR_DAS_PARCELAS',
            'VALOR_DAS_PARCELAS_EMISSOR',
            'COMISSAO_OGONE',
            'COMISSAO_EVO_PAYMENTS',
            'VALOR_A_RECEBER_DA_EVO_PAYMENTS',
            'CAPITAL_AMORTIZADO_MENSALMENTE',
            'CAPITAL_AMORTIZADO_ACUMULADO',
            'CAPITAL_EM_DIVIDA',
            'JURO',
            'JURO_ACUMULADO',
            'PROC_SEPA_CT',
            'IMPOSTO_SELO',
            'IMPOSTO_SELO_ACUMULADO',
            'PII_PARCIAL',
            'PII_ACUMULADA',
            'LUCRO_PARCELA',
            'LUCRO_BNI_EUROPA',
            'VALOR_TRANSF_PARCELA_JA',
            'IVA_VALOR_PARCELA_JA',
            'VALOR_TRANSF_PARCELA_JA_COM_IVA',
            'VALOR_TRANSF_BNI',
            'IS_VALOR_BNI',
            'VALOR_TRANSF_BNI_COM_IMP_SELO',
            'TAXA_COMISSSAO_SUJEITA_A_IVA',
            'TAXA_PROCESSAMENTO',
            'IVA',
            'SERVICOS_FINANCEIROS',
            'IMP_SELO',
            'TIPO_TRANSACAO',
            'TIPO_TAXA',
            //dados evo
            'CLIENT_EVO',
            'PAYMETHOD_EVO',
            'TYPE_EVO',
            'BOOKING_DATE_EVO',
            'PAY_DATE_EVO',
            'CUSTOMER_EVO',
            'PROC_CUSTOMER_ID_EVO',
            'CLIENT_CUSTOMER_NUM_EVO',
            'CREDIT_CARD_NUM_EVO',
            'DEPOSITS_EVO',
            'REFUNDS_EVO',
            'CFT_CREDITS_EVO',
            'CHARGEBACKS_EVO',
            'CURRENCY_EVO',
            'orderID_INGENICO',
            'PAYID_INGENICO',
            'PAYIDSUB_INGENICO',
            'NCSTATUS_INGENICO',
            'NCERROR_INGENICO',
            'NCERRORPLUS_INGENICO',
            'ACCEPTANCE_INGENICO',
            'STATUS_INGENICO',
            'IPCTY_INGENICO',
            'CCCTY_INGENICO',
            'ECI_INGENICO',
            'CVCCheck_INGENICO',
            'AAVCheck_INGENICO',
            'VC_INGENICO',
            'amount_INGENICO',
            'currency_INGENICO',
            'PM_INGENICO',
            'BRAND_INGENICO',
            'CARDNO_INGENICO',
            'SCORING_INGENICO',
            'SCO_CATEGORY_INGENICO',
                ), ';');


        foreach ($tpayments as $payment) {

            //Pressupostos  Fixos
            if ($payment instanceof TpaymentsTaxaServico) {
                $CUSTO_CAPTURA = TpaymentsTaxaServico::CUSTO_CAPTURA;
                $EVO_PAYMENTS = TpaymentsTaxaServico::EVO_PAYMENTS;
                $OGONE = TpaymentsTaxaServico::OGONE;
                $PROC_SEPA_CT = TpaymentsTaxaServico::PROC_SEPA_CT;
                $CAPTURA = TpaymentsTaxaServico::CAPTURA;
                $IMPOSTO_SELO = TpaymentsTaxaServico::IMPOSTO_SELO;
                $IVA = TpaymentsTaxaServico::IVA;
                $TAXA_JURO = TpaymentsTaxaServico::TAXA_JURO;
                $LUCRO_PARCELA_JÁ = TpaymentsTaxaServico::LUCRO_PARCELA;
                $LUCRO_BNI = TpaymentsTaxaServico::LUCRO_BNI;
            } elseif ($payment instanceof TpaymentsTaxaDesconto) {
                $CUSTO_CAPTURA = TpaymentsTaxaDesconto::CUSTO_CAPTURA;
                $EVO_PAYMENTS = TpaymentsTaxaDesconto::EVO_PAYMENTS;
                $OGONE = TpaymentsTaxaDesconto::OGONE;
                $PROC_SEPA_CT = TpaymentsTaxaDesconto::PROC_SEPA_CT;
                $CAPTURA = TpaymentsTaxaDesconto::CAPTURA;
                $IMPOSTO_SELO = TpaymentsTaxaDesconto::IMPOSTO_SELO;
                $IVA = TpaymentsTaxaDesconto::IVA;
                $TAXA_JURO = TpaymentsTaxaDesconto::TAXA_JURO;
                $LUCRO_PARCELA_JÁ = TpaymentsTaxaDesconto::LUCRO_PARCELA;
                $LUCRO_BNI = TpaymentsTaxaDesconto::LUCRO_BNI;
            }

            //Pressupostos  Variáveis
            $valorCompra = $payment->getValorCompra();
            $numeroPrestacoes = $payment->getNumeroPrestacoes();

            if ($payment instanceof TpaymentsTaxaServico) {
                $comissaoPagarAderente = 0;
                $comissaoPagarClienteFinal = $payment->getComissaoPagarClienteFinal();
            } else {

                $comissaoPagarAderente = $payment->getComissaoPagarAderente();
                $comissaoPagarClienteFinal = 0;
            }

            //Variáveis Dependentes
            $numParcela = $payment->getNumParcela(); //Nº DA PARCELA

            //Variáveis Novas
            $idAderente = $payment->getIdAderente();
            $idCompra = $payment->getIdCompra();
            $idPagamento = $payment->getIdPagamento();
            $clienteNome = $payment->getClienteNome();
            $clienteNif = $payment->getClienteNif();
            $clienteCartaoCidadao = $payment->getClienteCartaoCidadao();




            
            if($payment->getNumParcela()==0):
                if ($payment instanceof TpaymentsTaxaServico) {
                $valorComissaoPagarAderente = 0; //VALOR COMISSAO PAGAR ADERENTE
                $valorComissaoPagarCliente = $payment->getValorComissaoPagarCliente(); //VALOR COMISSAO PAGAR CLIENTE
            } else {
                $valorComissaoPagarAderente = $payment->getValorComissaoPagarAderente(); //VALOR COMISSAO PAGAR ADERENTE
                $valorComissaoPagarCliente = 0; //VALOR COMISSAO PAGAR CLIENTE 
            } 
                
                else:
                  
                $valorComissaoPagarAderente = 0; //VALOR COMISSAO PAGAR ADERENTE
                $valorComissaoPagarCliente = 0; //VALOR COMISSAO PAGAR CLIENTE
            
            endif;

           

            $valorComissaoSujeitaIva = $payment->getValorComissaoSujeitaIva(); //VALOR COMISSAO SUJEITA A IVA
            $ivaComissao = $payment->getIvaComissao(); //IVA COMISSAO
            $custoCaptura = $payment->getCustoCaptura(); //CUSTO DE CAPTURA
            $ivaCustoCaptura = $payment->getIvaCustoCaptura(); //IVA CUSTO DE CAPTURA
            $ivaTotal = $payment->getIvaTotal(); //IVA TOTAL

            if ($payment instanceof TpaymentsTaxaServico) {
                $valorTotalCobradoAderente = 0; //VALOR TOTAL COBRADO AO ADERENTE  
                $valorTotalCobradoCliente = $payment->getValorTotalCobradoCliente(); //VALOR TOTAL COBRADO AO CLIENTE
            } else {
                $valorTotalCobradoAderente = $payment->getValorTotalCobradoAderente(); //VALOR TOTAL COBRADO AO ADERENTE  
                $valorTotalCobradoCliente = 0; //VALOR TOTAL COBRADO AO CLIENTE 
            }

            $valorFinanciadoAderente = $payment->getValorFinanciadoAderente(); //VALOR FINANCIANDO AO ADERENTE
            $valorPagoAderente = $payment->getValorPagoAderente(); //VALOR PAGO AO ADERENTE

            if ($payment instanceof TpaymentsTaxaServico) {
                $valParcelas = 0; //VALOR DAS PARCELAS
                $valParcelasEmissor = $payment->getValParcelasEmissor(); //VALOR DAS PARCELAS EMISSOR
            } else {
                $valParcelas = $payment->getValParcelas(); //VALOR DAS PARCELAS
                $valParcelasEmissor = 0; //VALOR DAS PARCELAS EMISSOR 
            }

            $comOgone = $payment->getComOgone(); //COMISSAO OGONE
            $comEvoPayments = $payment->getComEvoPayments(); //COMISSAO EVO PAYMENTS
            $valorReceberEvoPayments = $payment->getValorReceberEvoPayments(); //VALOR A RECEBER DA EVO PAYMENTS
            $capitalAmortizadoMensalmente = $payment->getCapitalAmortizadoMensalmente(); //CAPITAL A AMORTIZADO MENSALMENTE
            $capitalAmortizadoAcumulado = $payment->getCapitalAmortizadoAcumulado(); //CAPITAL AMORTIZADO ACUMULADO
            $capitalEmDivida = $payment->getCapitalEmDivida(); //CAPITAL EM DÍVIDA
            $juro = $payment->getJuro(); //JURO
            $juroAcumulado = $payment->getJuroAcumulado(); //JURO ACUMULADO
            $procSepaCt = $payment->getProcSepaCt();
            $impostoSelo = $payment->getImpostoSelo(); //IMPOSTO SELO
            $impostoSeloAcumulado = $payment->getImpostoSeloAcumulado(); //IMPOSTO SELO ACUMULADO
            $piiParcial = $payment->getPiiParcial(); //π PARCIAL
            $piiAcumulado = $payment->getPiiAcumulado(); //π ACUMULADA
            $lucroParcela = $payment->getLucroParcela(); //LUCRO PARCELA
            $lucroBniEuropa = $payment->getLucroBniEuropa(); //LUCRO BNI EUROPA
            $valorTransferParcela = $payment->getValorTransferParcela(); //VALOR TRANSF/PARCELA JÁ
            $ivaValorParcela = $payment->getIvaValorParcela(); //IVA VALOR PARCELA JÁ
            $valorTransfParcelaComIva = $payment->getValorTransfParcelaComIva(); //VALOR TRANSF/PARCELA JÁ (C/IVA)
            $valorTransfBni = $payment->getValorTransfBni(); //VALOR TRANSF BNI
            $impostoSeloValorBni = $payment->getImpostoSeloValorBni(); //IS VALOR BNI
            $valorTransfBniComImpostoSelo = $payment->getValorTransfBniComImpostoSelo(); //VALOR TRANSF BNI (C/IS)
            $taxaComissaoSujeitaIva = $payment->getTaxaComissaoSujeitaIva(); //TAXA COMISSSAO SUJEITA A IVA
            $taxaProcessamento = $payment->getTaxaProcessamento(); //TAXA PROCESSAMENTO
            $iva = $payment->getIva(); //IVA
            $servicosFinanceiros = $payment->getServicosFinanceiros(); //SERVIÇOS FINANCEIROS
            $impSelo = $payment->getImpSelo(); //IMP. SELO
            $tipoTransacao = $payment->getTipoTransacao();
            $tipoTaxa = $payment->getTipoTaxa();



            //TRATAMENTO DOS DADOS DA EVO PAYMENTS
            //como os objectos que vêm são os dos calculos necessito de ir buscar dados a tabela de payments
            $tpayment = $em->getRepository('AppBundle:Tpayments')->find($payment->getIdPagamento());

            $clientEVO = $tpayment->getFclientevo();
            $payMethodEVO = $tpayment->getFpaymethodevo();
            $typeEVO = $tpayment->getFtypeevo();
            $bookingDateEVO = ($tpayment->getFbookingdateevo() == null) ? ' ' : $tpayment->getFbookingdateevo()->format('Y-m-d');
            $payDateEVO = ($tpayment->getFpaydateevo() == null) ? ' ' : $tpayment->getFpaydateevo()->format('Y-m-d');
            $customerEVO = $tpayment->getFcustomerevo();
            $procCustomerIdEVO = $tpayment->getFproccustomeridevo();
            $clientCustomerNumEVO = $tpayment->getFclientcustomernumevo();
            $creditCardNumEVO = $tpayment->getFcreditcardnumevo();
            $depositsEVO = $tpayment->getFdepositsevo();
            $refundsEVO = $tpayment->getFrefundsevo();
            $CFTCreditsEVO = $tpayment->getFcftcreditsevo();
            $chargebacksEVO = $tpayment->getFchargebacksevo();
            $currencyEVO = $tpayment->getFcurrencyevo();



            //TRATAMENTO DOS DADOS DA INGENICO
            //necessito de ir buscar os dados a tabela ingenico_payments
            $ingenico_payment = $em->getRepository('AppBundle:IngenicoPayment')->find($payment->getIdPagamento());

            $orderIdINGENICO = $ingenico_payment->getOrderId();
            $paiIDINGENICO = $ingenico_payment->getPayId();
            $payIdSubINGENICO = $ingenico_payment->getPayIdSub();
            $ncStatusINGENICO = $ingenico_payment->getNcStatus();
            $ncErrorINGENICO = $ingenico_payment->getNcError();
            $ncErrorPlusINGENICO = $ingenico_payment->getNcErrorPlus();
            $acceptanceINGENICO = $ingenico_payment->getAcceptance();
            $statusINGENICO = $ingenico_payment->getStatus();
            $ipctyINGENICO = $ingenico_payment->getIpcty();
            $ccctyINGENICO = $ingenico_payment->getCccty();
            $eciINGENICO = $ingenico_payment->getEci();
            $cvcCheckINGENICO = $ingenico_payment->getCvcCheck();
            $aavCheckINGENICO = $ingenico_payment->getAavCheck();
            $vcINGENICO = $ingenico_payment->getVc();
            $amountINGENICO = $ingenico_payment->getAmount();
            $currencyINGENICO = $ingenico_payment->getCurrency();
            $pmINGENICO = $ingenico_payment->getPm();
            $brandINGENICO = $ingenico_payment->getBrand();
            $cardNoINGENICO = $ingenico_payment->getCardNo();
            $scoringINGENICO = $ingenico_payment->getScoring();
            $scoCategoryINGENICO = $ingenico_payment->getScoCategory();

            fputcsv(
                    $handle, // The file pointer
                    array(
                $CUSTO_CAPTURA,
                $EVO_PAYMENTS,
                $OGONE,
                $PROC_SEPA_CT,
                $CAPTURA,
                $IMPOSTO_SELO,
                $IVA,
                $TAXA_JURO,
                $LUCRO_PARCELA_JÁ,
                $LUCRO_BNI,
                $valorCompra,
                $numeroPrestacoes,
                $comissaoPagarAderente,
                $comissaoPagarClienteFinal,
                $numParcela,
                $idAderente,
                $idCompra,
                $idPagamento,
                $clienteNome,
                $clienteNif,
                $clienteCartaoCidadao,
                $valorComissaoPagarAderente,
                ($numParcela == 0) ? $valorComissaoPagarCliente : 0,
                ($numParcela == 0) ? round($valorComissaoSujeitaIva, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? round($ivaComissao, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? round($custoCaptura, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? round($ivaCustoCaptura, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? round($ivaTotal, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? round($valorTotalCobradoAderente, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? $valorTotalCobradoCliente : 0,
                ($numParcela == 0) ? round($valorFinanciadoAderente, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? round($valorPagoAderente, self::NUM_CASAS_DECIMAIS) : 0,
                round($valParcelas, self::NUM_CASAS_DECIMAIS),
                round($valParcelasEmissor, self::NUM_CASAS_DECIMAIS),
                round($comOgone, self::NUM_CASAS_DECIMAIS),
                round($comEvoPayments, self::NUM_CASAS_DECIMAIS),
                round($valorReceberEvoPayments, self::NUM_CASAS_DECIMAIS),
                round($capitalAmortizadoMensalmente, self::NUM_CASAS_DECIMAIS),
                round($capitalAmortizadoAcumulado, self::NUM_CASAS_DECIMAIS),
                round($capitalEmDivida, self::NUM_CASAS_DECIMAIS),
                round($juro, self::NUM_CASAS_DECIMAIS),
                round($juroAcumulado, self::NUM_CASAS_DECIMAIS),
                ($numParcela == 0) ? $procSepaCt : 0,
                round($impostoSelo, self::NUM_CASAS_DECIMAIS),
                round($impostoSeloAcumulado, self::NUM_CASAS_DECIMAIS),
                round($piiParcial, self::NUM_CASAS_DECIMAIS),
                round($piiAcumulado, self::NUM_CASAS_DECIMAIS),
                round($lucroParcela, self::NUM_CASAS_DECIMAIS),
                round($lucroBniEuropa, self::NUM_CASAS_DECIMAIS),
                round($valorTransferParcela, self::NUM_CASAS_DECIMAIS),
                round($ivaValorParcela, self::NUM_CASAS_DECIMAIS),
                round($valorTransfParcelaComIva, self::NUM_CASAS_DECIMAIS),
                round($valorTransfBni, self::NUM_CASAS_DECIMAIS),
                round($impostoSeloValorBni, self::NUM_CASAS_DECIMAIS),
                round($valorTransfBniComImpostoSelo, self::NUM_CASAS_DECIMAIS),
                ($numParcela == 0) ? round($taxaComissaoSujeitaIva, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? $taxaProcessamento : 0,
                ($numParcela == 0) ? round($iva, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? round($servicosFinanceiros, self::NUM_CASAS_DECIMAIS) : 0,
                ($numParcela == 0) ? round($impSelo, self::NUM_CASAS_DECIMAIS) : 0,
                $tipoTransacao,
                $tipoTaxa,
                $clientEVO, //EVO PAYMENTS FROM HERE
                $payMethodEVO,
                $typeEVO,
                $bookingDateEVO,
                $payDateEVO,
                $customerEVO,
                $procCustomerIdEVO,
                $clientCustomerNumEVO,
                $creditCardNumEVO,
                $depositsEVO,
                $refundsEVO,
                $CFTCreditsEVO,
                $chargebacksEVO,
                $currencyEVO,
                $orderIdINGENICO, //INGENICO PAYMENTS FROM HERE
                $paiIDINGENICO,
                $payIdSubINGENICO,
                $ncStatusINGENICO,
                $ncErrorINGENICO,
                $ncErrorPlusINGENICO,
                $acceptanceINGENICO,
                $statusINGENICO,
                $ipctyINGENICO,
                $ccctyINGENICO,
                $eciINGENICO,
                $cvcCheckINGENICO,
                $aavCheckINGENICO,
                $vcINGENICO,
                $amountINGENICO,
                $currencyINGENICO,
                $pmINGENICO,
                $brandINGENICO,
                $cardNoINGENICO,
                $scoringINGENICO,
                $scoCategoryINGENICO,
                    ), // The fields
                    ';' // The delimiter
            );
        }

        fclose($handle);
    }

    public static function generateCsvFile2() {
        $file = 'people.txt';
// The new person to add to the file
        $person = "John Smith\n";
// Write the contents topar  the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
        file_put_contents($file, $person, FILE_APPEND | LOCK_EX);
    }

}
