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

class PaymentForecastsSearch {

    //put your code here


    protected $startDate;
    protected $endDate;
    protected $forecastsType;
    
    
     /**
     * @var integer
     */
    private $agencyId;
    
    
    /**
     * @var integer
     */
    private $subgroupId;
    

    
    /**
     * @var integer
     */
    private $groupId;

    function getStartDate() {
        return $this->startDate;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function getForecastsType() {
        return $this->forecastsType;
    }

    function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    function setForecastsType($forecastsType) {
        $this->forecastsType = $forecastsType;
    }
    
    function getAgencyId() {
        return $this->agencyId;
    }

    function getSubgroupId() {
        return $this->subgroupId;
    }

    function getGroupId() {
        return $this->groupId;
    }

    function setAgencyId($agencyId) {
        $this->agencyId = $agencyId;
    }

    function setSubgroupId($subgroupId) {
        $this->subgroupId = $subgroupId;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }



}
