<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 14/04/2019
 * Time: 15:18
 */

namespace AppBundle\service;


use AppBundle\Entity\Facture;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class AddFactureSocieteService
{

    /**
     * @var \AppBundle\Repository\FactureRepository|\Doctrine\Common\Persistence\ObjectRepository
     */
    private $factureRepository;


    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * AddFactureSocieteService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $em->contains();
        $this->em = $em;
        $this->factureRepository = $em->getRepository(Facture::class);
        $this->userRepository = $em->getRepository(User::class);
    }

    public function generateNumeroFacture($length=4) {
            return substr(str_shuffle("qwertyuiopasdfghjklzxcvbnm"),0, $length);
    }

    /**
     * @param User $user |int
     * @param $montant
     * @param $method
     * @return bool
     */
    public function addFacture($user, $montant, $method) {

        if(is_int($user)) {
            $user = $this->userRepository->find($user);
        }

        if(!is_null($user)) {
            $facture = new Facture();
            $facture->setUserId($user);
            $facture->setModePayement($method);
            $facture->setMontantPayement($montant);
            $facture->setNumeroFacture($this->generateNumeroFacture(5));

            $this->em->persist($facture);
            $this->em->flush();

            return true;
        }

        return false;
    }
}