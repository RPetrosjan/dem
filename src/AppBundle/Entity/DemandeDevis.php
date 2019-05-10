<?php

namespace AppBundle\Entity;


use AppBundle\Repository\DemandeDevisRepository;
use AppBundle\Repository\ReadyDemandeDevisRepository;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\Devis as Devis;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * DemandeDevis
 *
 * @ORM\Table(name="demande_devis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeDevisRepository")
 */
class DemandeDevis
{

    use Devis;

    /**
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_demande_devis", cascade={"persist"})
     */
    private $ownerId;

    public function __toString()
    {
        if(is_null($this->nom)) {
            return '';
        }
         return  $this->nom;
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
        DemandeDevisRepository::
        $this->readed = $readed;
    }

    /**
     * DemandeDevis constructor.
     */
    public function __construct()
    {
        $this->DevisTraitConstruct();
    }

    /**
     * @return User
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param User $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;
    }

}

