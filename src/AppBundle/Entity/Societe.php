<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Societe
 *
 * @ORM\Table(name="societe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SocieteRepository")
 */
class Societe
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
     * Societe constructor.
     */
    public function __construct()
    {
        $this->tel = new ArrayCollection();
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
    public function getNamesociete()
    {
        return $this->namesociete;
    }

    /**
     * @param ArrayCollection $namesociete
     */
    public function setNamesociete($namesociete)
    {
        $this->namesociete = $namesociete;
    }

    /**
     * @return ArrayCollection
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="namesociete", type="string", length=255)
     */
    private $namesociete;


    /**
     * @ORM\ManyToMany(targetEntity="Telephone", cascade={"all"}, fetch="EAGER")
     */
    public $tel;

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getSiege()
    {
        return $this->siege;
    }

    /**
     * @param string $siege
     */
    public function setSiege($siege)
    {
        $this->siege = $siege;
    }

    /**
     * @return mixed
     */
    public function getCpville()
    {
        return $this->cpville;
    }

    /**
     * @param mixed $cpville
     */
    public function setCpville($cpville)
    {
        $this->cpville = $cpville;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param string $siret
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="siege", type="boolean")
     */
    private $siege;

    /**
     * @ORM\ManyToOne(targetEntity="CpVille", cascade={"all"}, fetch="EAGER")
     */
    private $cpville;

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="prixtva", type="string", length=50)
     */
    private $prixtva;

    /**
     * @var string
     *
     * @ORM\Column(name="accompte", type="string", length=50)
     */
    private $accompte;

    /**
     * @return string
     */
    public function getAccompte()
    {
        return $this->accompte;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $prixtva
     */
    public function setPrixtva($prixtva)
    {
        $this->prixtva = $prixtva;
    }

    /**
     * @param string $franchise
     */
    public function setFranchise($franchise)
    {
        $this->franchise = $franchise;
    }

    /**
     * @param string $valeurglobale
     */
    public function setValeurglobale($valeurglobale)
    {
        $this->valeurglobale = $valeurglobale;
    }

    /**
     * @param string $parobjet
     */
    public function setParobjet($parobjet)
    {
        $this->parobjet = $parobjet;
    }

    /**
     * @param string $devisvalable
     */
    public function setDevisvalable($devisvalable)
    {
        $this->devisvalable = $devisvalable;
    }

    /**
     * @param string $accompte
     */
    public function setAccompte($accompte)
    {
        $this->accompte = $accompte;
    }

    /**
     * @return string
     */
    public function getPrixtva()
    {
        return $this->prixtva;
    }

    /**
     * @return string
     */
    public function getFranchise()
    {
        return $this->franchise;
    }

    /**
     * @return string
     */
    public function getValeurglobale()
    {
        return $this->valeurglobale;
    }

    /**
     * @return string
     */
    public function getParobjet()
    {
        return $this->parobjet;
    }

    /**
     * @return string
     */
    public function getDevisvalable()
    {
        return $this->devisvalable;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="franchise", type="string", length=50)
     */
    private $franchise;

    /**
     * @var string
     *
     * @ORM\Column(name="valeurglobale", type="string", length=50)
     */
    private $valeurglobale;

    /**
     * @var string
     *
     * @ORM\Column(name="parobjet", type="string", length=50)
     */
    private $parobjet;

    /**
     * @var string
     *
     * @ORM\Column(name="devisvalable", type="string", length=50)
     */
    private $devisvalable;


}

