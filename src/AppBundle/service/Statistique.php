<?php

namespace AppBundle\service;


use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\DevisEnvoye;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Tests\Fixtures\ToString;

class Statistique
{

    /** @var EntityManagerInterface  */
    private $em;

    /** @var \Doctrine\Common\Persistence\ObjectRepository  */
    private $devisEnvoyeRepository;

    private $demandeDevisRepository;

    /** @var object|string  */
    private $user;

    /** @var array  */
    private $french_months;

    /**
     * @param $object
     */
    private function convertToTable($resultArray){

        $resultArrayDevisEnvoye = [];
        foreach ($resultArray as $object) {

            if(!isset($resultArrayDevisEnvoye[$object->getCreatedDate()->format('Y')][$this->french_months[intval($object->getCreatedDate()->format('m'))]])) {
                $resultArrayDevisEnvoye[$object->getCreatedDate()->format('Y')][$this->french_months[intval($object->getCreatedDate()->format('m'))]] = 0;
            }
            $resultArrayDevisEnvoye[$object->getCreatedDate()->format('Y')][$this->french_months[intval($object->getCreatedDate()->format('m'))]] += 1 ;

        }

        return $resultArrayDevisEnvoye;
    }

    /**
     * Statistique constructor.
     * @param EntityManagerInterface $em
     * @param TokenStorage $token
     */
    public function __construct(EntityManagerInterface $em, TokenStorage $token) {
        $this->em = $em;
        $this->user = $token->getToken()->getUser();
        $this->devisEnvoyeRepository = $em->getRepository(DevisEnvoye::class);
        $this->demandeDevisRepository = $em->getRepository(DemandeDevis::class);

        $this->french_months = array('','Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    }

    /**
     * @return null|object
     */
    public function getStatDevisEnvoye() {
        $resultArrayDevisEnvoye =  $this->devisEnvoyeRepository->getAllDevisEnvoye($this->user->getId());
        $resultArrayDemandeDevis = $this->demandeDevisRepository->getAllDemandeDevis();

        $resultArrayDemandeDevis = $this->convertToTable($resultArrayDemandeDevis);
        $resultArrayDevisEnvoye  = $this->convertToTable($resultArrayDevisEnvoye);

        return [
            'statDevisEnvoye'  => $resultArrayDevisEnvoye,
            'statDemandeDevis' => $resultArrayDemandeDevis,
        ];
    }
}