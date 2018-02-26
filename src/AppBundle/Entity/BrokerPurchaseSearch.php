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

class BrokerPurchaseSearch {

    //put your code here


    protected $startDate;
    protected $endDate;
    protected $brokerId;
    
    function getStartDate() {
        return $this->startDate;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    
    function getBrokerId() {
        return $this->brokerId;
    }

    function setBrokerId($brokerId) {
        $this->brokerId = $brokerId;
    }


    
    
    
}
