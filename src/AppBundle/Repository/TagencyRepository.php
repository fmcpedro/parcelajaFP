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
class TagencyRepository extends EntityRepository {
    //put your code here

    /**
     * 
     * @param type $params
     * @return type
     */
    public function findAggregatePurchasesByAgency($search) {


        dump($search);

        $em = $this->getEntityManager();

        //CRIAR A QUERY
        $sql = 'SELECT IDENTITY(p.agency) AS id, '
                . 'a.fagencyname AS name, '
                . 'a.fstate as status, '
                . 'a.fcontactperson as contact, '
                . 'a.fiban as iban, '
                . 'SUM(p.ftotpurchasevalue) AS total '
                . 'FROM AppBundle:Tpurchase p join AppBundle:Tagency a WITH p.agency=a.fagencyid ';

        if (array_key_exists('subgroupId', $search)) {
            $sql .= 'join AppBundle:Tsubgroup s WITH a.subgroup = s.fsubgroupid ';
        }

        if (array_key_exists('groupId', $search)) {
            $sql .= 'join AppBundle:Tgroup g WITH s.fgroupid = g.fgroupid ';
        }


        $sql .= 'WHERE 1 = 1 ';


        if (array_key_exists('status', $search)) {
            $sql .= 'AND a.fstate = ?1 ';
        }
        if (array_key_exists('agencyId', $search)) {
            $sql .= 'AND a.fagencyid = ?2 ';
        }
        if (array_key_exists('subgroupId', $search)) {
            $sql .= 'AND s.fsubgroupid = ?3 ';
        }
        if (array_key_exists('groupId', $search)) {
            $sql .= 'AND g.fgroupid = ?4 ';
        }
        if (array_key_exists('numFiscal', $search)) {
            $sql .= 'AND a.ftaxidnumber = ?5 ';
        }
        if (array_key_exists('nomeFiscal', $search)) {
            $sql .= 'AND a.ffiscalname LIKE ?6 ';
        }

        $sql .= 'GROUP BY p.agency';

        $query = $em->createQuery($sql);

        if (array_key_exists('status', $search)) {
            $query->setParameter(1, $search['status']);
        }
        if (array_key_exists('agencyId', $search)) {
            $query->setParameter(2, $search['agencyId']);
        }
        if (array_key_exists('subgroupId', $search)) {
            $query->setParameter(3, $search['subgroupId']);
        }
        if (array_key_exists('groupId', $search)) {
            $query->setParameter(4, $search['groupId']);
        }
        if (array_key_exists('numFiscal', $search)) {
            $query->setParameter(5, $search['numFiscal']);
        }
        if (array_key_exists('nomeFiscal', $search)) {
            $query->setParameter(6, '%' . $search['nomeFiscal'] . '%');
        }


        dump($query->getDQL());
        dump($query->getAST());

        return $query->getResult();
    }

}
