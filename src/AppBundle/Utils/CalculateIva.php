<?php

namespace AppBundle\Utils;

use AppBundle\Entity\TpaymentsTaxaServico;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CalculateIva
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class CalculateIva {

    private $comissaoCliente;
    private $juro;
    private $installment;
    private $valorParcelas; 
    private $impostoSeloBNIE;
    private $iteracoes;

//    public function __construct($juro, $impostoSeloBNIE, $installment, $valorParcelas, $comissaoPagarClienteFinal, $numeroPrestacoes) {
//        $this->CalculateIva($juro, $impostoSeloBNIE, $installment, $valorParcelas, $comissaoPagarClienteFinal, $numeroPrestacoes);
//    }
//    
    
    
    
     public function __construct($juro, $impostoSeloBNIE, $installment, $valorParcelas, $comissaoPagarClienteFinal, $numeroPrestacoes) {
        $this->juro = $juro;
        $this->impostoSeloBNIE = $impostoSeloBNIE;
        $this->installment = $installment;
        $this->valorParcelas = $valorParcelas;
        $this->comissaoCliente = $comissaoPagarClienteFinal / $numeroPrestacoes;
        
        $this->iteracoes = 0;
    }
    
    
    

    public function calculate() {
        return $this->calculateIvaParcelaJa();
    }

    private function calculateMargem() {
        // formula do excel
        // ( ($C$19 / $C$18) - (E39 + E40 + E46 + E49 + E64 + E60) ) / (1 +$C$10 * 0)

        $iva = $this->calculateIvaParcelaJa();
        $parte2 = Constantes::COMISSAO_OGONE + Constantes::COMISSAO_EVO($this->valorParcelas) + $this->juro + Constantes::PROC_SEPA_CT($this->installment) + $iva + $this->impostoSeloBNIE;
        $margem = (($this->comissaoCliente - $parte2) / (1 + Constantes::IVA * 0));
       
//        dump("parte2 IVA = " . $parte2);
//        dump("iva margem = " . $margem );
        
        return $margem;
    }

    private function calculateIvaParcelaJa() {
        // formula do excel (IVA VALOR PARCELA)
        // ( ( ($C$19 /$C$18) - (F49 + F46 + F64 + F57) ) / (1 +$C$10) ) * $C$10

        if ($this->iteracoes <= 10) {
            $this->iteracoes++;
            $lucro = $this->calculateMargem() * Constantes::PERCENTAGEM_LUCRO_BNIE;
            $parte2 = Constantes::PROC_SEPA_CT($this->installment) + $this->juro + $this->impostoSeloBNIE + $lucro;
            $iva = (($this->comissaoCliente - $parte2) / (1 + Constantes::IVA)) * Constantes::IVA;

//            dump("parte2 IVA = " . $parte2);
//            dump("iva = " . $iva);
            
            return $iva;
        } else {
            return 0;
        }
    }

}
