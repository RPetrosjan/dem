<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * AdValorem
 *
 * @ORM\Table(name="ad_valorem")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdValoremRepository")
 */
class AdValorem
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
     * @ORM\Column(name="description", type="string", length=128, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=64)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="DevisEnvoye", inversedBy="id_advalorem", cascade={"persist", "remove"})
     */
    private $devis_id;


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
     * Set description
     *
     * @param string $description
     *
     * @return AdValorem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return AdValorem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return User
     */
    public function getDevisId()
    {
        return $this->devis_id;
    }

    /**
     * @param User $devis_id
     */
    public function setDevisId($devis_id)
    {
        $this->devis_id = $devis_id;
    }




}

