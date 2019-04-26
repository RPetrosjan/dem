<?php

namespace AppBundle\Repository;

/**
 * CalculDevisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CalculDevisRepository extends \Doctrine\ORM\EntityRepository
{
    public function getcpville($getcp){
        $query = $this->createQueryBuilder('cp')
            ->select('cp.cp, cp.ville')
            ->where('cp.cp LIKE :getcp')
            ->setParameter('getcp','%'.$getcp.'%');
        ;

        return $query;
    }
}