<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 17/02/2019
 * Time: 05:42
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param integer $userId
     * @return null|object
     */
    public function getUserInfo($userId) {
        return $this->find($userId);
    }
}