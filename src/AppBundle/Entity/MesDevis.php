<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use AppBundle\Entity\Traits\Devis as Devis;

/**
 * MesDevis
 *
 * @ORM\Table(name="mes_devis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MesDevisRepository")
 */
class MesDevis
{

    use Devis;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_mes_devis", cascade={"persist"})
     */
    private $user_id;


    /** @var string */
    private  $nom_prenom;

    /** @var  string */
    private $cp_ville1;

    /** @var string */
    private $cp_ville2;



    /**
     * @var bool
     *
     * @ORM\Column(name="share", type="boolean", nullable=true)
     */
    private $share;


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
     * @var string
     *
     * @ORM\Column(name="prix_ht", length=32,  type="string", nullable=true)
     */
    private $prix_ht;


    /**
     * @var string
     *
     * @ORM\Column(name="prix_tva", length=16,  type="string", nullable=true)
     */
    private $prix_tva;


    /**
     * @var string
     *
     * @ORM\Column(name="prix_ttc", length=16,  type="string", nullable=true)
     */
    private $prix_ttc;

    /**
     * MesDevis constructor.
     */
    public function __construct()
    {
        // We make construct of trait
        $this->DevisTraitConstruct();
    }


    /**
     * @return string
     */
    public function getPrixHt()
    {
        return $this->prix_ht;
    }

    /**
     * @param string $prix_ht
     */
    public function setPrixHt($prix_ht)
    {
        $this->prix_ht = $prix_ht;
    }

    /**
     * @return string
     */
    public function getPrixTva()
    {
        return $this->prix_tva;
    }

    /**
     * @param string $prix_tva
     */
    public function setPrixTva($prix_tva)
    {
        $this->prix_tva = $prix_tva;
    }

    /**
     * @return string
     */
    public function getPrixTtc()
    {
        return $this->prix_ttc;
    }

    /**
     * @param string $prix_ttc
     */
    public function setPrixTtc($prix_ttc)
    {
        $this->prix_ttc = $prix_ttc;
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
     * @return bool
     */
    public function isShare()
    {
        return $this->share;
    }

    /**
     * @param bool $share
     */
    public function setShare($share)
    {
        $this->share = $share;
    }


    /**
     * @return bool
     */
    public function isSignee()
    {
        return $this->signee;
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
     * @return MesDevis
     */
    public function getSousTraitanceMesDevis()
    {
        return $this->sous_traitance_mes_devis;
    }

    /**
     * @param MesDevis $sous_traitance_mes_devis
     */
    public function setSousTraitanceMesDevis($sous_traitance_mes_devis)
    {
        $this->sous_traitance_mes_devis = $sous_traitance_mes_devis;
    }

    /**
     * @return mixed
     */
    public function getNomPrenom()
    {
        return $this->user_id->getFirstName().' '.$this->user_id->getLastName();
    }

    /**
     * @return string
     */
    public function getCpVille1()
    {
        return $this->cp1.' '.$this->ville1;
    }

    /**
     * @return string
     */
    public function getCpVille2()
    {
        return $this->cp2.' '.$this->ville2;
    }
}
