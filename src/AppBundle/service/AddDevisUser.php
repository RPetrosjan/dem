<?php


namespace AppBundle\service;

use AppBundle\Entity\MesDevis;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AddDevisUser
 * @package AppBundle\service
 */
class AddDevisUser
{
    /** @var EntityManagerInterface  */
    private $em;

    /**
     * AddDevisUser constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @param array $devisParam
     */
    public function AddDevis(User $user, array $devisParam) {

        if(!empty($devisParam))
        {

            if($devisParam['prestation'][0] == 'CATEGORIE 3'){
                $devisParam['prestation'][0] = 'Economique';
            }

            $mesdevis = new MesDevis();
            if(isset($devisParam['nom'][0])) {
                $mesdevis->setNom($devisParam['nom'][0]);
            }
            if(isset($devisParam['prenom'][0])) {
                $mesdevis->setPrenom($devisParam['prenom'][0]);
            }
            if(isset($devisParam['telephone'][0])) {
                $mesdevis->setTelephone($devisParam['telephone'][0]);
            }
            if(isset($devisParam['email'][0])) {
                $mesdevis->setEmail($devisParam['email'][0]);
            }
            if(isset($devisParam['adresse'][0])) {
                $mesdevis->setAdresse1($devisParam['adresse'][0]);
            }
            if(isset($devisParam['adresse'][1])) {
                $mesdevis->setAdresse2($devisParam['adresse'][1]);
            }
            if(isset($devisParam['cp'][0])) {
                $mesdevis->setCp1($devisParam['cp'][0]);
            }
            if(isset($devisParam['cp'][1])) {
                $mesdevis->setCp2($devisParam['cp'][1]);
            }
            if(isset($devisParam['ville'][0])) {
                $mesdevis->setVille1($devisParam['ville'][0]);
            }
            if(isset($devisParam['ville'][1])) {
                $mesdevis->setVille2($devisParam['ville'][1]);
            }
            if(isset($devisParam['pays'][0])) {
                $mesdevis->setPays1($devisParam['pays'][0]);
            }
            if(isset($devisParam['pays'][1])) {
                $mesdevis->setPays2($devisParam['pays'][1]);
            }
            if(isset($devisParam['prestation'][0])) {
                $mesdevis->setPrestation($devisParam['prestation'][0]);
            }
            if(isset($devisParam['volume'][0])) {
                $mesdevis->setVolume($devisParam['volume'][0]);
            }
            if(isset($devisParam['date1'][0])) {
                $mesdevis->setDate1($devisParam['date1'][0]);
            }
            if(isset($devisParam['date2'][0])) {
                $mesdevis->setDate2($devisParam['date2'][0]);
            }
            if(isset($devisParam['etage'][0])) {
                $mesdevis->setEtage1($devisParam['etage'][0]);
            }
            if(isset($devisParam['etage'][1])) {
                $mesdevis->setEtage2($devisParam['etage'][1]);
            }
            if(isset($devisParam['ascenseur'][0])) {
                $mesdevis->setAscenseur1($devisParam['ascenseur'][0]);
            }
            if(isset($devisParam['ascenseur'][1])) {
                $mesdevis->setAscenseur2($devisParam['ascenseur'][1]);
            }
            if(isset($devisParam['comment'])) {
                $mesdevis->setComment1($devisParam['comment']);
            }

            $mesdevis->setUserId($user);

            $this->em->persist($mesdevis);
            $this->em->flush();

        }
    }
}