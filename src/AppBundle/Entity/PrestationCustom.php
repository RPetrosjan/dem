<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * PrestationCustom
 *
 * @ORM\Table(name="prestation_custom")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestationCustomRepository")
 */
class PrestationCustom
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
     * @ORM\Column(type="string", unique=true)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="prestation", type="string", length=64)
     */
    private $prestation;

    /**
     * @var User
     *
     * @ManyToOne(targetEntity="User", inversedBy="id_mes_prestation", cascade={"persist"})
     */
    private $user_id;


    /**
     * @var string
     *
     * @ORM\Column(name="chargepar", type="string", length=64)
     */
    private $chargepar;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\PrestationDescription", cascade={"all"}, fetch="EAGER")
     */
    public $descriptions;

    /**
     * PrestationCustom constructor.
     */
    public function __construct()
    {
        $this->chargepar = 0;
        $this->descriptions = new ArrayCollection();
        $this->uuid = \Ramsey\Uuid\Uuid::uuid4();
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
    public function getChargepar()
    {
        return $this->chargepar;
    }

    /**
     * @param string $chargepar
     */
    public function setChargepar($chargepar)
    {
        $this->chargepar = $chargepar;
    }


    /**
     * Set prestation
     *
     * @param string $prestation
     *
     * @return PrestationCustom
     */
    public function setPrestation($prestation)
    {
        $this->prestation = $prestation;

        return $this;
    }

    /**
     * Get prestation
     *
     * @return string
     */
    public function getPrestation()
    {
        return $this->prestation;
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
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }



}

