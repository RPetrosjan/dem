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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;


}

