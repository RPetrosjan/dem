<?php
/**
 * Created by PhpStorm.
 * User: rpetrosjan
 * Date: 21/03/2019
 * Time: 23:52
 */

namespace AppBundle\service;
use AppBundle\Entity\DemandeDevis;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class AddinDemandeDevis
 * @package AppBundle\service
 */
class AddinDemandeDevis
{
    /** @var EntityManagerInterface  */
    private $em;

    /** @var Container */
    private $container;

    /** @var User */
    private $user;

    private $demandeDevisRepository;

    /**
     * AddinDemandeDevis constructor.
     * @param Container $container
     * @param EntityManagerInterface $em
     */
    public function __construct(Container $container, EntityManagerInterface $em) {
        $this->user = $container->get('security.token_storage')->getToken()->getUser();
        $this->em = $em;
        $this->demandeDevisRepository = $em->getRepository(DemandeDevis::class);
    }

    /**
     *
     * array $devis must object array
     *
     * @param array $devis
     * @return DemandeDevis
     */
    public function convertDemandeDevis(array $devis) {

        $demandeDevis = new DemandeDevis();
        $demandeDevis->setNom($devis['nom']);
        $demandeDevis->setTelephone($devis['telephone']);
        $demandeDevis->setPortable($devis['portable']);
        $demandeDevis->setEmail($devis['email']);
        $demandeDevis->setPrenom($devis['prenom']);
        $demandeDevis->setAdresse1($devis['adresse1']);
        $demandeDevis->setAdresse2($devis['adresse2']);
        $demandeDevis->setCp1($devis['cp1']);
        $demandeDevis->setCp2($devis['cp2']);
        $demandeDevis->setVille1($devis['ville1']);
        $demandeDevis->setVille2($devis['ville2']);
        $demandeDevis->setEtage1($devis['etage1']);
        $demandeDevis->setEtage2($devis['etage2']);
        $demandeDevis->setDate1($devis['date1']);
        $demandeDevis->setDate2($devis['date2']);
        $demandeDevis->setPays1($devis['pays1']);
        $demandeDevis->setPays2($devis['pays2']);
        $demandeDevis->setComment1($devis['comment1']);
        $demandeDevis->setComment2($devis['comment2']);
        $demandeDevis->setAscenseur1($devis['ascenseur1']);
        $demandeDevis->setAscenseur2($devis['ascenseur2']);
        $demandeDevis->setPrestation($devis['prestation']);
        $demandeDevis->setVolume($devis['volume']);
        $demandeDevis->setDistance($devis['distance']);

        return $demandeDevis;
    }

    /**
     * add demande de devis with userID
     *
     * @param array $devis
     * @return DemandeDevis
     */
    public function addDemandeDevisWithUser(array $devis) {

        /** @var DemandeDevis $demandeDevis */
        $demandeDevis = $this->convertDemandeDevis($devis);
        if(!is_null($this->user)) {
            $demandeDevis->setOwnerId($this->user);
        }

        // Check if devis deja ete sur la base des donnes
        /** @var DemandeDevis $result */
        $result = $this->demandeDevisRepository->getDevisByUuid($devis['uuid']);
        if(empty($result)) {
            $demandeDevis->setUuid($devis['uuid']);
            $this->em->persist($demandeDevis);
            $this->em->flush();

            return true;
        }
        else {
            return false;
        }

        return false;
    }
}