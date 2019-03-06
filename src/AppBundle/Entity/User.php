<?php
/**
 * Created by PhpStorm.
 * User: Win10
 * Date: 12.04.2018
 * Time: 20:35
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(name="age",type="integer", nullable=true)
     */
    protected $age;

    /**
     * @ORM\OneToMany(targetEntity="DevisConfig", mappedBy="user_id")
     */
    private $id_devis_conf;

    /**
     * @ORM\OneToMany(targetEntity="DevisEnvoye", mappedBy="user_id")
     */
    private $id_devis_envoye;


    /**
     * @ORM\OneToMany(targetEntity="MesDevis", mappedBy="user_id")
     */
    private $id_mes_devis;


    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=36, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=36, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="companyName", type="string", length=36, nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="company_email", type="string", length=36, nullable=true)
     */
    private $companyEmail;


    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=36, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=36, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=36, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=36, nullable=true)
     */
    private $street;



    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=36, nullable=true)
     */
    private $siret;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=64, nullable=true)
     */
    private $website;


    /**
     * @var string
     *
     * @ORM\Column(name="codePostal", type="string", length=36, nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=36, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=36, nullable=true)
     */
    private $country;


    /**
     * @ORM\OneToMany(targetEntity="DemandeDevis", mappedBy="societe_devis")
     */
    private $user_devis;

    /** @var string */
    private $switch_to_user;



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param string $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return mixed
     */
    public function getUserDevis()
    {
        return $this->user_devis;
    }

    /**
     * @param mixed $user_devis
     */
    public function setUserDevis($user_devis)
    {
        $this->user_devis = $user_devis;
    }



    /**
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param string $siret
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;
    }


    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }


    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }


    /**
     * @return array
     */
    public function getIdDevisConf()
    {
        return $this->id_devis_conf;
    }

    /**
     * @param DevisConfig $id_devis_conf
     */
    public function setIdDevisConf($id_devis_conf)
    {
        $this->id_devis_conf = $id_devis_conf;
    }


    /**
     * @return array
     */
    public function getIdDevisEnvoye()
    {
        return $this->id_devis_envoye;
    }

    /**
     * @param User $id_devis_envoye
     */
    public function setIdDevisEnvoye($id_devis_envoye)
    {
        $this->id_devis_envoye = $id_devis_envoye;
    }


    /**
     * @return string
     */
    public function getCompanyEmail()
    {
        return $this->companyEmail;
    }

    /**
     * @param string $companyEmail
     */
    public function setCompanyEmail($companyEmail)
    {
        $this->companyEmail = $companyEmail;
    }

    /**
     * @return string
     */
    public function getSwitchToUser()
    {
        return $this->username;
    }

    /**
     * @return User
     */
    public function getIdMesDevis()
    {
        return $this->id_mes_devis;
    }

    /**
     * @param array $id_mes_devis
     */
    public function setIdMesDevis($id_mes_devis)
    {
        $this->id_mes_devis = $id_mes_devis;
    }



}