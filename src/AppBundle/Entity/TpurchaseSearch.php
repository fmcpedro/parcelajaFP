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

class TpurchaseSearch {

    //put your code here


    protected $startDate;
    protected $endDate;
    protected $contractNumber;
    protected $groupId;
    protected $subgroupId;
    protected $agencyId;
    protected $status;
    
    
    function getStartDate() {
        return $this->startDate;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function getContractNumber() {
        return $this->contractNumber;
    }

    function getGroupId() {
        return $this->groupId;
    }

    function getSubgroupId() {
        return $this->subgroupId;
    }

    function getAgencyId() {
        return $this->agencyId;
    }

    function getStatus() {
        return $this->status;
    }

    function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    function setContractNumber($contractNumber) {
        $this->contractNumber = $contractNumber;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    function setSubgroupId($subgroupId) {
        $this->subgroupId = $subgroupId;
    }

    function setAgencyId($agencyId) {
        $this->agencyId = $agencyId;
    }

    function setStatus($status) {
        $this->status = $status;
    }



    
    
    
}
