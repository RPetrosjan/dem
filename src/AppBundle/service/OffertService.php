<?php


namespace AppBundle\service;

use AppBundle\Entity\Distancematrix;
use AppBundle\Entity\Offer;
use AppBundle\Entity\OffersClient;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class OffertService
 * @package AppBundle\service
 */
class OffertService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * OffertService constructor.
     * @param Container $container
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param $type
     * @param $societe
     * @param $interval
     */
    public function setOffert($type, User $societe, $interval){
        $offersClient = new  OffersClient();

        $offerRepository = $this->em->getRepository(Offer::class);
        $offer = $offerRepository ->findOneBy([
            'code' => $type
        ]);

        $offersClient->setTypePro($offer);
        $offersClient->setDateStart(date('Y-m-d'));
        $offersClient->setDateFin(\DateTime::createFromFormat('Y-m-d', date('Y-m-d'))->modify("+$interval Month"));

        $this->em->persist($offersClient);
        $this->em->flush();

        return $offersClient;
    }
}