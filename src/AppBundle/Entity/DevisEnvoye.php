<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use AppBundle\Entity\Traits\Devis as Devis;
use AppBundle\Entity\Traits\DevisCustomConfig as DevisConfig;



/**
 * DevisEnvoye
 *
 * @ORM\Table(name="devis_envoye")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DevisEnvoyeRepository")
 */
class DevisEnvoye
{
    use Devis;
    use DevisConfig;

    /**
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    private $createdDataText;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_devis_envoye", cascade={"persist"})
     */
    private $user_id;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", cascade={"persist"})
     */
    private $user_send_id;

    /**
     * @var string
     *
     * @ORM\Column(name="devisnumber", type="string", length=64, nullable=true))
     */
    private $devisnumber;


    /**
     * @var string
     *
     * @ORM\Column(name="prixht", type="string", length=64, nullable=true)
     */
    private $prixht;

    /**
     * @var string
     *
     * @ORM\Column(name="acompte", type="string", length=64, nullable=true)
     */
    private $acompte;

    /**
     * @var string
     *
     * @ORM\Column(name="franchise", type="string", length=64, nullable=true)
     */
    private $franchise;


    /**
     * @var string
     *
     * @ORM\Column(name="tva", type="string", length=64, nullable=true)
     */
    private $tva;

    /**
     * @var string
     *
     * @ORM\Column(name="valglobale", type="string", length=64, nullable=true)
     */
    private $valglobale;

    /**
     * @var string
     *
     * @ORM\Column(name="parobjet", type="string", length=64, nullable=true)
     */
    private $parobjet;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AdValorem", mappedBy="devis_id", cascade={"persist", "remove"})
     */
    private $idadvalorem;

    /**
     * @return ArrayCollection
     */
    public function getIdAdvalorem()
    {
        return $this->idadvalorem;
    }

    /**
     * @param ArrayCollection $idadvalorem
     */
    public function setIdAdvalorem($idadvalorem)
    {
        $this->idadvalorem = $idadvalorem;
    }

    ////////////////////////////////// CUSTOM ///////////////////////////////////////



    /**
     * @return bool
     */
    public function isSignee()
    {
        return $this->signee;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="valable", type="string", length=64, nullable=true)
     */
    private $valable;

    /**
     * @var bool
     *
     * @ORM\Column(name="signee", type="boolean", nullable=true)
     */
    private $signee;

    /**
     * @var bool
     *
     * @ORM\Column(name="sous_traitance", type="boolean", nullable=true)
     */
    private $sous_traitance;


    /**
     * @var string
     *
     * @ORM\Column(name="prix_soustraitance", length=32,  type="string", nullable=true)
     */
    private $prix_soustraitance;

    /**
     * DevisCustomConfig constructor.
     */
    public function __construct()
    {
        // We make construct of trait
        $this->DevisTraitConstruct();
        $this->DevisCustomTraitConstruct();
    }

    /**
     * @return string
     */
    public function getDevisnumber()
    {
        return $this->devisnumber;
    }

    /**
     * @param string $devisnumber
     */
    public function setDevisnumber($devisnumber)
    {
        $this->devisnumber = $devisnumber;
    }



    /**
     * @return string
     */
    public function getPrixht()
    {
        return $this->prixht;
    }

    /**
     * @param string $prixht
     */
    public function setPrixht($prixht)
    {
        $this->prixht = $prixht;
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
    public function getValglobale()
    {
        return $this->valglobale;
    }

    /**
     * @param string $valglobale
     */
    public function setValglobale($valglobale)
    {
        $this->valglobale = $valglobale;
    }

    /**
     * @return string
     */
    public function getParobjet()
    {
        return $this->parobjet;
    }

    /**
     * @param string $parobjet
     */
    public function setParobjet($parobjet)
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
     * @param bool $signee
     */
    public function setSignee($signee)
    {
        $this->signee = $signee;
    }

    /**
     * @return bool
     */
    public function isSousTraitance()
    {
        return $this->sous_traitance;
    }

    /**
     * @param bool $sous_traitance
     */
    public function setSousTraitance($sous_traitance)
    {
        $this->sous_traitance = $sous_traitance;
    }

    /**
     * @return string
     */
    public function getPrixSoustraitance()
    {
        return $this->prix_soustraitance;
    }

    /**
     * @param string $prix_soustraitance
     */
    public function setPrixSoustraitance($prix_soustraitance)
    {
        $this->prix_soustraitance = $prix_soustraitance;
    }

    /**
     * @return mixed
     */
    public function getCreatedDataText()
    {
        return $this->CreatedDate->format('d/m/Y');
    }

    /**
     * @return string
     */
    public function getCreatedDateText2()
    {
        return $this->CreatedDate->format('d/m/Y H:s');
    }

    /**
     * @return User
     */
    public function getUserSendId()
    {
        return $this->user_send_id;
    }

    /**
     * @param User $user_send_id
     */
    public function setUserSendId($user_send_id)
    {
        $this->user_send_id = $user_send_id;
    }

    /**
     * @return $this
     */
    public function clearId()
    {
        $this->id = null; // également essayé avec "", 0, valeur de l'auto-incrément, true, false, -1
        return $this;
    }

}

