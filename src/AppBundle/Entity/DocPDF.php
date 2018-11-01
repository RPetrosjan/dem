<?php

namespace AppBundle\Entity;

use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
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
     * CalculDevis constructor.
     */
    public function __construct()
    {
        $date = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));
        $this->id_devis = new ArrayCollection();

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
     * @ORM\ManyToMany(targetEntity="DemandeDevis", cascade={"all"}, fetch="EAGER")
     */
    private $id_devis;

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

    public function addIdDevis(DemandeDevis $demandeDevis) {
        $this->id_devis[] = $demandeDevis;
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
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=50)
     */
    private $email;

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
     * @var \DateTime
     *
     * @ORM\Column(name="Created", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $CreatedDate;


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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


}

