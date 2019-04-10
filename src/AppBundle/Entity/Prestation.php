<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\DemandeDevis;

/**
 * Prestation
 *
 * @ORM\Table(name="prestation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestationRepository")
 */
class Prestation
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
     * @var array
     *
     * @ORM\OneToMany(targetEntity="DemandeDevis", mappedBy="prestation")
     */
    private $devisPrestation;

    /**
     * @var string
     *
     * @ORM\Column(name="Prestation", type="string", length=255)
     */
    private $prestation;


    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;


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
     * Set prestation
     *
     * @param string $prestation
     *
     * @return Prestation
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

    public function __toString() {

        if(empty($this->prestation)) {
            return '';
        }

        return $this->prestation;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function getDevisPrestation()
    {
        return $this->devisPrestation;
    }

    /**
     * @param array $devisPrestation
     */
    public function setDevisPrestation($devisPrestation)
    {
        $this->devisPrestation = $devisPrestation;
    }

}

