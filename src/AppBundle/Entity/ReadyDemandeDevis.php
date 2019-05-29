<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * ReadyDemandeDevis
 *
 * @ORM\Table(name="ready_demande_devis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReadyDemandeDevisRepository")
 */
class ReadyDemandeDevis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_ready_demande_devis", cascade={"remove"})
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid_devis", type="string", length=64)
     */
    private $uuidDevis;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param string $idUser
     *
     * @return ReadyDemandeDevis
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return string
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set uuidDevis
     *
     * @param string $uuidDevis
     *
     * @return ReadyDemandeDevis
     */
    public function setUuidDevis($uuidDevis)
    {
        $this->uuidDevis = $uuidDevis;

        return $this;
    }

    /**
     * Get uuidDevis
     *
     * @return string
     */
    public function getUuidDevis()
    {
        return $this->uuidDevis;
    }
}

