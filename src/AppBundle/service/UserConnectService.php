<?php

namespace AppBundle\service;


use AppBundle\Entity\UserConnect;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserConnectService
 * @package AppBundle\service
 */
class UserConnectService
{

    /** @var EntityManagerInterface  */
    private $em;

    /** String @var  */
    private $ip;

    /**
     * UserConnectService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, $ip)
    {
        $this->em = $em;
        $this->ip = $ip;
    }

    public function ifConnectToday($user) {
        $result = $this->em->getRepository(UserConnect::class)->getTodayConnection($user);
        return $result;
    }

    /**
     * @param $user
     * @return bool
     */
    public function addUserConnect($user) {

        /** @var  $userConnect */
        $userConnect = new UserConnect();
        $userConnect->setUserId($user);
        $userConnect->setIp($this->ip);
        $this->em->persist($userConnect);
        $this->em->flush();

        return true;
    }
}