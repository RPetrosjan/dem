<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;


/**
 * PrestationDescription
 *
 * @ORM\Table(name="prestation_description")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrestationDescriptionRepository")
 */
class PrestationDescription
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
     * @ORM\Column(name="description", type="string", length=128)
     */
    private $description;


    /**
     * @ORM\ManyToMany(targetEntity="PrestationCustom", mappedBy="descriptions")
     */
    private $custom_description;

    /**
     * @return mixed
     */
    public function getCollectiondescription()
    {
        return $this->collectiondescription;
    }

    /**
     * @param mixed $collectiondescription
     */
    public function setCollectiondescription($collectiondescription)
    {
        $this->collectiondescription = $collectiondescription;
    }

    /**
     * @return string
     */
    public function __toString(){

        return $this->description;

    }

    /**
     * @return mixed
     */
    public function getCustomDescription()
    {
        return $this->custom_description;
    }

    /**
     * @param mixed $custom_description
     */
    public function setCustomDescription($custom_description)
    {
        $this->custom_description = $custom_description;
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
     * Set description
     *
     * @param string $description
     *
     * @return PrestationDescription
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
}

