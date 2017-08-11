<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TpaymentsSimulator
 *
 * @author luis
 */


namespace AppBundle\Entity;

class TpaymentsSimulator {
    //put your code here
    
    protected $valorCompra;
    protected $numeroParcelas;
    protected $taxa;
    
    function getValorCompra() {
        return $this->valorCompra;
    }

    function getNumeroParcelas() {
        return $this->numeroParcelas;
    }

    function setValorCompra($valorCompra) {
        $this->valorCompra = $valorCompra;
    }

    function setNumeroParcelas($numeroParcelas) {
        $this->numeroParcelas = $numeroParcelas;
    }

    function getTaxa() {
        return $this->taxa;
    }

    function setTaxa($taxa) {
        $this->taxa = $taxa;
    }


}
