<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * RIB
 *
 * @ORM\Table(name="r_i_b")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RIBRepository")
 */
class RIB
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
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_rib", cascade={"persist"})
     */
    private $user_id;

    /**
     * @var string
     *
     * @ORM\Column(name="Banque", type="string", length=32, nullable=true)
     */
    private $banque;

    /**
     * @var string
     *
     * @ORM\Column(name="Guichet", type="string", length=32, nullable=true)
     */
    private $guichet;

    /**
     * @var string
     *
     * @ORM\Column(name="NdeCompte", type="string", length=32, nullable=true)
     */
    private $ndeCompte;

    /**
     * @var string
     *
     * @ORM\Column(name="cleRib", type="string", length=32, nullable=true)
     */
    private $cleRib;

    /**
     * @var string
     *
     * @ORM\Column(name="nomtiTulaire", type="string", length=32, nullable=true)
     */
    private $nomTitulaire;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomTitulaire", type="string", length=32, nullable=true)
     */
    private $prenomTitulaire;

    /**
     * @var string
     *
     * @ORM\Column(name="Domiciliation", type="string", length=32, nullable=true)
     */
    private $domiciliation;

    /**
     * @var string
     *
     * @ORM\Column(name="nIbanInternational", type="string", length=64, nullable=true)
     */
    private $nIbanInternational;

    /**
     * @var string
     *
     * @ORM\Column(name="BIC", type="string", length=32, nullable=true)
     */
    private $bIC;


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
     * Set banque
     *
     * @param string $banque
     *
     * @return RIB
     */
    public function setBanque($banque)
    {
        $this->banque = $banque;

        return $this;
    }

    /**
     * Get banque
     *
     * @return string
     */
    public function getBanque()
    {
        return $this->banque;
    }

    /**
     * Set guichet
     *
     * @param string $guichet
     *
     * @return RIB
     */
    public function setGuichet($guichet)
    {
        $this->guichet = $guichet;

        return $this;
    }

    /**
     * Get guichet
     *
     * @return string
     */
    public function getGuichet()
    {
        return $this->guichet;
    }

    /**
     * Set ndeCompte
     *
     * @param string $ndeCompte
     *
     * @return RIB
     */
    public function setNdeCompte($ndeCompte)
    {
        $this->ndeCompte = $ndeCompte;

        return $this;
    }

    /**
     * Get ndeCompte
     *
     * @return string
     */
    public function getNdeCompte()
    {
        return $this->ndeCompte;
    }

    /**
     * Set cleRib
     *
     * @param string $cleRib
     *
     * @return RIB
     */
    public function setCleRib($cleRib)
    {
        $this->cleRib = $cleRib;

        return $this;
    }

    /**
     * Get cleRib
     *
     * @return string
     */
    public function getCleRib()
    {
        return $this->cleRib;
    }

    /**
     * @return string
     */
    public function getNomTitulaire()
    {
        return $this->nomTitulaire;
    }

    /**
     * @param string $nomTitulaire
     */
    public function setNomTitulaire($nomTitulaire)
    {
        $this->nomTitulaire = $nomTitulaire;
    }


    /**
     * Set prenomTitulaire
     *
     * @param string $prenomTitulaire
     *
     * @return RIB
     */
    public function setPrenomTitulaire($prenomTitulaire)
    {
        $this->prenomTitulaire = $prenomTitulaire;

        return $this;
    }

    /**
     * Get prenomTitulaire
     *
     * @return string
     */
    public function getPrenomTitulaire()
    {
        return $this->prenomTitulaire;
    }

    /**
     * Set domiciliation
     *
     * @param string $domiciliation
     *
     * @return RIB
     */
    public function setDomiciliation($domiciliation)
    {
        $this->domiciliation = $domiciliation;

        return $this;
    }

    /**
     * Get domiciliation
     *
     * @return string
     */
    public function getDomiciliation()
    {
        return $this->domiciliation;
    }

    /**
     * Set nIbanInternational
     *
     * @param string $nIbanInternational
     *
     * @return RIB
     */
    public function setNIbanInternational($nIbanInternational)
    {
        $this->nIbanInternational = $nIbanInternational;

        return $this;
    }

    /**
     * Get nIbanInternational
     *
     * @return string
     */
    public function getNIbanInternational()
    {
        return $this->nIbanInternational;
    }

    /**
     * Set bIC
     *
     * @param string $bIC
     *
     * @return RIB
     */
    public function setBIC($bIC)
    {
        $this->bIC = $bIC;

        return $this;
    }

    /**
     * Get bIC
     *
     * @return string
     */
    public function getBIC()
    {
        return $this->bIC;
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
}

