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
 * @author luis
 */
class TpurchaseRepository extends EntityRepository {

    //put your code here



    public function findByFilter_old($params) {


        //1) ir buscar todas as compras com valor superiro a 20€
        $query = 'SELECT p FROM AppBundle:Tpurchase p WHERE p.fcalcamount > :fcalcamount '
        //. 'AND p.fpurchaseid > :fpurchaseid'
        ;
        $tpurchases = $em->createQuery($query)
                ->setParameter('fcalcamount', 20)
                //->setParameter('fpurchaseid', 202)
                ->getResult();
    }

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

}
