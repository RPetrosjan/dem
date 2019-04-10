<?php

namespace AppBundle\Entity;

use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * DocPDF
 *
 * @ORM\Table(name="doc_p_d_f")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocPDFRepository")
 */
class DocPDF
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
     * @var integer
     *
     * @ORM\Column(name="id_devis", type="integer")
     */
    private $id_devis;

    /**
     * @var string
     *
     * @ORM\Column(name="PriceHT", type="string", length=255)
     */
    private $price;


    /**
     * @var string
     *
     * @ORM\Column(name="RandomName", type="string", length=255)
     */
    private $randomname;

    /**
     * @var string
     *
     * @ORM\Column(name="TVA", type="string", length=50)
     */
    private $tva;

    /**
     * @var string
     *
     * @ORM\Column(name="Acompte", type="string", length=50)
     */
    private $acompte;

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
     * @var string
     *
     * @ORM\Column(name="prestation", type="string", length=20, nullable=true))
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
     * @var string
     *
     * @ORM\Column(name="Franchise", type="string", length=50)
     */
    private $franchise;

    /**
     * @var string
     *
     * @ORM\Column(name="Valeur_Globale", type="string", length=50)
     */
    private $valeurglobale;

    /**
     * @var string
     *
     * @ORM\Column(name="Par_Objet", type="string", length=50)
     */
    private $parobjet;

    /**
     * @var string
     *
     * @ORM\Column(name="Valable", type="string", length=50)
     */
    private $valable;




    /**
     * @return string
     */
    public function getCp1()
    {
        return $this->cp1;
    }

    /**
     * @param string $cp1
     */
    public function setCp1($cp1)
    {
        $this->cp1 = $cp1;
    }

    /**
     * @return string
     */
    public function getEtage1()
    {
        return $this->etage1;
    }

    /**
     * @param string $etage1
     */
    public function setEtage1($etage1)
    {
        $this->etage1 = $etage1;
    }

    /**
     * @return string
     */
    public function getAscenseur1()
    {
        return $this->ascenseur1;
    }

    /**
     * @param string $ascenseur1
     */
    public function setAscenseur1($ascenseur1)
    {
        $this->ascenseur1 = $ascenseur1;
    }

    /**
     * @return string
     */
    public function getCp2()
    {
        return $this->cp2;
    }

    /**
     * @param string $cp2
     */
    public function setCp2($cp2)
    {
        $this->cp2 = $cp2;
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
    public function getEtage2()
    {
        return $this->etage2;
    }

    /**
     * @param string $etage2
     */
    public function setEtage2($etage2)
    {
        $this->etage2 = $etage2;
    }

    /**
     * @return bool
     */
    public function isAscenseur2()
    {
        return $this->ascenseur2;
    }

    /**
     * @param bool $ascenseur2
     */
    public function setAscenseur2($ascenseur2)
    {
        $this->ascenseur2 = $ascenseur2;
    }

    /**
     * @return string
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param string $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    /**
     * @return string
     */
    public function getPrestation()
    {
        return $this->prestation;
    }

    /**
     * @param string $prestation
     */
    public function setPrestation($prestation)
    {
        $this->prestation = $prestation;
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getFranchise()
    {
        return $this->franchise;
    }

    /**
     * @param string $franchise
     */
    public function setFranchise($franchise)
    {
        $this->franchise = $franchise;
    }

    /**
     * @return string
     */
    public function getValeurGlobale()
    {
        return $this->valeurglobale;
    }

    /**
     * @param string $valeur_globale
     */
    public function setValeurGlobale($valeurglobale)
    {
        $this->valeurglobale = $valeurglobale;
    }

    /**
     * @return string
     */
    public function getParObjet()
    {
        return $this->parobjet;
    }

    /**
     * @param string $par_objet
     */
    public function setParObjet($parobjet)
    {
        $this->parobjet = $parobjet;
    }

    /**
     * @return string
     */
    public function getValable()
    {
        return $this->valable;
    }

    /**
     * @param string $valable
     */
    public function setValable($valable)
    {
        $this->valable = $valable;
    }


    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * CalculDevis constructor.
     */
    public function __construct()
    {
        $date = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));
        $this->tva = 0;
        $this->price = 0;
        $this->acompte = 0;

    }

    /**
     * @return string
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * @param string $tva
     */
    public function setTva($tva)
    {
        $this->tva = $tva;
    }

    /**
     * @return string
     */
    public function getAcompte()
    {
        return $this->acompte;
    }

    /**
     * @param string $acompte
     */
    public function setAcompte($acompte)
    {
        $this->acompte = $acompte;
    }

    /**
     * @return mixed
     */
    public function getIdDevis()
    {
        return $this->id_devis;
    }

    /**
     * @param mixed $id_devis
     */
    public function setIdDevis($id_devis)
    {
        $this->id_devis = $id_devis;
    }

      /**
     * @return string
     */
    public function getRandomname()
    {
        return $this->randomname;
    }

    /**
     * @param string $randomname
     */
    public function setRandomname($randomname)
    {
        $this->randomname = $randomname;
    }

    public function  __toString()
    {
        return 'string';
    }


}

