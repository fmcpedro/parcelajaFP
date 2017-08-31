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
    const NUM_CASAS_DECIMAIS = 3;
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


    function __construct($valorCompra, $numeroPrestacoes, $numParcela, $comissaoPagarClienteFinal, $tipoTransacao) {
        $this->valorCompra = $valorCompra;
        $this->numeroPrestacoes = $numeroPrestacoes;
        $this->numParcela = $numParcela;
        $this->comissaoPagarClienteFinal = $comissaoPagarClienteFinal;
        $this->tipoTransacao = $tipoTransacao;
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
//        return round($this->getValorCompra() * $this->getComissaoPagarAderente(), self::NUM_CASAS_DECIMAIS);
//    }

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

//    function getValorTotalCobradoAderente() {
//        return round($this->getValorComissaoPagarAderente() + $this->getCustoCaptura() + $this->getIvaTotal(), self::NUM_CASAS_DECIMAIS);
//    }

    function getValorFinanciadoAderente() {
        //return round($this->getValorCompra() - $this->getValorComissaoPagarAderente() - $this->getCustoCaptura(), self::NUM_CASAS_DECIMAIS);
        return $this->getValorCompra();
    }

    function getValorPagoAderente() {
        //return round($this->getValorCompra() - $this->getValorComissaoPagarAderente() - $this->getCustoCaptura() - $this->getIvaTotal(), self::NUM_CASAS_DECIMAIS);
        return $this->getValorCompra();
    }

//    function getValParcelas() {
//        return round($this->getValorCompra() / $this->getNumeroPrestacoes(), self::NUM_CASAS_DECIMAIS);
//    }

    function getComOgone() {
        return round(self::OGONE, self::NUM_CASAS_DECIMAIS);
    }

    function getComEvoPayments() {
        return round($this->getValParcelasEmissor() * self::EVO_PAYMENTS, self::NUM_CASAS_DECIMAIS);
    }

    function getValorReceberEvoPayments() {
        return round($this->getValParcelasEmissor() - $this->getComEvoPayments(), self::NUM_CASAS_DECIMAIS);
    }

    function getCapitalAmortizadoMensalmente() {
        return round($this->getValorFinanciadoAderente() / $this->getNumeroPrestacoes(), self::NUM_CASAS_DECIMAIS);
    }

    function getCapitalAmortizadoAcumulado() {
        //somatorio, calculado fora
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

    function getPiiAcumulado() {
        return round($this->piiAcumulado, self::NUM_CASAS_DECIMAIS);
        ;
    }

    function getLucroParcela() {
        return round($this->getPiiParcial() * self::LUCRO_PARCELA, self::NUM_CASAS_DECIMAIS);
    }

    function getLucroBniEuropa() {
        return round($this->getPiiParcial() * self::LUCRO_BNI, self::NUM_CASAS_DECIMAIS);
        ;
    }

    function getValorTransferParcela() {
        return round($this->getLucroParcela() + $this->getComOgone(), self::NUM_CASAS_DECIMAIS);
    }

    function getValorTransfParcelaComIva() {
        return round($this->getValorTransferParcela() + $this->getIvaValorParcela(), self::NUM_CASAS_DECIMAIS);
    }

    //referencia circular
    function getValorTransfBni() {
        return round($this->getLucroBniEuropa() + $this->getJuro() + $this->getProcSepaCt(), self::NUM_CASAS_DECIMAIS);
    }

    //referencia circular
    function getImpostoSeloValorBni() {
        //return round($this->getValorTransfBni() * self::IMPOSTO_SELO, self::NUM_CASAS_DECIMAIS);

        return round($this->impostoSeloValorBni, self::NUM_CASAS_DECIMAIS);
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
        $this->impSelo = round($impSelo, self::NUM_CASAS_DECIMAIS);
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
        return round(($this->getValorCompra() + $this->getComissaoPagarClienteFinal()) / $this->getNumeroPrestacoes(), self::NUM_CASAS_DECIMAIS);
    }

    function setValParcelasEmissor($valParcelasEmissor) {
        $this->valParcelasEmissor = $valParcelasEmissor;
    }

    function getIvaValorParcela() {
        return round($this->ivaValorParcela, self::NUM_CASAS_DECIMAIS);
    }

    //referencia circular
    function getPiiParcial() {
        //(($C$19/$C$18)-(E39+E40+E46+E49+E64+E60))/(1+$C$10*0)
        return round((($this->getComissaoPagarClienteFinal() / $this->getNumeroPrestacoes()) - ($this->getComOgone() + $this->getComEvoPayments() + $this->getJuro() + $this->getProcSepaCt() + $this->getImpostoSeloValorBni() + $this->getIvaValorParcela())) / (1 + self::IVA * 0), self::NUM_CASAS_DECIMAIS);
    }
    
    
    
    function getTipoTransacao() {
        return $this->tipoTransacao;
    }

    function setTipoTransacao($tipoTransacao) {
        $this->tipoTransacao = $tipoTransacao;
    }


    
    

}
