<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ImageBande
 *
 * @ORM\Table(name="image_bande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageBandeRepository")
 */
class ImageBande
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
     * @ORM\ManyToOne(targetEntity="CpVille", cascade={"all"}, fetch="EAGER")
     */
    private $villeDepart;

    /**
     * @ORM\ManyToOne(targetEntity="CpVille", cascade={"all"}, fetch="EAGER")
     */
    private $villeArrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="Prix", type="string", length=255)
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="Prestation", cascade={"all"}, fetch="EAGER")
     */
    private $prestation;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;

    /**
     * ImageBande constructor.
     */
    public function __construct()
    {
        $this->imagebande = new ArrayCollection();
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
     * Set villeDepart
     *
     * @param string $villeDepart
     *
     * @return ImageBande
     */
    public function setVilleDepart($villeDepart)
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    /**
     * Get villeDepart
     *
     * @return string
     */
    public function getVilleDepart()
    {
        return $this->villeDepart;
    }

    /**
     * Set villeArrivee
     *
     * @param string $villeArrivee
     *
     * @return ImageBande
     */
    public function setVilleArrivee($villeArrivee)
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    /**
     * Get villeArrivee
     *
     * @return string
     */
    public function getVilleArrivee()
    {
        return $this->villeArrivee;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return ImageBande
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set prestation
     *
     * @param string $prestation
     *
     * @return ImageBande
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
     * Set description
     *
     * @param string $description
     *
     * @return ImageBande
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImagebande()
    {
        return $this->imagebande;
    }

    /**
     * @param mixed $imagebande
     */
    public function setImagebande($imagebande)
    {
        $this->imagebande = $imagebande;
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
     * @ORM\ManyToMany(targetEntity="Image", cascade={"all"}, fetch="EAGER")
     */
    private $imagebande;
}

