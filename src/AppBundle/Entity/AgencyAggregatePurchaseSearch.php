<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of AgencyAggregatePurchase
 *
 * @author Luis Miguens <lmiguens@consolidador.com>
 */
class AgencyAggregatePurchaseSearch {
    //put your code here
    
    
      protected $groupId;
      protected $subgroupId;
    protected $agencyId;
    protected $status;
    protected $numFiscal;
    protected $nomeFiscal;

    
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

    function getNumFiscal() {
        return $this->numFiscal;
    }

    function getNomeFiscal() {
        return $this->nomeFiscal;
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

    function setNumFiscal($numFiscal) {
        $this->numFiscal = $numFiscal;
    }

    function setNomeFiscal($nomeFiscal) {
        $this->nomeFiscal = $nomeFiscal;
    }


    
    
}
