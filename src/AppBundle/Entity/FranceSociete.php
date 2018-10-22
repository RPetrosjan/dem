<?php

namespace AppBundle\Entity;

use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FranceSociete
 *
 * @ORM\Table(name="france_societe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FranceSocieteRepository")
 */
class FranceSociete
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
     * @ORM\Column(name="NomSociete", type="string", length=50)
     */
    private $nomSociete;

    /**
     * @return string
     */
    public function getDescriptionSociete()
    {
        return $this->DescriptionSociete;
    }

    /**
     * @param string $DescriptionSociete
     */
    public function setDescriptionSociete($DescriptionSociete)
    {
        $this->DescriptionSociete = $DescriptionSociete;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="DescriptionSociete", type="text")
     */
    private $DescriptionSociete;

    /**
     * @var string
     *
     * @ORM\Column(name="AdresseSociete", type="string", length=50)
     */
    private $adresseSociete;

    /**
     * @ORM\ManyToOne(targetEntity="CpVille", cascade={"all"}, fetch="EAGER")
     */
    private $cpVilleSociete;

    /**
     * @ORM\ManyToMany(targetEntity="Telephone", cascade={"all"}, fetch="EAGER")
     */
    private $telephoneSociete;

    /**
     * @var string
     *
     * @ORM\Column(name="PrestationSociete", type="string", length=255)
     */
    private $prestationSociete;

    /**
     * @var string
     *
     * @ORM\Column(name="NomGerant", type="string", length=50)
     */
    private $nomGerant;

    /**
     * @var string
     *
     * @ORM\Column(name="PrenomGerant", type="string", length=50)
     */
    private $prenomGerant;

    /**
     * @var string
     *
     * @ORM\Column(name="Active", type="string", length=10)
     */
    private $active;

    /**
     * FranceSociete constructor.
     */
    public function __construct()
    {
        $date = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));
        $this->telephoneSociete = new ArrayCollection();
        $this->DescriptionSociete = '';

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
     * @var string
     *
     * @ORM\Column(name="PhotoSociete", type="string", length=255, nullable=true)
     */
    private $photoSociete;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $CreatedDate;


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
     * Set nomSociete
     *
     * @param string $nomSociete
     *
     * @return FranceSociete
     */
    public function setNomSociete($nomSociete)
    {
        $this->nomSociete = $nomSociete;

        return $this;
    }

    /**
     * Get nomSociete
     *
     * @return string
     */
    public function getNomSociete()
    {
        return $this->nomSociete;
    }

    /**
     * Set adresseSociete
     *
     * @param string $adresseSociete
     *
     * @return FranceSociete
     */
    public function setAdresseSociete($adresseSociete)
    {
        $this->adresseSociete = $adresseSociete;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCpVilleSociete()
    {
        return $this->cpVilleSociete;
    }

    /**
     * @param mixed $cpVilleSociete
     */
    public function setCpVilleSociete($cpVilleSociete)
    {
        $this->cpVilleSociete = $cpVilleSociete;
    }

    /**
     * Get adresseSociete
     *
     * @return string
     */
    public function getAdresseSociete()
    {
        return $this->adresseSociete;
    }


    /**
     * @param mixed $tel
     */
    public function setTelephoneSociete($telephoneSociete)
    {
        $this->telephoneSociete = $telephoneSociete;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTelephoneSociete()
    {
        return $this->telephoneSociete;
    }

    /**
     * Set prestationSociete
     *
     * @param string $prestationSociete
     *
     * @return FranceSociete
     */
    public function setPrestationSociete($prestationSociete)
    {
        $this->prestationSociete = $prestationSociete;

        return $this;
    }

    /**
     * Get prestationSociete
     *
     * @return string
     */
    public function getPrestationSociete()
    {
        return $this->prestationSociete;
    }

    /**
     * Set nomGerant
     *
     * @param string $nomGerant
     *
     * @return FranceSociete
     */
    public function setNomGerant($nomGerant)
    {
        $this->nomGerant = $nomGerant;

        return $this;
    }

    /**
     * Get nomGerant
     *
     * @return string
     */
    public function getNomGerant()
    {
        return $this->nomGerant;
    }

    /**
     * Set prenomGerant
     *
     * @param string $prenomGerant
     *
     * @return FranceSociete
     */
    public function setPrenomGerant($prenomGerant)
    {
        $this->prenomGerant = $prenomGerant;

        return $this;
    }

    /**
     * Get prenomGerant
     *
     * @return string
     */
    public function getPrenomGerant()
    {
        return $this->prenomGerant;
    }

    /**
     * Set active
     *
     * @param string $active
     *
     * @return FranceSociete
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set photoSociete
     *
     * @param string $photoSociete
     *
     * @return FranceSociete
     */
    public function setPhotoSociete($photoSociete)
    {
        $this->photoSociete = $photoSociete;

        return $this;
    }

    /**
     * Get photoSociete
     *
     * @return string
     */
    public function getPhotoSociete()
    {
        return $this->photoSociete;
    }
}

