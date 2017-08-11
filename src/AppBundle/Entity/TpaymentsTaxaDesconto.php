<?php

namespace AppBundle\Entity;

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

    function __construct($valorCompra, $numeroPrestacoes, $numParcela) {
        $this->valorCompra = $valorCompra;
        $this->numeroPrestacoes = $numeroPrestacoes;
        $this->numParcela = $numParcela;
        $this->comissaoPagarAderente = ((($numeroPrestacoes / 2) + 0.5) / 100);
        
        
        //$this->lucroBniEuropa = $this->getPiiParcial() * self::LUCRO_BNI;
        
        
        



//        $this->setValorComissaoPagarAderente();
//        $this->setValorComissaoSujeitaIva(); // !!!!!! tem um somatório
//        $this->setIvaComissao();
//
//        $this->setCustoCaptura();
//        $this->setIvaCustoCaptura();
//        $this->setIvaTotal();
//
//        $this->setValorTotalCobradoAderente();
//        $this->setValorFinanciadoAderente();
//
//        $this->setValorPagoAderente();
//
//        $this->setValParcelas();
//        $this->setComOgone(); // é uma constante
//        $this->setComEvoPayments();
//
//        $this->setValorReceberEvoPayments();
//
//        $this->setCapitalAmortizadoMensalmente();
        //$this->setCapitalAmortizadoAcumulado(0); // calculado fora
//        $this->setCapitalEmDivida();
//        $this->setJuro(); //calculado fora
        //$this->setJuroAcumulado(0); // calculado fora
        //$this->setImpostoSelo();
        //$this->setImpostoSeloAcumulado(0); // calculado fora
        //$this->setPiiParcial();
        //$this->setPiiAcumulado(0); // calculado fora
        //$this->setLucroParcela();
        //$this->setLucroBniEuropa();
        //$this->setValorTransferParcela();
//        $this->setTaxaComissaoSujeitaIva();
//        $this->setTaxaProcessamento();
//        $this->setIva();
//        $this->setServicosFinanceiros();
//        $this->setImpSelo();
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
            return 39.18; //tem um somatório
        
        //return $this->valorComissaoSujeitaIva;
    }

    function getIvaComissao() {
        return round($this->getValorComissaoSujeitaIva() * self::IVA, self::NUM_CASAS_DECIMAIS);
    }

    function getCustoCaptura() {
        return round($this->getNumeroPrestacoes() * self::CUSTO_CAPTURA, self::NUM_CASAS_DECIMAIS);
    }

    function getIvaCustoCaptura() {
        return round($this->getCustoCaptura() * self::IVA, self::NUM_CASAS_DECIMAIS);;
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
        //return $this->getCapitalEmDivida() * (self::TAXA_JURO / $this->getNumeroPrestacoes());
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
        return round(($this->getValParcelas() * $this->getComissaoPagarAderente() + self::CAPTURA) 
        - (self::OGONE + self::EVO_PAYMENTS + $this->getJuro() + $this->getProcSepaCt() + $this->getImpostoSeloValorBni()
                ), self::NUM_CASAS_DECIMAIS);

        //return ($this->getValParcelas()*$this->getValorComissaoPagarAderente())+self::CAPTURA;
        
        
        
    }

    function getPiiAcumulado() {
        return $this->piiAcumulado;
    }

    function getLucroParcela() {
        return round($this->getPiiParcial() * self::LUCRO_PARCELA, self::NUM_CASAS_DECIMAIS);
    }

    function getLucroBniEuropa() {
//        return ($this->getValParcelas() * $this->getComissaoPagarAderente() + self::CAPTURA) 
//        - (self::OGONE + self::EVO_PAYMENTS + $this->getJuro() + $this->getProcSepaCt() + (($this->getLucroBniEuropa() + $this->getJuro() + $this->getProcSepaCt()) * self::IMPOSTO_SELO)
//                ) * self::LUCRO_BNI;
//        
//return $this->lucroBniEuropa;
        
        return 1.52;
        
    }

    function getValorTransferParcela() {
        return round($this->getLucroParcela() * (1 + self::IVA), self::NUM_CASAS_DECIMAIS);
    }

    function getIvaValorParcela() {
        return round((($this->getValParcelas() * $this->getComissaoPagarAderente() + self::CAPTURA) 
                - ($this->getProcSepaCt() + $this->getJuro() + $this->getImpostoSeloValorBni() + $this->getLucroBniEuropa())) * self::IVA, self::NUM_CASAS_DECIMAIS);
    }

    function getValorTransfParcelaComIva() {
        return round($this->getValorTransferParcela() + $this->getIvaValorParcela(), self::NUM_CASAS_DECIMAIS);
    }

    function getValorTransfBni() {
        return round($this->getLucroBniEuropa() + $this->getJuro() + $this->getProcSepaCt(), self::NUM_CASAS_DECIMAIS);
    }

    function getImpostoSeloValorBni() {
        return round($this->getValorTransfBni() * self::IMPOSTO_SELO, self::NUM_CASAS_DECIMAIS);
        
    }

    function getValorTransfBniComImpostoSelo() {
        return round($this->getValorTransfBni() + $this->getImpostoSeloValorBni(), self::NUM_CASAS_DECIMAIS);
    }

    function getTaxaComissaoSujeitaIva() {
        return $this->getValorComissaoSujeitaIva();
    }

    function getTaxaProcessamento() {
        return self::CUSTO_CAPTURA;
    }

    function getIva() {
        return $this->getIvaTotal();
    }

    function getServicosFinanceiros() {
        return round($this->getJuroAcumulado() + $this->getProcSepaCt(), self::NUM_CASAS_DECIMAIS);
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
        $this->taxaProcessamento = $taxaProcessamento;
    }

    function setIva($iva) {
        $this->iva = $iva;
    }

    function setServicosFinanceiros($servicosFinanceiros) {
        $this->servicosFinanceiros = $servicosFinanceiros;
    }

    function getImpSelo() {
        return $this->getImpostoSeloAcumulado();
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

}
