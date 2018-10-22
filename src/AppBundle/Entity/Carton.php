<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Carton
 *
 * @ORM\Table(name="carton")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartonRepository")
 */
class Carton
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @return string
     */
    public function getCodeCarton()
    {
        return $this->code_carton;
    }

    /**
     * @param string $code_carton
     */
    public function setCodeCarton($code_carton)
    {
        $this->code_carton = $code_carton;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="CodeCarton", type="string", length=255)
     */
    private $code_carton;

    /**
     * @ORM\ManyToMany(targetEntity="Image", cascade={"all"}, fetch="EAGER")
     */
    private $image_carton;

    /**
     * @return mixed
     */
    public function getImageCarton()
    {
        return $this->image_carton;
    }

    /**
     * @param mixed $image_carton
     */
    public function setImageCarton($image_carton)
    {
        $this->image_carton = $image_carton;
    }



    /**
     * @var string
     *
     * @ORM\Column(name="Dimension", type="string", length=255)
     */
    private $dimension;

    /**
     * @var string
     *
     * @ORM\Column(name="Price", type="string", length=255)
     */
    private $price;

    /**
     * @return int
     */
    public function getNombreCarton()
    {
        return $this->nombre_carton;
    }

    /**
     * @param int $nombre_carton
     */
    public function setNombreCarton($nombre_carton)
    {
        $this->nombre_carton = $nombre_carton;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="nombre_carton", type="integer")
     */
    private $nombre_carton;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Carton
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set dimension
     *
     * @param string $dimension
     *
     * @return Carton
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return string
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Carton
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
     * Set description
     *
     * @param string $description
     *
     * @return Carton
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

    public function __construct()
    {
        $this->image_carton = new ArrayCollection();
        $this->path = 'carton';
        $this->cartonform = new ArrayCollection();
        $this->nombre_carton = 0;
    }

    public function __toString() {

        // Genereting list of the table result Cartons
       $arrayResult = [
            $this->nom,
            $this->dimension,
            $this->price,
           $this->image_carton[0]->getPath().'/'.$this->image_carton[0]->getFileName()

        ];

       dump($this->image_carton[0]->getPath().'/'.$this->image_carton[0]->getFileName());
    ///   exit();


        return implode('/*/',$arrayResult);
    }



    /**
     * @ORM\ManyToMany(targetEntity="CartonsForm")
     */
    private $cartonform;
}

