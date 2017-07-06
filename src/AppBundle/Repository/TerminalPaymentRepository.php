<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TerminalPaymentREpository
 *
 * @author luis
 */
class TerminalPaymentRepository extends EntityRepository {

    //put your code here

    public function findByJoinTerminalAndAgency($params) {



        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('p')->from('AppBundle:TerminalPayment', 'p');


        if (array_key_exists('terminal', $params)) {
            $qb->andWhere('p.terminal = ?1');
            $qb->setParameter(1, $params['terminal']);
        }

        if (array_key_exists('year', $params)) {
            $qb->andWhere('p.year = ?2');
            $qb->setParameter(2, $params['year']);
        }

        if (array_key_exists('month', $params)) {
            $qb->andWhere('p.month = ?3');
            $qb->setParameter(3, $params['month']);
        }

        if (array_key_exists('value', $params)) {
            $qb->andWhere('p.value = ?4');
            $qb->setParameter(4, $params['value']);
        }






        if (array_key_exists('agency', $params)) {
            $qb->join('p.terminal', 't', 'WITH', 'p.terminal= t.fposid');
            $qb->join('t.agency', 'a', 'WITH', 'a.fagencyid = ?5');
            $qb->setParameter(5, $params['agency']);
        }

        if (array_key_exists('subGroup', $params)) {
            $qb->join('p.terminal', 't', 'WITH', 'p.terminal= t.fposid');
            $qb->join('t.agency', 'a', 'WITH', 't.agency = a.fagencyid');
            $qb->join('a.subgroup', 's', 'WITH', 's.fsubgroupid = ?6');
            $qb->setParameter(6, $params['subGroup']);
        }

        if (array_key_exists('group', $params)) {
            $qb->join('p.terminal', 't', 'WITH', 'p.terminal= t.fposid');
            $qb->join('t.agency', 'a', 'WITH', 't.agency = a.fagencyid');
            $qb->join('a.subgroup', 's', 'WITH', 'a.subgroup = s.fsubgroupid');
            $qb->join('s.group', 'g', 'WITH', 'g.fgroupid = ?7');

            $qb->setParameter(7, $params['group']);
        }


//        if ($order) {
//            $qb->orderBy('p.' . key($order), $order[key($order)]);
//        }
//
//        if ($offset) {
//            $qb->setFirstResult($offset);
//        }
//
//        $qb->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

}
