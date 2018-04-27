<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GroupRepository
 *
 * @author luis miguens
 */
class TpurchaseRepository extends EntityRepository {

    /**
     * 
     * @param type $params
     * @return type
     */
    public function findPurchasesByBroker($params) {


        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')->from('AppBundle:Tpurchase', 'p');

        
        if (array_key_exists('brokerId', $params)) {
            $qb->join('p.agency', 'a', 'WITH', 'p.agency= a.fagencyid');
            $qb->join('a.broker', 'b', 'WITH', 'b.id= a.broker');

            $qb->andWhere('b.id = ?1');
            $qb->setParameter(1, $params['brokerId']);
        }



        if (array_key_exists('startDate', $params)) {
            $qb->andWhere('p.fpurchasedate > ?2');
            $qb->setParameter(2, $params['startDate']);
        }

        if (array_key_exists('endDate', $params)) {
            $qb->andWhere('p.fpurchasedate < ?3');
            $qb->setParameter(3, $params['endDate']);
        }

        $qb->orderBy('p.fpurchasedate', 'desc');
        return $qb->getQuery()->getResult();
    }
    
    //FP
    public function findPurchaseByFilter($params){
        
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')->from('AppBundle:Tpurchase', 'p');
            $qb->join('p.agency', 'a', 'WITH', 'p.agency=a.fagencyid');
            $qb->join('a.subgroup', 's', 'WITH', 'a.subgroup=s.fsubgroupid');  
            $qb->join('s.group','g', 'WITH', 's.group = g.fgroupid');

            
        if (array_key_exists('agencyId', $params)) {  
           $qb->andWhere('a.fagencyid = ?1');
           $qb->setParameter(1, $params['agencyId']);
        }
        

        if (array_key_exists('subgroupId', $params)) {      
           $qb->andWhere('s.fsubgroupid = ?2');
           $qb->setParameter(2, $params['subgroupId']);
        }
          
        
        
        if (array_key_exists('groupId', $params)) {  
           $qb->andWhere('g.fgroupid = ?3');
           $qb->setParameter(3, $params['groupId']); 
        }

        
        if (array_key_exists('contractNumber', $params)) {
            $qb->andWhere('p.fcontractnumber = ?4');
            $qb->setParameter(4, $params['contractNumber']);
        }

        
        if (array_key_exists('startDate', $params)) {
            $qb->andWhere('p.fpurchasedate > ?5');
            $qb->setParameter(5, $params['startDate']);
        }

        if (array_key_exists('endDate', $params)) {
            $qb->andWhere('p.fpurchasedate < ?6');
            $qb->setParameter(6, $params['endDate']);
        }
        
        
        
        if (array_key_exists('status', $params)) {
            $qb->andWhere('p.fstatus = ?7');
            $qb->setParameter(7, $params['status']);
        }

        $qb->orderBy('p.fpurchasedate', 'desc');
            
      return $qb->getQuery()->getResult();
    }
    

    /**
     * 
     * @param type $params
     * @return type
     */
    public function findByFilter($params) {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')->from('AppBundle:Tpurchase', 'p');

        $qb->andWhere('p.fcalcamount >= ?1');
        $qb->setParameter(1, 20);

        if (array_key_exists('agency', $params)) {
            $qb->andWhere('p.agency = ?2');
            $qb->setParameter(2, $params['agency']);
        }

        if (array_key_exists('fcontractnumber', $params)) {
            $qb->andWhere('p.fcontractnumber = ?3');
            $qb->setParameter(3, $params['fcontractnumber']);
        }

        if (array_key_exists('fstatus', $params)) {
            $qb->andWhere('p.fstatus = ?4');
            $qb->setParameter(4, $params['fstatus']);
        }

        if (array_key_exists('fpurchasedate', $params)) {
            $qb->andWhere('p.fpurchasedate >= ?5');
            $qb->setParameter(5, $params['fpurchasedate']);
        }

        $qb->orderBy('p.fpurchasedate', 'desc');


        return $qb->getQuery()->getResult();
    }

    /**
     * 
     * @param type $params
     * @return type
     */
    public function findPurchasesForPaymentForecasts() {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')->from('AppBundle:Tpurchase', 'p');

        $qb->andWhere('p.fcalcamount >= ?1');
        $qb->setParameter(1, 20);
        $qb->andWhere('p.fstatus = ?2');
        $qb->setParameter(2, 1);

        //$qb->orderBy('p.fpurchasedate', 'desc');


        return $qb->getQuery()->getResult();
    }

    /**
     * 
     * @return type
     */
    //SELECT SUM(value_evo_payments) AS total, year(date) as year, month(date) as month 
    //FROM payment_forecasts 
    //WHERE date >= '2018-01-01' AND date < '2018-06-01'
    //GROUP BY year, month 
    //ORDER BY year, month;

    public function findPaymentForecastsByMonth($search) {
        $em = $this->getEntityManager();

        $sql = 'SELECT SUM(p.valueEvoPayments) AS total, year(p.date) as year, month(p.date) as month '
                . 'FROM AppBundle:PaymentForecasts p '
                . 'WHERE p.date >= ?1 AND p.date < ?2 ';

        //CAMPOS OPCIONAIS DA QUERY
        if (array_key_exists('agencyId', $search)) {
            $sql .= 'AND p.agencyId = ?3 ';
        }
        if (array_key_exists('subgroupId', $search)) {
            $sql .= 'AND p.subgroupId = ?4 ';
        }
        if (array_key_exists('groupId', $search)) {
            $sql .= 'AND p.groupId = ?5 ';
        }
        $sql .= 'GROUP BY year, month '
                . 'ORDER BY year, month ';

        $query = $em->createQuery($sql);
        $query->setParameter(1, $search['startDate']);
        $query->setParameter(2, $search['endDate']);

        if (array_key_exists('agencyId', $search)) {
            $query->setParameter(3, $search['agencyId']);
        }
        if (array_key_exists('subgroupId', $search)) {
            $query->setParameter(4, $search['subgroupId']);
        }
        if (array_key_exists('groupId', $search)) {
            $query->setParameter(5, $search['groupId']);
        }

        return $query->getResult();
    }

    //SELECT SUM(value_evo_payments) AS total, CONCAT(date, ' - ', date + INTERVAL 6 DAY) AS week FROM payment_forecasts GROUP BY WEEK(date) ORDER BY WEEK(date)

    /**
     * 
     * @return type
     */
    public function findPaymentForecastsByWeek($search) {
        $em = $this->getEntityManager();

        //CRIAR A QUERY
        $sql = 'SELECT SUM(p.valueEvoPayments) AS total, WEEK(p.date, 3) as week, year(p.date) as year '
                . 'FROM AppBundle:PaymentForecasts p '
                . 'WHERE p.date >= ?1 AND p.date < ?2 ';

        //CAMPOS OPCIONAIS DA QUERY
        if (array_key_exists('agencyId', $search)) {
            $sql .= 'AND p.agencyId = ?3 ';
        }
        if (array_key_exists('subgroupId', $search)) {
            $sql .= 'AND p.subgroupId = ?4 ';
        }
        if (array_key_exists('groupId', $search)) {
            $sql .= 'AND p.groupId = ?5 ';
        }
        $sql .= 'GROUP BY year, week '
                . 'ORDER BY year, week ';


        $query = $em->createQuery($sql);
        $query->setParameter(1, $search['startDate']);
        $query->setParameter(2, $search['endDate']);

        if (array_key_exists('agencyId', $search)) {
            $query->setParameter(3, $search['agencyId']);
        }
        if (array_key_exists('subgroupId', $search)) {
            $query->setParameter(4, $search['subgroupId']);
        }
        if (array_key_exists('groupId', $search)) {
            $query->setParameter(5, $search['groupId']);
        }

        return $query->getResult();
    }

}
