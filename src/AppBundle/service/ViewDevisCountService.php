<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 27/03/2019
 * Time: 01:16
 */

namespace AppBundle\service;


use AppBundle\Entity\User;
use AppBundle\Entity\ViewDevisCount;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class viewDevisCountService
 * @package AppBundle\service
 */
class ViewDevisCountService
{

    /** @var EntityManagerInterface  */
    private $em;

   /** @var TokenStorage  */
    private $token;

    /** @var string  */
    private $ip;

    /**
     * ExceptionListener constructor.
     * @param EntityManagerInterface $em
     * @param TokenStorage $token
     * @param Container $container
     * @throws \Exception
     */
    public function __construct(EntityManagerInterface  $em, TokenStorage $token, Container $container) {

        $this->em = $em;
        $this->token = $token;
        if(!is_null($container->get('request_stack')->getCurrentRequest())) {
            $this->ip = $container->get('request_stack')->getCurrentRequest()->getClientIp();
        }
    }

    /**
     * Add DateTime for login Devis Count
     * @param User|null $user
     */
    public function addCreateDateDevisCount(User $user = null) {

        if(is_null($user)) {
            $user = $this->token->getToken()->getUser();
        }

        $viewDevisCount = new ViewDevisCount();
        $viewDevisCount->setUserId($user);
        $this->em->persist($viewDevisCount);
        $this->em->flush();
    }

    /**
     * @param int $count
     * @param User|null $user
     * @return string
     */
    public function addDevisCount(int $count, User $user = null) {

        if(is_null($user)) {
            $user = $this->token->getToken()->getUser();
        }

        $user->setViewDevisCount($user->getViewDevisCount() + $count);

        $this->em->persist($user);
        $this->em->flush();

        return $user->getViewDevisCount();
    }
}