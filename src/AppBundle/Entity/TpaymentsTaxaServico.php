<?php

namespace AppBundle\Entity;

use AppBundle\Utils\Utils;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TpaymentsTaxaDesconto
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class TpaymentsTaxaServico {

    //Pressupostos  Fixos
    const CUSTO_CAPTURA = 0.00;
    const EVO_PAYMENTS = 0.0045;
    const OGONE = 0.10;
    const PROC_SEPA_CT = 0.008;
    const CAPTURA = 0.00;
    const IMPOSTO_SELO = 0.04;
    const IVA = 0.23;
    const TAXA_JURO = 0.05;
    const LUCRO_PARCELA = 0.75;
    const LUCRO_BNI = 0.25;
    const NUM_CASAS_DECIMAIS = 8;
    const DIFERENCA_ENTRE_ITERACOES = 0.00000000000000000000000000000000000000000000000001;

    //Pressupostos  Variáveis
    private $valorCompra;
    private $numeroPrestacoes;
//private $comissaoPagarAderente;
    private $comissaoPagarClienteFinal;
//Variáveis Dependentes
    private $numParcela; //Nº DA PARCELA
//private $valorComissaoPagarAderente; //VALOR COMISSAO PAGAR ADERENTE
    private $valorComissaoPagarCliente; //VALOR COMISSAO PAGAR CLIENTE
    private $valorComissaoSujeitaIva; //VALOR COMISSAO SUJEITA A IVA
    private $ivaComissao; //IVA COMISSAO
    private $custoCaptura; //CUSTO DE CAPTURA
    private $ivaCustoCaptura; //IVA CUSTO DE CAPTURA
    private $ivaTotal; //IVA TOTAL
//private $valorTotalCobradoAderente; //VALOR TOTAL COBRADO AO ADERENTE  
    private $valorTotalCobradoCliente; //VALOR TOTAL COBRADO AO CLIENTE
    private $valorFinanciadoAderente; //VALOR FINANCIANDO AO ADERENTE
    private $valorPagoAderente; //VALOR PAGO AO ADERENTE
//private $valParcelas; //VALOR DAS PARCELAS
    private $valParcelasEmissor; //VALOR DAS PARCELAS EMISSOR
    private $comOgone = 0; //COMISSAO OGONE
    private $comEvoPayments = 0; //COMISSAO EVO PAYMENTS
    private $valorReceberEvoPayments = 0; //VALOR A RECEBER DA EVO PAYMENTS
    private $capitalAmortizadoMensalmente = 0; //CAPITAL A AMORTIZADO MENSALMENTE
    private $capitalAmortizadoAcumulado = 0; //CAPITAL AMORTIZADO ACUMULADO
    private $capitalEmDivida = 0; //CAPITAL EM DÍVIDA
    private $juro = 0; //JURO
    private $juroAcumulado = 0; //JURO ACUMULADO
    private $procSepaCt = 0;
    private $impostoSelo = 0; //IMPOSTO SELO
    private $impostoSeloAcumulado = 0; //IMPOSTO SELO ACUMULADO
    private $piiParcial = 0; //π PARCIAL
    private $piiAcumulado = 0; //π ACUMULADA
    private $lucroParcela = 0; //LUCRO PARCELA
    private $lucroBniEuropa = 0; //LUCRO BNI EUROPA
    private $valorTransferParcela = 0; //VALOR TRANSF/PARCELA JÁ
    private $ivaValorParcela = 0; //IVA VALOR PARCELA JÁ
    private $valorTransfParcelaComIva = 0; //VALOR TRANSF/PARCELA JÁ (C/IVA)
    private $valorTransfBni = 0; //VALOR TRANSF BNI
    private $impostoSeloValorBni = 0; //IS VALOR BNI
    private $valorTransfBniComImpostoSelo = 0; //VALOR TRANSF BNI (C/IS)
    private $taxaComissaoSujeitaIva; //TAXA COMISSSAO SUJEITA A IVA
    private $taxaProcessamento; //TAXA PROCESSAMENTO
    private $iva; //IVA
    private $servicosFinanceiros; //SERVIÇOS FINANCEIROS
    private $impSelo; //IMP. SELO
    private $tipoTransacao; //Pré-parceria (PP), A crédito (AC), Sem crédito (SC) 
//    private $payID; //para conseguir ir buscar dados EVO e OGONE
//    private $datePayment;
    private $idAderente;
    private $idCompra;
    private $idPagamento;
    private $clienteNome;
    private $clienteNif;
    private $clienteCartaoCidadao;
    //para o mapa
    private $dataPagamento;
    private $contractNumber;
    
    private $tipoTaxa;

    //function __construct($valorCompra, $numeroPrestacoes, $numParcela, $comissaoPagarClienteFinal, $tipoTransacao, $payID,$datePayment) {
    function __construct($purchase, $numParcela, $comissaoPagarClienteFinal, $payment) {
        //$this->valorCompra = $purchase->getFcalcamount();
        $this->valorCompra = str_replace(',', '.', $purchase->getFcalcamount());
        $this->numeroPrestacoes = $purchase->getFmonthdata();
        $this->numParcela = $numParcela;
        $this->comissaoPagarClienteFinal = $comissaoPagarClienteFinal;

        $this->idAderente = is_null($purchase->getAgency())?0:$purchase->getAgency()->getFagencyid();
        $this->idCompra = $purchase->getFpurchaseid();
        $this->idPagamento = is_null($payment) ? 0 : $payment->getFpayid();
        $this->dataPagamento = is_null($payment) ? 0 : $payment->getFDate();
        $this->contractNumber = $purchase->getFcontractnumber();

        $this->clienteNome = Utils::getClienteData('nome', $purchase->getFclientdata()) . ' ' . Utils::getClienteData('sobrenome', $purchase->getFclientdata());
        $this->clienteNif = Utils::getClienteData('nif', $purchase->getFclientdata());
        $this->clienteCartaoCidadao = Utils::getClienteData('cartaoCidadao', $purchase->getFclientdata());

        $this->tipoTransacao = Utils::getTipoTransacao($purchase);
        $this->tipoTaxa = "TS";
    }

    function getValorCompra() {
        return $this->valorCompra;
    }

    function getNumeroPrestacoes() {
        return $this->numeroPrestacoes;
    }

//    function getComissaoPagarAderente() {
//        return $this->comissaoPagarAderente;
//    }

    function getNumParcela() {
        return $this->numParcela;
    }

//    function getValorComissaoPagarAderente() {
//        return $this->getValorCompra() * $this->getComissaoPagarAderente();
//    }

    function getValorComissaoSujeitaIva() {
        //return 39.18; //tem um somatório
        return $this->valorComissaoSujeitaIva;
    }

    function getIvaComissao() {
        return $this->getValorComissaoSujeitaIva() * self::IVA;
    }

    function getCustoCaptura() {
        return $this->getNumeroPrestacoes() * self::CUSTO_CAPTURA;
    }

    function getIvaCustoCaptura() {
        return $this->getCustoCaptura() * self::IVA;
    }

    function getIvaTotal() {
        return $this->getIvaComissao() + $this->getIvaCustoCaptura();
    }

//    function getValorTotalCobradoAderente() {
//        return $this->getValorComissaoPagarAderente() + $this->getCustoCaptura() + $this->getIvaTotal();
//    }

    function getValorFinanciadoAderente() {
        //return $this->getValorCompra() - $this->getValorComissaoPagarAderente() - $this->getCustoCaptura();
        return $this->getValorCompra();
    }

    function getValorPagoAderente() {
        //return $this->getValorCompra() - $this->getValorComissaoPagarAderente() - $this->getCustoCaptura() - $this->getIvaTotal();
        return $this->getValorCompra();
    }

//    function getValParcelas() {
//        return $this->getValorCompra() / $this->getNumeroPrestacoes();
//    }

    function getComOgone() {
        return self::OGONE;
    }

    function getComEvoPayments() {
        return $this->getValParcelasEmissor() * self::EVO_PAYMENTS;
    }

    function getValorReceberEvoPayments() {
        return $this->getValParcelasEmissor() - $this->getComEvoPayments();
    }

    function getCapitalAmortizadoMensalmente() {
        return $this->getValorFinanciadoAderente() / $this->getNumeroPrestacoes();
    }

    function getCapitalAmortizadoAcumulado() {
        //somatorio, calculado fora
        return $this->capitalAmortizadoAcumulado;
    }

    function getCapitalEmDivida() {
        return $this->getValorFinanciadoAderente() - $this->getCapitalAmortizadoAcumulado();
    }

    function getJuro() {
        //como o capital em em divida é do mês anterior tem de ser calculado fora
        return $this->juro;
    }

    function getJuroAcumulado() {
        return $this->juroAcumulado;
    }

    function getImpostoSelo() {
        return ($this->getJuro() + $this->getProcSepaCt()) * self::IMPOSTO_SELO;
    }

    function getImpostoSeloAcumulado() {
        return $this->impostoSeloAcumulado;
    }

    function getPiiAcumulado() {
        return $this->piiAcumulado;
    }

    function getLucroParcela() {
        return $this->getPiiParcial() * self::LUCRO_PARCELA;
    }

    function getLucroBniEuropa() {
        return $this->getPiiParcial() * self::LUCRO_BNI;
    }

    function getValorTransferParcela() {
        return $this->getLucroParcela() + $this->getComOgone();
    }

    function getValorTransfParcelaComIva() {
        return $this->getValorTransferParcela() + $this->getIvaValorParcela();
    }

    //referencia circular
    function getValorTransfBni() {
        return $this->getLucroBniEuropa() + $this->getJuro() + $this->getProcSepaCt();
    }

    //referencia circular
    function getImpostoSeloValorBni() {
        //return $this->getValorTransfBni() * self::IMPOSTO_SELO;

        return $this->impostoSeloValorBni;
    }

    function getValorTransfBniComImpostoSelo() {
        return $this->getValorTransfBni() + $this->getImpostoSeloValorBni();
    }

    function getTaxaComissaoSujeitaIva() {
        return $this->getValorComissaoSujeitaIva();
    }

    function getTaxaProcessamento() {
        return $this->getCustoCaptura();
    }

    function getIva() {
        return $this->getIvaTotal();
    }

    function getServicosFinanceiros() {
        //tem somatorio
        return $this->servicosFinanceiros;
    }

    function setValorCompra($valorCompra) {
        $this->valorCompra = $valorCompra;
    }

    function setNumeroPrestacoes($numeroPrestacoes) {
        $this->numeroPrestacoes = $numeroPrestacoes;
    }

//    function setComissaoPagarAderente($comissaoPagarAderente) {
//        $this->comissaoPagarAderente = $comissaoPagarAderente;
//    }

    function setNumParcela($numParcela) {
        $this->numParcela = $numParcela;
    }

//    function setValorComissaoPagarAderente($valorComissaoPagarAderente) {
//        $this->valorComissaoPagarAderente = $valorComissaoPagarAderente;
//    }

    function setValorComissaoSujeitaIva($valorComissaoSujeitaIva) {
        $this->valorComissaoSujeitaIva = $valorComissaoSujeitaIva;
    }

    function setIvaComissao($ivaComissao) {
        $this->ivaComissao = $ivaComissao;
    }

    function setCustoCaptura($custoCaptura) {
        $this->custoCaptura = $custoCaptura;
    }

    function setIvaCustoCaptura($ivaCustoCaptura) {
        $this->ivaCustoCaptura = $ivaCustoCaptura;
    }

    function setIvaTotal($ivaTotal) {
        $this->ivaTotal = $ivaTotal;
    }

//    function setValorTotalCobradoAderente($valorTotalCobradoAderente) {
//        $this->valorTotalCobradoAderente = $valorTotalCobradoAderente;
//    }

    function setValorFinanciadoAderente($valorFinanciadoAderente) {
        $this->valorFinanciadoAderente = $valorFinanciadoAderente;
    }

    function setValorPagoAderente($valorPagoAderente) {
        $this->valorPagoAderente = $valorPagoAderente;
    }

//    function setValParcelas($valParcelas) {
//        $this->valParcelas = $valParcelas;
//    }

    function setComOgone($comOgone) {
        $this->comOgone = $comOgone;
    }

    function setComEvoPayments($comEvoPayments) {
        $this->comEvoPayments = $comEvoPayments;
    }

    function setValorReceberEvoPayments($valorReceberEvoPayments) {
        $this->valorReceberEvoPayments = $valorReceberEvoPayments;
    }

    function setCapitalAmortizadoMensalmente($capitalAmortizadoMensalmente) {
        $this->capitalAmortizadoMensalmente = $capitalAmortizadoMensalmente;
    }

    function setCapitalAmortizadoAcumulado($capitalAmortizadoAcumulado) {
        $this->capitalAmortizadoAcumulado = $capitalAmortizadoAcumulado;
    }

    function setCapitalEmDivida($capitalEmDivida) {
        $this->capitalEmDivida = $capitalEmDivida;
    }

    function setJuro($juro) {
        $this->juro = $juro;
    }

    function setJuroAcumulado($juroAcumulado) {
        $this->juroAcumulado = $juroAcumulado;
    }

    function setImpostoSelo($impostoSelo) {
        $this->impostoSelo = $impostoSelo;
    }

    function setImpostoSeloAcumulado($impostoSeloAcumulado) {
        $this->impostoSeloAcumulado = $impostoSeloAcumulado;
    }

    function setPiiParcial($piiParcial) {
        $this->piiParcial = $piiParcial;
    }

    function setPiiAcumulado($piiAcumulado) {
        $this->piiAcumulado = $piiAcumulado;
    }

    function setLucroParcela($lucroParcela) {
        $this->lucroParcela = $lucroParcela;
    }

    function setLucroBniEuropa($lucroBniEuropa) {
        $this->lucroBniEuropa = $lucroBniEuropa;
    }

    function setValorTransferParcela($valorTransferParcela) {
        $this->valorTransferParcela = $valorTransferParcela;
    }

    function setIvaValorParcela($ivaValorParcela) {
        $this->ivaValorParcela = $ivaValorParcela;
    }

    function setValorTransfParcelaComIva($valorTransfParcelaComIva) {
        $this->valorTransfParcelaComIva = $valorTransfParcelaComIva;
    }

    function setValorTransfBni($valorTransfBni) {
        $this->valorTransfBni = $valorTransfBni;
    }

    function setImpostoSeloValorBni($impostoSeloValorBni) {
        $this->impostoSeloValorBni = $impostoSeloValorBni;
    }

    function setValorTransfBniComImpostoSelo($valorTransfBniComImpostoSelo) {
        $this->valorTransfBniComImpostoSelo = $valorTransfBniComImpostoSelo;
    }

    function setTaxaComissaoSujeitaIva($taxaComissaoSujeitaIva) {
        $this->taxaComissaoSujeitaIva = $taxaComissaoSujeitaIva;
    }

    function setTaxaProcessamento($taxaProcessamento) {
        return $this->taxaProcessamento = $taxaProcessamento;
    }

    function setIva($iva) {
        return $this->iva = $iva;
    }

    function setServicosFinanceiros($servicosFinanceiros) {
        $this->servicosFinanceiros = $servicosFinanceiros;
    }

    function getImpSelo() {
        return $this->impSelo;
    }

    function setImpSelo($impSelo) {
        $this->impSelo = $impSelo;
    }

    function getProcSepaCt() {
        return $this->procSepaCt;
    }

    function setProcSepaCt($procSepaCt) {
        $this->procSepaCt = $procSepaCt;
    }

    // novos campos

    function getComissaoPagarClienteFinal() {
        return $this->comissaoPagarClienteFinal;
    }

    function getValorComissaoPagarCliente() {
        return $this->getComissaoPagarClienteFinal();
    }

    function getValorTotalCobradoCliente() {
        return $this->getValorComissaoPagarCliente();
    }

    function setComissaoPagarClienteFinal($comissaoPagarClienteFinal) {
        $this->comissaoPagarClienteFinal = $comissaoPagarClienteFinal;
    }

    function setValorComissaoPagarCliente($valorComissaoPagarCliente) {
        $this->valorComissaoPagarCliente = $valorComissaoPagarCliente;
    }

    function setValorTotalCobradoCliente($valorTotalCobradoCliente) {
        $this->valorTotalCobradoCliente = $valorTotalCobradoCliente;
    }

    function getValParcelasEmissor() {
        return ($this->getValorCompra() + $this->getComissaoPagarClienteFinal()) / $this->getNumeroPrestacoes();
    }

    function setValParcelasEmissor($valParcelasEmissor) {
        $this->valParcelasEmissor = $valParcelasEmissor;
    }

    function getIvaValorParcela() {
        return $this->ivaValorParcela;
    }

    //referencia circular
    function getPiiParcial() {
        //(($C$19/$C$18)-(E39+E40+E46+E49+E64+E60))/(1+$C$10*0)
        return (($this->getComissaoPagarClienteFinal() / $this->getNumeroPrestacoes()) 
                - ($this->getComOgone() + $this->getComEvoPayments() + $this->getJuro() + $this->getProcSepaCt() + $this->getImpostoSeloValorBni() + $this->getIvaValorParcela()))
        / (1 + self::IVA * 0);
    }

    function getTipoTransacao() {
        return $this->tipoTransacao;
    }

    function setTipoTransacao($tipoTransacao) {
        $this->tipoTransacao = $tipoTransacao;
    }

//    function getPayID() {
//        return $this->payID;
//    }
//
//    function setPayID($payID) {
//        $this->payID = $payID;
//    }
//
//
//    function getDatePayment() {
//        //return $this->datePayment;
//        return ($this->datePayment==null)?' ':$this->datePayment->format('Y-m-d');
//    }
//
//    function setDatePayment($datePayment) {
//        $this->datePayment = $datePayment;
//    }
//

    function getIdAderente() {
        return $this->idAderente;
    }

    function getIdCompra() {
        return $this->idCompra;
    }

    function getIdPagamento() {
        return $this->idPagamento;
    }

    function getClienteNome() {
        return $this->clienteNome;
    }

    function getClienteNif() {
        return $this->clienteNif;
    }

    function getClienteCartaoCidadao() {
        return $this->clienteCartaoCidadao;
    }

    function setIdAderente($idAderente) {
        $this->idAderente = $idAderente;
    }

    function setIdCompra($idCompra) {
        $this->idCompra = $idCompra;
    }

    function setIdPagamento($idPagamento) {
        $this->idPagamento = $idPagamento;
    }

    function setClienteNome($clienteNome) {
        $this->clienteNome = $clienteNome;
    }

    function setClienteNif($clienteNif) {
        $this->clienteNif = $clienteNif;
    }

    function setClienteCartaoCidadao($clienteCartaoCidadao) {
        $this->clienteCartaoCidadao = $clienteCartaoCidadao;
    }

    function getDataPagamento() {
        //return ($this->dataPagamento == null) ? ' ' : $this->dataPagamento->format('Y-m-d');
        return $this->dataPagamento;
        
    }

    function setDataPagamento($dataPagamento) {
        $this->dataPagamento = $dataPagamento;
    }

    
    function getContractNumber() {
        return $this->contractNumber;
    }

    function setContractNumber($contractNumber) {
        $this->contractNumber = $contractNumber;
    }

    
    function getTipoTaxa() {
        return $this->tipoTaxa;
    }

    function setTipoTaxa($tipoTaxa) {
        $this->tipoTaxa = $tipoTaxa;
    }



    
}
