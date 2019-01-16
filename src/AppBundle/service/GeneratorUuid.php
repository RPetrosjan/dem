<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 24/12/2018
 * Time: 02:01
 */

namespace AppBundle\service;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

/**
 * Class GeneratorUuid
 * @package AppBundle\service
 */
class GeneratorUuid extends AbstractIdGenerator
{

    /**
     * {@inheritDoc}
     */
    public function generate(EntityManager $em, $entity)
    {
        dump(date('ymd'));
        exit();
        return date('ymd');
    }
}