<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Distancematrix
 *
 * @ORM\Table(name="distancematrix")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DistancematrixRepository")
 */
class Distancematrix
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
     * @ORM\Column(name="cpfrom", type="string", length=16)
     */
    private $cpFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="villefrom", type="string", length=32)
     */
    private $villeFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="cpto", type="string", length=16)
     */
    private $cpTo;

    /**
     * @var string
     *
     * @ORM\Column(name="villeto", type="string", length=32)
     */
    private $villeTo;


    /**
     * @var string
     *
     * @ORM\Column(name="distance", type="string", length=64)
     */
    private $distance;


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
    public function getCpFrom()
    {
        return $this->cpFrom;
    }

    /**
     * @param string $cpFrom
     */
    public function setCpFrom($cpFrom)
    {
        $this->cpFrom = $cpFrom;
    }

    /**
     * @return string
     */
    public function getVilleFrom()
    {
        return $this->villeFrom;
    }

    /**
     * @param string $villeFrom
     */
    public function setVilleFrom($villeFrom)
    {
        $this->villeFrom = $villeFrom;
    }


    /**
     * Set cpTo
     *
     * @param string $cpTo
     *
     * @return Distancematrix
     */
    public function setCpTo($cpTo)
    {
        $this->cpTo = $cpTo;

        return $this;
    }

    /**
     * Get cpTo
     *
     * @return string
     */
    public function getCpTo()
    {
        return $this->cpTo;
    }

    /**
     * Set villeTo
     *
     * @param string $villeTo
     *
     * @return Distancematrix
     */
    public function setVilleTo($villeTo)
    {
        $this->villeTo = $villeTo;

        return $this;
    }

    /**
     * Get villeTo
     *
     * @return string
     */
    public function getVilleTo()
    {
        return $this->villeTo;
    }

    /**
     * @return string
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param string $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }


}

