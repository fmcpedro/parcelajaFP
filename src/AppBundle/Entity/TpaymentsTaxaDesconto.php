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
class TpaymentsTaxaDesconto {

    //Pressupostos  Fixos
    const CUSTO_CAPTURA = 0.20;
    const EVO_PAYMENTS = 0.0045;
    const OGONE = 0.10;
    const PROC_SEPA_CT = 0.008;
    const CAPTURA = 0.20;
    const IMPOSTO_SELO = 0.04;
    const IVA = 0.23;
    const TAXA_JURO = 0.05;
    const LUCRO_PARCELA = 0.75;
    const LUCRO_BNI = 0.25;
    const NUM_CASAS_DECIMAIS = 3;

    //Pressupostos  Variáveis
    private $valorCompra;
    private $numeroPrestacoes;
    private $comissaoPagarAderente;
    //Variáveis Dependentes
    private $numParcela; //Nº DA PARCELA
    private $valorComissaoPagarAderente; //VALOR COMISSAO PAGAR ADERENTE
    private $valorComissaoSujeitaIva; //VALOR COMISSAO SUJEITA A IVA
    private $ivaComissao; //IVA COMISSAO
    private $custoCaptura; //CUSTO DE CAPTURA
    private $ivaCustoCaptura; //IVA CUSTO DE CAPTURA
    private $ivaTotal; //IVA TOTAL
    private $valorTotalCobradoAderente; //VALOR TOTAL COBRADO AO ADERENTE
    private $valorFinanciadoAderente; //VALOR FINANCIANDO AO ADERENTE
    private $valorPagoAderente; //VALOR PAGO AO ADERENTE
    private $valParcelas; //VALOR DAS PARCELAS
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

    //function __construct($valorCompra, $numeroPrestacoes, $numParcela, $tipoTransacao, $payID, $datePayment) {
    function __construct(Tpurchase $purchase, $numParcela, Tpayments $payment=null) {
        $this->valorCompra = $purchase->getFcalcamount();
        $this->numeroPrestacoes = $purchase->getFmonthdata();
        $this->numParcela = $numParcela;
        $this->comissaoPagarAderente = ((($this->numeroPrestacoes / 2) + 0.5) / 100);
        
        $this->idAderente = is_null($purchase->getAgency())?0:$purchase->getAgency()->getFagencyid();
        $this->idCompra = $purchase->getFpurchaseid();
        $this->idPagamento = is_null($payment)?0:$payment->getFpayid();
        $this->dataPagamento = is_null($payment)?0:$payment->getFDate();
        $this->contractNumber = $purchase->getFcontractnumber();

        $this->clienteNome = Utils::getClienteData('nome', $purchase->getFclientdata()) . ' ' . Utils::getClienteData('sobrenome', $purchase->getFclientdata());
        $this->clienteNif = Utils::getClienteData('nif', $purchase->getFclientdata());
        $this->clienteCartaoCidadao = Utils::getClienteData('cartaoCidadao', $purchase->getFclientdata());

        $this->tipoTransacao = Utils::getTipoTransacao($purchase);
        $this->tipoTaxa = "TD";
    }

    function getValorCompra() {
        return $this->valorCompra;
    }

    function getNumeroPrestacoes() {
        return $this->numeroPrestacoes;
    }

    function getComissaoPagarAderente() {
        return $this->comissaoPagarAderente;
    }

    function getNumParcela() {
        return $this->numParcela;
    }

    function getValorComissaoPagarAderente() {
        return round($this->getValorCompra() * $this->getComissaoPagarAderente(), self::NUM_CASAS_DECIMAIS);
    }

    function getValorComissaoSujeitaIva() {
        //return 39.18; //tem um somatório
        return round($this->valorComissaoSujeitaIva, self::NUM_CASAS_DECIMAIS);
    }

    function getIvaComissao() {
        return round($this->getValorComissaoSujeitaIva() * self::IVA, self::NUM_CASAS_DECIMAIS);
    }

    function getCustoCaptura() {
        return round($this->getNumeroPrestacoes() * self::CUSTO_CAPTURA, self::NUM_CASAS_DECIMAIS);
    }

    function getIvaCustoCaptura() {
        return round($this->getCustoCaptura() * self::IVA, self::NUM_CASAS_DECIMAIS);
    }

    function getIvaTotal() {
        return round($this->getIvaComissao() + $this->getIvaCustoCaptura(), self::NUM_CASAS_DECIMAIS);
    }

    function getValorTotalCobradoAderente() {
        return round($this->getValorComissaoPagarAderente() + $this->getCustoCaptura() + $this->getIvaTotal(), self::NUM_CASAS_DECIMAIS);
    }

    function getValorFinanciadoAderente() {
        return round($this->getValorCompra() - $this->getValorComissaoPagarAderente() - $this->getCustoCaptura(), self::NUM_CASAS_DECIMAIS);
    }

    function getValorPagoAderente() {
        return round($this->getValorCompra() - $this->getValorComissaoPagarAderente() - $this->getCustoCaptura() - $this->getIvaTotal(), self::NUM_CASAS_DECIMAIS);
    }

    function getValParcelas() {
        return round($this->getValorCompra() / $this->getNumeroPrestacoes(), self::NUM_CASAS_DECIMAIS);
    }

    function getComOgone() {
        return round(self::OGONE, self::NUM_CASAS_DECIMAIS);
    }

    function getComEvoPayments() {
        return round($this->getValParcelas() * self::EVO_PAYMENTS, self::NUM_CASAS_DECIMAIS);
    }

    function getValorReceberEvoPayments() {
        return round($this->getValParcelas() - $this->getComEvoPayments(), self::NUM_CASAS_DECIMAIS);
    }

    function getCapitalAmortizadoMensalmente() {
        return round($this->getValorFinanciadoAderente() / $this->getNumeroPrestacoes(), self::NUM_CASAS_DECIMAIS);
    }

    function getCapitalAmortizadoAcumulado() {
        return $this->capitalAmortizadoAcumulado;
    }

    function getCapitalEmDivida() {
        return round($this->getValorFinanciadoAderente() - $this->getCapitalAmortizadoAcumulado(), self::NUM_CASAS_DECIMAIS);
    }

    function getJuro() {
        //como o capital em em divida é do mês anterior tem de ser calculado fora
        return round($this->juro, self::NUM_CASAS_DECIMAIS);
    }

    function getJuroAcumulado() {
        return round($this->juroAcumulado, self::NUM_CASAS_DECIMAIS);
    }

    function getImpostoSelo() {
        return round(($this->getJuro() + $this->getProcSepaCt()) * self::IMPOSTO_SELO, self::NUM_CASAS_DECIMAIS);
    }

    function getImpostoSeloAcumulado() {
        return $this->impostoSeloAcumulado;
    }

    function getPiiParcial() {
//        
//        echo $this->getValParcelas()."Valor Parcelas <br/>";
//        echo $this->getComissaoPagarAderente()."Comissao Pagar Aderente<br/>";
//        echo $this->getComOgone()."Com Ogone<br/>";
//        echo $this->getComEvoPayments()."Com Evo Payments<br/>";
//        echo $this->getJuro()."Juro <br/>";
//                echo $this->getProcSepaCt()."Proc Sepa <br/>";
//                echo $this->getImpostoSeloValorBni()." Imposto Selo Valor Bni<br/>";

        return round(($this->getValParcelas() * $this->getComissaoPagarAderente() + self::CAPTURA) - (($this->getComOgone() + $this->getComEvoPayments() + $this->getJuro() + $this->getProcSepaCt() + $this->getImpostoSeloValorBni())
                ), self::NUM_CASAS_DECIMAIS);
    }

    function getPiiAcumulado() {
        return $this->piiAcumulado;
    }

    function getLucroParcela() {
        return round($this->getPiiParcial() * self::LUCRO_PARCELA, self::NUM_CASAS_DECIMAIS);
    }

    function getLucroBniEuropa() {
        return $this->getPiiParcial() * self::LUCRO_BNI;
    }

    function getValorTransferParcela() {
        //return round($this->getLucroParcela() * (1 + self::IVA), self::NUM_CASAS_DECIMAIS);
        return round($this->getLucroParcela() + $this->getComOgone(), self::NUM_CASAS_DECIMAIS);
    }

    function getIvaValorParcela() {
        return round((($this->getValParcelas() * $this->getComissaoPagarAderente() + self::CAPTURA) - ($this->getProcSepaCt() + $this->getJuro() + $this->getImpostoSeloValorBni() + $this->getLucroBniEuropa())) * self::IVA, self::NUM_CASAS_DECIMAIS);
    }

    function getValorTransfParcelaComIva() {
        return round($this->getValorTransferParcela() + $this->getIvaValorParcela(), self::NUM_CASAS_DECIMAIS);
    }

    function getValorTransfBni() {
        return round($this->getLucroBniEuropa() + $this->getJuro() + $this->getProcSepaCt(), self::NUM_CASAS_DECIMAIS);
    }

    function getImpostoSeloValorBni() {
        //return round($this->getValorTransfBni() * self::IMPOSTO_SELO, self::NUM_CASAS_DECIMAIS);
        return round(((self::LUCRO_BNI * self::IMPOSTO_SELO * (($this->getValParcelas() * $this->getComissaoPagarAderente() + self::CAPTURA) - ($this->getComOgone() + $this->getComEvoPayments() + $this->getJuro() + $this->getProcSepaCt()))) + (self::IMPOSTO_SELO * ($this->getJuro() + $this->getProcSepaCt()))) / ((self::LUCRO_BNI * self::IMPOSTO_SELO) + 1), self::NUM_CASAS_DECIMAIS);
    }

    function getValorTransfBniComImpostoSelo() {
        return round($this->getValorTransfBni() + $this->getImpostoSeloValorBni(), self::NUM_CASAS_DECIMAIS);
    }

    function getTaxaComissaoSujeitaIva() {
        return round($this->getValorComissaoSujeitaIva(), self::NUM_CASAS_DECIMAIS);
    }

    function getTaxaProcessamento() {
        return $this->getCustoCaptura();
    }

    function getIva() {
        return $this->getIvaTotal();
    }

    function getServicosFinanceiros() {
        //return round($this->getJuroAcumulado() + $this->getProcSepaCt(), self::NUM_CASAS_DECIMAIS);
        return $this->servicosFinanceiros;
    }

    function setValorCompra($valorCompra) {
        $this->valorCompra = $valorCompra;
    }

    function setNumeroPrestacoes($numeroPrestacoes) {
        $this->numeroPrestacoes = $numeroPrestacoes;
    }

    function setComissaoPagarAderente($comissaoPagarAderente) {
        $this->comissaoPagarAderente = $comissaoPagarAderente;
    }

    function setNumParcela($numParcela) {
        $this->numParcela = $numParcela;
    }

    function setValorComissaoPagarAderente($valorComissaoPagarAderente) {
        $this->valorComissaoPagarAderente = $valorComissaoPagarAderente;
    }

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

    function setValorTotalCobradoAderente($valorTotalCobradoAderente) {
        $this->valorTotalCobradoAderente = $valorTotalCobradoAderente;
    }

    function setValorFinanciadoAderente($valorFinanciadoAderente) {
        $this->valorFinanciadoAderente = $valorFinanciadoAderente;
    }

    function setValorPagoAderente($valorPagoAderente) {
        $this->valorPagoAderente = $valorPagoAderente;
    }

    function setValParcelas($valParcelas) {
        $this->valParcelas = $valParcelas;
    }

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
        return round($this->impSelo, self::NUM_CASAS_DECIMAIS);
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
//    function getDatePayment() {
//        //return $this->datePayment;
//
//        return ($this->datePayment == null) ? ' ' : $this->datePayment->format('Y-m-d');
//    }
//
//    function setDatePayment($datePayment) {
//        $this->datePayment = $datePayment;
//    }


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
        //return $this->dataPagamento->format('Y-m-d');
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
