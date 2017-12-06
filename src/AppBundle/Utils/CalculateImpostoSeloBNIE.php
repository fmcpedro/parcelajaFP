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
    private $installment;
    private $valorParcelas;
    private $iva;
    private $iteracoes;

    public function __construct($juro, $iva, $installment, $valorParcelas, $comissaoPagarClienteFinal, $numeroPrestacoes) {
        $this->juro = $juro;
        $this->iva = $iva;
        $this->installment = $installment;
        $this->valorParcelas = $valorParcelas;

        $this->comissaoCliente = $comissaoPagarClienteFinal / $numeroPrestacoes;

        $this->iteracoes = 0;
                        
        //dump("juro = ". $juro."; iva = ". $iva. "; installment = ". $installment." ; valorParcelas = ". $valorParcelas."; comissaoPagarClienteFinal = ".$comissaoPagarClienteFinal."; numeroPrestacoes = ". $numeroPrestacoes);
        
        
        
        
    }

    public function calculate() {
        return $this->calculateImpostoSelo();
    }

    private function calculateMargem() {
        // formula do excel
        // ( ($C$19 / $C$18) - (E39 + E40 + E46 + E49 + E64 + E60) ) / (1 +$C$10 * 0)

        $impostoSeloBNIE = $this->calculateImpostoSelo();
        $parte2 = Constantes::COMISSAO_OGONE + Constantes::COMISSAO_EVO($this->valorParcelas) + $this->juro + Constantes::PROC_SEPA_CT($this->installment) + $this->iva + $impostoSeloBNIE;
        $margem = (($this->comissaoCliente - $parte2) / (1 + Constantes::IVA * 0));

//        dump("parte2 IE = " . $parte2);
//        dump("IS margem = " . $margem);
        
        return $margem;
    }

    private function calculateImpostoSelo() {
        // formula do excel (IS VALOR BNI)
        // ( E57+E46+E49 ) * $C$9

        if ($this->iteracoes <= 10) {
            $this->iteracoes++;
            $lucro = $this->calculateMargem() * Constantes::PERCENTAGEM_LUCRO_BNIE;
            $impostoSeloBNIE = ($lucro + Constantes::PROC_SEPA_CT($this->installment)  + $this->juro) * Constantes::PERCENTAGEM_IMPOSTO_SELO;

//            dump("lucro IE = " . $lucro);
//           dump("impostoSeloBNIE = " . $impostoSeloBNIE);
            
            return $impostoSeloBNIE;
        } else {
            return 0;
        }
    }

}
