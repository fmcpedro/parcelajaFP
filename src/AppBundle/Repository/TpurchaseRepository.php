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
    
    
    //SELECT SUM(value_evo_payments) AS total, year(date) as year, month(date) as month FROM payment_forecasts GROUP BY year, month ORDER BY year, month;
      
    public function findPaymentForecastsByMonth($startDate, $endDate) {
        $em = $this->getEntityManager();

        $query = $em->createQuery('SELECT SUM(p.valueEvoPayments) AS total, year(p.date) as year, month(p.date) as month '
                . 'FROM AppBundle:PaymentForecasts p '
                . 'WHERE p.date > ?1 AND p.date < ?2 '
                . 'GROUP BY year, month '
                . 'ORDER BY year, month');
        
        $query->setParameter(1,$startDate );
        $query->setParameter(2,$endDate );

        return $query->getResult();
    }
    
    
    
    
    
    //SELECT SUM(value_evo_payments) AS total, CONCAT(date, ' - ', date + INTERVAL 6 DAY) AS week FROM payment_forecasts GROUP BY WEEK(date) ORDER BY WEEK(date)

    /**
     * 
     * @return type
     */
    public function findPaymentForecastsByWeek($startDate, $endDate) {
        $em = $this->getEntityManager();

        $query = $em->createQuery('SELECT SUM(p.valueEvoPayments) AS total, WEEK(p.date) as week, year(p.date) as year '
                . 'FROM AppBundle:PaymentForecasts p '
                . 'WHERE p.date > ?1 AND p.date < ?2 '
                . 'GROUP BY year, week '
                . 'ORDER BY year, week ');
        
        $query->setParameter(1,$startDate );
        $query->setParameter(2,$endDate );

        dump($query->getResult());
        
        return $query->getResult();
    }

}
