<?php

namespace AppBundle\Entity;

use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * GardeMeube
 *
 * @ORM\Table(name="garde_meube")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GardeMeubeRepository")
 */
class GardeMeube{
    /**
     * GardeMeube constructor.
     */
    public function __construct() {
        $this->readed = false;
        $date = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->CreatedDate;
    }

    /**
     * @param \DateTime $CreatedDate
     */
    public function setCreatedDate($CreatedDate)
    {
        $this->CreatedDate = $CreatedDate;
    }

    /**
     * @return boolean
     */
    public function isReaded()
    {
        return $this->readed;
    }

    /**
     * @param boolean $readed
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $CreatedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", length=255, nullable=true)
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="date1", type="string", length=255, nullable=true)
     */
    private $date1;

    /**
     * @var string
     *
     * @ORM\Column(name="cp1", type="string", length=255, nullable=true)
     */
    private $cp1;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse1", type="string", length=255, nullable=true)
     */
    private $adresse1;

    /**
     * @var string
     *
     * @ORM\Column(name="pays1", type="string", length=255, nullable=true)
     */
    private $pays1;

    /**
     * @var string
     *
     * @ORM\Column(name="etage1", type="string", length=255, nullable=true)
     */
    private $etage1;

    /**
     * @var string
     *
     * @ORM\Column(name="ascenseur1", type="string", length=255, nullable=true)
     */
    private $ascenseur1;

    /**
     * @var string
     *
     * @ORM\Column(name="comment1", type="text", nullable=true)
     */
    private $comment1;

    /**
     * @var string
     *
     * @ORM\Column(name="prestation", type="string", length=255, nullable=true)
     */
    private $prestation;

    /**
     * @var string
     *
     * @ORM\Column(name="volume", type="string", length=255, nullable=true)
     */
    private $volume;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return GardeMeube
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return GardeMeube
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return GardeMeube
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set portable
     *
     * @param string $portable
     *
     * @return GardeMeube
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return string
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return GardeMeube
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set date1
     *
     * @param string $date1
     *
     * @return GardeMeube
     */
    public function setDate1($date1)
    {
        $this->date1 = $date1;

        return $this;
    }

    /**
     * Get date1
     *
     * @return string
     */
    public function getDate1()
    {
        return $this->date1;
    }

    /**
     * Set cp1
     *
     * @param string $cp1
     *
     * @return GardeMeube
     */
    public function setCp1($cp1)
    {
        $this->cp1 = $cp1;

        return $this;
    }

    /**
     * Get cp1
     *
     * @return string
     */
    public function getCp1()
    {
        return $this->cp1;
    }

    /**
     * Set adresse1
     *
     * @param string $adresse1
     *
     * @return GardeMeube
     */
    public function setAdresse1($adresse1)
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    /**
     * Get adresse1
     *
     * @return string
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * Set pays1
     *
     * @param string $pays1
     *
     * @return GardeMeube
     */
    public function setPays1($pays1)
    {
        $this->pays1 = $pays1;

        return $this;
    }

    /**
     * Get pays1
     *
     * @return string
     */
    public function getPays1()
    {
        return $this->pays1;
    }

    /**
     * Set etage1
     *
     * @param string $etage1
     *
     * @return GardeMeube
     */
    public function setEtage1($etage1)
    {
        $this->etage1 = $etage1;

        return $this;
    }

    /**
     * Get etage1
     *
     * @return string
     */
    public function getEtage1()
    {
        return $this->etage1;
    }

    /**
     * Set ascenseur1
     *
     * @param string $ascenseur1
     *
     * @return GardeMeube
     */
    public function setAscenseur1($ascenseur1)
    {
        $this->ascenseur1 = $ascenseur1;

        return $this;
    }

    /**
     * Get ascenseur1
     *
     * @return string
     */
    public function getAscenseur1()
    {
        return $this->ascenseur1;
    }

    /**
     * Set comment1
     *
     * @param string $comment1
     *
     * @return GardeMeube
     */
    public function setComment1($comment1)
    {
        $this->comment1 = $comment1;

        return $this;
    }

    /**
     * Get comment1
     *
     * @return string
     */
    public function getComment1()
    {
        return $this->comment1;
    }

    /**
     * Set prestation
     *
     * @param string $prestation
     *
     * @return GardeMeube
     */
    public function setPrestation($prestation)
    {
        $this->prestation = $prestation;

        return $this;
    }

    /**
     * Get prestation
     *
     * @return string
     */
    public function getPrestation()
    {
        return $this->prestation;
    }

    /**
     * Set volume
     *
     * @param string $volume
     *
     * @return GardeMeube
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return string
     */
    public function getVolume()
    {
        return $this->volume;
    }
}

