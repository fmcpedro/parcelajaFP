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
    private $impostoSeloBNIE;
    private $iteracoes;

//        public function calculateIva($juro){
//            $this->juro = $juro;
//        
//        }

    function __construct($juro, $impostoSeloBNIE, $comissaoPagarClienteFinal, $numeroPrestacoes) {
        
        $this->calculateIva($juro, $impostoSeloBNIE, $comissaoPagarClienteFinal, $numeroPrestacoes);
        
        
        
                //nota: segunda feira: chamar metodo de baixo. é o que está mal
    }

    public function calculateIva($juro, $impostoSeloBNIE, $comissaoPagarClienteFinal, $numeroPrestacoes) {
        $this->juro = $juro;
        $this->impostoSeloBNIE = $impostoSeloBNIE;
        $this->comissaoCliente = $comissaoPagarClienteFinal / $numeroPrestacoes;
        
        $this->iteracoes = 0;
    }

    public function calculate($comOgone, $comEvoPayments, $procSepaCt) {
        return $this->calculateIvaParcelaJa($comOgone, $comEvoPayments, $procSepaCt);
    }

    private function calculateMargem($comOgone, $comEvoPayments, $procSepaCt) {
        // formula do excel
        // ( ($C$19 / $C$18) - (E39 + E40 + E46 + E49 + E64 + E60) ) / (1 +$C$10 * 0)

        $iva = $this->calculateIvaParcelaJa($comOgone, $comEvoPayments, $procSepaCt);
        $parte2 = $comOgone + $comEvoPayments + $this->juro + $procSepaCt + $iva + $this->impostoSeloBNIE;
        $margem = (($this->comissaoCliente - $parte2) / (1 + TpaymentsTaxaServico::IVA * 0));
       
        
        return $margem;
    }

    private function calculateIvaParcelaJa($comOgone, $comEvoPayments, $procSepaCt) {
        // formula do excel (IVA VALOR PARCELA)
        // ( ( ($C$19 /$C$18) - (F49 + F46 + F64 + F57) ) / (1 +$C$10) ) * $C$10

        if ($this->iteracoes <= 1) {
            $this->iteracoes++;
            $lucro = $this->calculateMargem($comOgone, $comEvoPayments, $procSepaCt) * TpaymentsTaxaServico::LUCRO_BNI;
            $parte2 = $procSepaCt + $this->juro + $this->impostoSeloBNIE + $lucro;
            $iva = (($this->comissaoCliente - $parte2) / (1 + TpaymentsTaxaServico::IVA)) * TpaymentsTaxaServico::IVA;

            return $iva;
        } else {
            return 0;
        }
    }

}
