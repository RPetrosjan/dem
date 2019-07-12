<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 26/03/2019
 * Time: 23:13
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\ViewDevisCount;
use AppBundle\service\ViewDevisCountService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Security;

/**
 * Class ExceptionListener
 * @package AppBundle\EventListener
 */
class ExceptionListener
{

    /** @var EntityManagerInterface  */
    private $em;

    /** @var Security  */
    private $token;

    /** @var Container  */
    private $container;

    /** @var ViewDevisCountService  */
    private $viewDevisCountService;

    /**
     * ExceptionListener constructor.
     * @param EntityManagerInterface $em
     * @param TokenStorage $token
     * @param Container $container
     * @param ViewDevisCountService $viewDevisCountService
     */
    public function __construct(EntityManagerInterface  $em, TokenStorage $token, Container $container, ViewDevisCountService $viewDevisCountService) {
        $this->em = $em;
        $this->token = $token;
        $this->container = $container;
        $this->viewDevisCountService = $viewDevisCountService;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     * @throws \Exception
     */
    public function onKernelRequest(GetResponseEvent $event) {

            $token = $this->token->getToken();
            // method_exists for showing sonata admin tool bar dashboard
            if(method_exists($token,'getUser'))
            {
               $user = $token->getUser();
                if(strcmp($user,'anon.') !=0) {
                    $result = $this->em->getRepository(ViewDevisCount::class)->ifAddTodayCount($user);
                    if(empty($result)) {
                        $this->viewDevisCountService->addDevisCount(1);
                        $this->viewDevisCountService->addCreateDateDevisCount();
                    }
                }

                // Check if user as i First Time Logged in the web site
                $result = $this->em->getRepository(ViewDevisCount::class)->CheckIfFirstTime($user);
                // Logged first time
                if(empty($result)) {

                }

            }
    }
}