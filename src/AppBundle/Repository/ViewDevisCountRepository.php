<?php

namespace AppBundle\Repository;

use DateTime;

/**
 * ViewDevisCountRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ViewDevisCountRepository extends \Doctrine\ORM\EntityRepository
{
    public function ifAddTodayCount($user){
        $dateStart = (new DateTime())->setTime(0,0, 0);
       /// $dateFin   = (new DateTime())->setTime(12,59,59);

        return $this->createQueryBuilder('db')
            ->where('db.user_id = :user_id')
            ->andWhere('db.CreatedDate >= :dateStart')
            ///      ->andWhere('db.CreatedDate <= :dateFin')
            ->setParameters([
                'user_id'   => $user,
                'dateStart' => $dateStart,
                ///       'dateFin'   => $dateFin
            ])
            ->getQuery()
            ->execute()
            ;
    }
}
