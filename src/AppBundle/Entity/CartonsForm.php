<?php

namespace AppBundle\Entity;

use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Ldap\Adapter\ExtLdap\Collection;

/**
 * CartonsForm
 *
 * @ORM\Table(name="cartons_form")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CartonsFormRepository")
 */
class CartonsForm
{

    /**
     * CartonsForm constructor.
     */
    public function __construct()
    {
        $this->readed = false;
        $date = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));
        $this->name = '';
        $this->carton = new ArrayCollection();
    }


    /**
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->CreatedDate;
    }

    /**
     * @param \DateTime $CreatedDate
     */
    public function setCreatedDate($CreatedDate)
    {
        $this->CreatedDate = $CreatedDate;
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
        $this->readed = $readed;
    }
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
     * @ORM\Column(name="Name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $CreatedDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    /**
     * @var string
     *
     * @ORM\Column(name="Forname", type="string", length=50, nullable=true)
     */
    private $forname;

    /**
     * @var string
     *
     * @ORM\Column(name="Tel", type="string", length=50, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="Portable", type="string", length=50, nullable=true)
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=50, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="CartonJson", type="string", length=255, nullable=true)
     */
    private $cartonJson;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     */
    private $email;


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
     * Set name
     *
     * @param string $name
     *
     * @return CartonsForm
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set forname
     *
     * @param string $forname
     *
     * @return CartonsForm
     */
    public function setForname($forname)
    {
        $this->forname = $forname;

        return $this;
    }

    /**
     * Get forname
     *
     * @return string
     */
    public function getForname()
    {
        return $this->forname;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return CartonsForm
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set portable
     *
     * @param string $portable
     *
     * @return CartonsForm
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return string
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return CartonsForm
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set cartonJson
     *
     * @param string $cartonJson
     *
     * @return CartonsForm
     */
    public function setCartonJson($cartonJson)
    {
        $this->cartonJson = $cartonJson;

        return $this;
    }

    /**
     * Get cartonJson
     *
     * @return string
     */
    public function getCartonJson()
    {
        return $this->cartonJson;
    }

    /**
     * @return mixed
     */
    public function getCarton()
    {
        return $this->carton;
    }

    /**
     * Remove twigs
     *
     * @param \AppBundle\Entity\Carton $carton
     */
    public function removeCarton(Carton $carton)
    {
        $this->carton->removeElement($carton);
    }

    /**
     * @param string \AppBundle\Entity\Carton $carton
     *
     * @return Carton
     */
    public function addCarton(Carton $carton)
    {
        $this->carton[] = $carton;
    }


    /**
     * @param mixed $carton
     */
    public function setCarton($carton)
    {
        $this->carton = $carton;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return CartonsForm
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Carton")
     */
    private $carton;



    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}

