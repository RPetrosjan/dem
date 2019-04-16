<?php

namespace AppBundle\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactureRepository")
 */
class Facture
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
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $uuid;


    /**
     * @var DateTime
     *
     * @ORM\Column(name="Created", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $CreatedDate;


    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_devis_envoye", cascade={"persist"})
     */
    private $user_id;


    /**
     * @var string
     *
     * @ORM\Column(name="mode_payement", type="string", length=32)
     */
    private $modePayement;


    /**
     * @var string
     *
     * @ORM\Column(name="montant_payement", type="string", length=16)
     */
    private $montantPayement;

    private $montantPayementeuro;


    /**
     * @var string
     *
     * @ORM\Column(name="numero_facture", type="string", length=16)
     */
    private $numeroFacture;

    /**
     * Facture constructor.
     */
    public function __construct()
    {
        $date = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));

        $this->uuid = \Ramsey\Uuid\Uuid::uuid4();
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }



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
     * Set modePayement
     *
     * @param string $modePayement
     *
     * @return Facture
     */
    public function setModePayement($modePayement)
    {
        $this->modePayement = $modePayement;

        return $this;
    }

    /**
     * Get modePayement
     *
     * @return string
     */
    public function getModePayement()
    {
        return $this->modePayement;
    }

    /**
     * Set montantPayement
     *
     * @param string $montantPayement
     *
     * @return Facture
     */
    public function setMontantPayement($montantPayement)
    {
        $this->montantPayement = $montantPayement;

        return $this;
    }

    /**
     * Get montantPayement
     *
     * @return string
     */
    public function getMontantPayement()
    {
        return $this->montantPayement;
    }

    /**
     * @return User
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param User $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getNumeroFacture()
    {
        return $this->numeroFacture;
    }

    /**
     * @return mixed
     */
    public function getMontantPayementeuro()
    {
        return $this->montantPayement.' €';
    }

    /**
     * @param string $numeroFacture
     */
    public function setNumeroFacture($numeroFacture)
    {
        $this->numeroFacture = $numeroFacture;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate()
    {
        return $this->CreatedDate;
    }

    /**
     * @param DateTime $CreatedDate
     */
    public function setCreatedDate($CreatedDate)
    {
        $this->CreatedDate = $CreatedDate;
    }



}

