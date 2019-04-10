<?php

namespace AppBundle\Entity;

use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 */
class Contact
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
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @return string
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * @param string $portable
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;


    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", length=255)
     */
    private $portable;

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;


    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created", type="datetime")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $CreatedDate;

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


    public function __construct()
    {
        $this->readed = false;
        $date = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
        $this->CreatedDate  = $date->setTimeZone(new DateTimeZone('Europe/Paris'));
    }

    /**
     * @return boolean
     */
    public function isReaded()
    {
        return $this->readed;
    }

    /**
     * @param boolean $readed
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;
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
     * Set name
     *
     * @param string $name
     *
     * @return Contact
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
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Contact
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

}

