<?php

namespace AppBundle\Entity;

use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;


/**
 * DemandeDevis
 *
 * @ORM\Table(name="demande_devis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeDevisRepository")
 */
class DemandeDevis
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
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    /**
     * @var string
     *
     * @ORM\Column(name="cp1", type="string", length=50, nullable=true)
     */
    private $cp1;

    /**
     * @var string
     *
     * @ORM\Column(name="etage1", type="string", length=50, nullable=true))
     */
    private $etage1;

    /**
     * @var string
     *
     * @ORM\Column(name="ascenseur1", type="string", length=70, nullable=true))
     */
    private $ascenseur1;


    /**
     * @var string
     *
     * @ORM\Column(name="cp2", type="string", length=50, nullable=true)
     */
    private $cp2;

    /**
     * @var string
     *
     * @ORM\Column(name="ville1", type="string", length=50, nullable=true)
     */
    private $ville1;

    /**
     * @var string
     *
     * @ORM\Column(name="ville2", type="string", length=50, nullable=true)
     */
    private $ville2;

    /**
     * @var string
     *
     * @ORM\Column(name="etage2", type="string", length=50, nullable=true))
     */
    private $etage2;

    /**
     * @var bool
     *
     * @ORM\Column(name="ascenseur2", type="string", length=50, nullable=true))
     */
    private $ascenseur2;

    /**
     * @var string
     *
     * @ORM\Column(name="volume", type="string", length=10, nullable=true))
     */
    private $volume;

    /**
     * @var Prestation
     *
     * @ORM\ManyToOne(targetEntity="Prestation", inversedBy="devisPrestation", cascade={"persist"})
     */
    private $prestation;


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
     * @ORM\Column(name="nom", type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=50, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", length=50, nullable=true)
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=true)
     */
    private $email;


    /**
     * @var string
     *
     * @ORM\Column(name="adresse1", type="string", length=50, nullable=true)
     */
    private $adresse1;


    /**
     * @var string
     *
     * @ORM\Column(name="adresse2", type="string", length=50, nullable=true)
     */
    private $adresse2;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=50, nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="comment1", type="text", nullable=true)
     */
    private $comment1;

    /**
     * @var string
     *
     * @ORM\Column(name="comment2", type="text", nullable=true)
     */
    private $comment2;

    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="string", length=50, nullable=true)
     */
    private $distance;

    /**
     * @var string
     *
     * @ORM\Column(name="pays1", type="string", length=50, nullable=true)
     */
    private $pays1;

    /**
     * @var string
     *
     * @ORM\Column(name="pays2", type="string", length=50, nullable=true)
     */
    private $pays2;


    /**
     * @var string
     *
     * @ORM\Column(name="date1", type="string", length=50, nullable=true)
     */
    private $date1;

    /**
     * @var string
     *
     * @ORM\Column(name="date2", type="string", length=50, nullable=true)
     */
    private $date2;



    /**
     * @return string
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * @param string $portable
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;
    }


    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }


    /**
     * @return string
     */
    public function getVille1()
    {
        return $this->ville1;
    }

    /**
     * @param string $ville1
     */
    public function setVille1($ville1)
    {
        $this->ville1 = $ville1;
    }

    /**
     * @return string
     */
    public function getVille2()
    {
        return $this->ville2;
    }

    /**
     * @param string $ville2
     */
    public function setVille2($ville2)
    {
        $this->ville2 = $ville2;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getAdresse1()
    {
        return $this->adresse1;
    }

    /**
     * @param string $adresse1
     */
    public function setAdresse1($adresse1)
    {
        $this->adresse1 = $adresse1;
    }

    /**
     * @return string
     */
    public function getAdresse2()
    {
        return $this->adresse2;
    }

    /**
     * @param string $adresse2
     */
    public function setAdresse2($adresse2)
    {
        $this->adresse2 = $adresse2;
    }

    /**
     * @return bool
     */
    public function isReaded()
    {
        return $this->readed;
    }

    /**
     * @param bool $readed
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;
    }



    /**
     * @return string
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param string $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return string
     */
    public function getPays1()
    {
        return $this->pays1;
    }

    /**
     * @param string $pays1
     */
    public function setPays1($pays1)
    {
        $this->pays1 = $pays1;
    }

    /**
     * @return string
     */
    public function getPays2()
    {
        return $this->pays2;
    }

    /**
     * @param string $pays2
     */
    public function setPays2($pays2)
    {
        $this->pays2 = $pays2;
    }

    /**
     * @return string
     */
    public function getComment1()
    {
        return $this->comment1;
    }

    /**
     * @param string $comment1
     */
    public function setComment1($comment1)
    {
        $this->comment1 = $comment1;
    }

    /**
     * @return string
     */
    public function getComment2()
    {
        return $this->comment2;
    }

    /**
     * @param string $comment2
     */
    public function setComment2($comment2)
    {
        $this->comment2 = $comment2;
    }


    /**
     * @return string
     */
    public function getDate1()
    {
        return $this->date1;
    }

    /**
     * @param string $date1
     */
    public function setDate1($date1)
    {
        $this->date1 = $date1;
    }

    /**
     * @return string
     */
    public function getDate2()
    {
        return $this->date2;
    }

    /**
     * @param string $date2
     */
    public function setDate2($date2)
    {
        $this->date2 = $date2;
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
     * CalculDevis constructor.
     */
    public function __construct()
    {

        $this->readed = false;
        $date = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));

        $this->nom = null;
        $this->prenom = null;
        $this->date = null;
        $this->email = null;
        $this->telephone = null;
        $this->date1 = null;
        $this->date2 = null;
        $this->comment1 = '';
        $this->comment2 = '';
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
     * Set cp1
     *
     * @param string $cp1
     *
     * @return CalculDevis
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
     * Set etage1
     *
     * @param string $etage1
     *
     * @return CalculDevis
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
     * @param boolean $ascenseur1
     *
     * @return CalculDevis
     */
    public function setAscenseur1($ascenseur1)
    {
        $this->ascenseur1 = $ascenseur1;

        return $this;
    }

    /**
     * Get ascenseur1
     *
     * @return bool
     */
    public function getAscenseur1()
    {
        return $this->ascenseur1;
    }

    /**
     * Set cp2
     *
     * @param string $cp2
     *
     * @return CalculDevis
     */
    public function setCp2($cp2)
    {
        $this->cp2 = $cp2;

        return $this;
    }

    /**
     * Get cp2
     *
     * @return string
     */
    public function getCp2()
    {
        return $this->cp2;
    }

    /**
     * Set etage2
     *
     * @param string $etage2
     *
     * @return CalculDevis
     */
    public function setEtage2($etage2)
    {
        $this->etage2 = $etage2;

        return $this;
    }

    /**
     * Get etage2
     *
     * @return string
     */
    public function getEtage2()
    {
        return $this->etage2;
    }

    /**
     * Set ascenseur2
     *
     * @param boolean $ascenseur2
     *
     * @return CalculDevis
     */
    public function setAscenseur2($ascenseur2)
    {
        $this->ascenseur2 = $ascenseur2;

        return $this;
    }

    /**
     * Get ascenseur2
     *
     * @return bool
     */
    public function getAscenseur2()
    {
        return $this->ascenseur2;
    }

    /**
     * @return Prestation
     */
    public function getPrestation()
    {
        return $this->prestation;
    }

    /**
     * @param Prestation $prestation
     */
    public function setPrestation($prestation)
    {
        $this->prestation = $prestation;
    }

    /**
     * Set volume
     *
     * @param string $volume
     *
     * @return CalculDevis
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

