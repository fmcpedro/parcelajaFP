<?php

namespace AppBundle\Utils;

use AppBundle\Entity\TpaymentsTaxaServico;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CalculateImpostoSeloBNIE
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class CalculateImpostoSeloBNIE {

    private $comissaoCliente;
    private $juro;
    private $iva;
    private $iteracoes;

    function __construct($juro, $iva, $comissaoPagarClienteFinal, $numeroPrestacoes) {

        $this->calculateImpostoSeloBNIE($juro, $iva, $comissaoPagarClienteFinal, $numeroPrestacoes);
        //$this->calculateImpostoSeloBNIE($juro, 0, $comissaoPagarClienteFinal, $numeroPrestacoes);
        
        //nota: segunda feira: chamar metodo de baixo. é o que está mal
        
    }

    public function calculateImpostoSeloBNIE($juro, $iva, $comissaoPagarClienteFinal, $numeroPrestacoes) {
        $this->juro = $juro;
        $this->iva = $iva;
        $this->comissaoCliente = $comissaoPagarClienteFinal / $numeroPrestacoes;

        $this->iteracoes = 0;

        
    }

    public function calculate($comOgone, $comEvoPayments, $procSepaCt) {
        return $this->calculateImpostoSelo($comOgone, $comEvoPayments, $procSepaCt);
    }

    private function calculateMargem($comOgone, $comEvoPayments, $procSepaCt) {
        // formula do excel
        // ( ($C$19 / $C$18) - (E39 + E40 + E46 + E49 + E64 + E60) ) / (1 +$C$10 * 0)

        $impostoSeloBNIE = $this->calculateImpostoSelo($comOgone, $comEvoPayments, $procSepaCt);
        $parte2 = $comOgone + $comEvoPayments + $this->juro + $procSepaCt + $this->iva + $impostoSeloBNIE;
        $margem = (($this->comissaoCliente - $parte2) / (1 + TpaymentsTaxaServico::IVA * 0));

        return $margem;
    }

    private function calculateImpostoSelo($comOgone, $comEvoPayments, $procSepaCt) {
        // formula do excel (IS VALOR BNI)
        // ( E57+E46+E49 ) * $C$9

        if ($this->iteracoes <= 1) {
            $this->iteracoes++;
            $lucro = $this->calculateMargem($comOgone, $comEvoPayments, $procSepaCt) * TpaymentsTaxaServico::LUCRO_BNI;
            $impostoSeloBNIE = ($lucro + $procSepaCt + $this->juro) * TpaymentsTaxaServico::IMPOSTO_SELO;

            return $impostoSeloBNIE;
        } else {
            return 0;
        }
    }

}
