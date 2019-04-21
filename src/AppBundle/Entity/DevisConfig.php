<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * DevisConfig
 *
 * @ORM\Table(name="devis_config")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DevisConfigRepository")
 */
class DevisConfig
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
     * @ORM\Column(name="tva", type="string", length=16)
     */
    private $tva;

    /**
     * @var string
     *
     * @ORM\Column(name="acompte", type="string", length=16)
     */
    private $acompte;

    /**
     * @var string
     *
     * @ORM\Column(name="franchise", type="string", length=16)
     */
    private $franchise;

    /**
     * @var string
     *
     * @ORM\Column(name="valglobale", type="string", length=16)
     */
    private $valglobale;

    /**
     * @var string
     *
     * @ORM\Column(name="parobjet", type="string", length=16)
     */
    private $parobjet;


    /**
     * @var string
     *
     * @ORM\Column(name="valable", type="string", length=16)
     */
    private $valable;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_devis_conf", cascade={"persist"})
     */
    private $user_id;


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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tva
     *
     * @param string $tva
     *
     * @return DevisConfig
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set acompte
     *
     * @param string $acompte
     *
     * @return DevisConfig
     */
    public function setAcompte($acompte)
    {
        $this->acompte = $acompte;

        return $this;
    }

    /**
     * Get acompte
     *
     * @return string
     */
    public function getAcompte()
    {
        return $this->acompte;
    }

    /**
     * Set franchise
     *
     * @param string $franchise
     *
     * @return DevisConfig
     */
    public function setFranchise($franchise)
    {
        $this->franchise = $franchise;

        return $this;
    }

    /**
     * Get franchise
     *
     * @return string
     */
    public function getFranchise()
    {
        return $this->franchise;
    }

    /**
     * Set valglobale
     *
     * @param string $valglobale
     *
     * @return DevisConfig
     */
    public function setValglobale($valglobale)
    {
        $this->valglobale = $valglobale;

        return $this;
    }

    /**
     * Get valglobale
     *
     * @return string
     */
    public function getValglobale()
    {
        return $this->valglobale;
    }

    /**
     * Set parobjet
     *
     * @param string $parobjet
     *
     * @return DevisConfig
     */
    public function setParobjet($parobjet)
    {
        $this->parobjet = $parobjet;

        return $this;
    }

    /**
     * Get parobjet
     *
     * @return string
     */
    public function getParobjet()
    {
        return $this->parobjet;
    }

    /**
     * Set valable
     *
     * @param string $valable
     *
     * @return DevisConfig
     */
    public function setValable($valable)
    {
        $this->valable = $valable;

        return $this;
    }

    /**
     * Get valable
     *
     * @return string
     */
    public function getValable()
    {
        return $this->valable;
    }


}

